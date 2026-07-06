<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarRental;
use App\Models\User;
use App\Notifications\BookingNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarBookingController extends Controller
{
    public function status(Request $request)
    {
        $rentals = CarRental::where('user_id', auth()->id())->get();
        return view('pages.frontend.cars.booking.status', compact('rentals'));
    }

    public function create(Request $request)
    {
        $car = Car::findOrFail($request->car_id);
        return view('pages.frontend.cars.booking.create', compact('car'));
    }

    public function store(Request $request, CarRental $carRental)
    {

        // dd($request->all());
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'duration_type' => 'required|in:12,24,custom',
            'custom_duration' => 'required_if:duration_type,custom|nullable|integer|min:1',
            'start_date' => 'required|date|after_or_equal:now',

            'with_driver' => 'required|in:0,1',
            'driver_days' => 'nullable|integer|min:1|required_if:with_driver,1',

            'with_fuel' => 'required|in:0,1',
            'fuel_days' => 'nullable|integer|min:1|required_if:with_fuel,1',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $car = Car::findOrFail($request->car_id);
        $start = Carbon::parse($request->start_date);

        // Hitung harga, diskon, dan tanggal selesai
        [$totalPrice, $discount, $end] = $this->calculateTotalPrice(
            $car,
            $request->duration_type,
            $request->custom_duration,
            $request->with_driver,
            $request->driver_days,
            $request->with_fuel,
            $start
        );

        // Cek konflik booking
        $conflict = CarRental::where('car_id', $car->id)
            ->where('id', '!=', $carRental->id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['start_date' => 'Mobil sudah dibooking pada tanggal tersebut. Silakan pilih waktu lain.'])->withInput();
        }

        // Simpan booking
        $booking = CarRental::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $start,
            'end_date' => $end,
            'duration_type' => $request->duration_type,
            'custom_duration' => $request->custom_duration,
            'with_driver' => $request->with_driver == '1',
            'driver_days' => $request->with_driver == '1' ? $request->driver_days : null,

            'with_fuel' => $request->with_fuel == '1',
            'fuel_days' => $request->with_fuel == '1' ? $request->fuel_days : null,

            'discount' => $discount,
            'total_price' => $totalPrice,
            'status' => 'menunggu_konfirmasi',
        ]);

        // Upload dokumen
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('rental_documents', $filename, 'public');

                $booking->documents()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Notifikasi ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new BookingNotification($booking));
        }

        return redirect()->route('booking.status')->with('success', 'Booking berhasil dilakukan!');
    }



    private function calculateTotalPrice($car, $durationType, $customDuration, $withDriver, $driverDays, $withFuel, $startDate)
    {
        $discount = 0;
        $days = 1;
        $price = 0;

        if (!($startDate instanceof \Carbon\Carbon)) {
            $startDate = Carbon::parse($startDate);
        }

        // Hitung tanggal akhir dan harga dasar sewa mobil
        if ($durationType === '12') {
            $endDate = (clone $startDate)->addHours(12);
            $price = $car->price_per_12_hours;
            $days = 0.5;
        } elseif ($durationType === '24') {
            $endDate = (clone $startDate)->addHours(24);
            $price = $car->price_per_day;
            $days = 1;
        } else {
            $days = $customDuration ?? 1;
            $endDate = (clone $startDate)->addDays($days);
            $price = $days * $car->price_per_day;

            // Diskon setiap 3 hari: Rp50.000
            $discount = floor($days / 3) * 50000;
            $price -= $discount;
        }

        // Biaya sopir per hari 
        $driverCost = 0;
        if ($withDriver == '1' || $withDriver === 1 || $withDriver === true) {
            $driverCost = 200000 * ($driverDays ?? ceil($days));
        }

        // Biaya BBM per 3 hari 
        $fuelCost = 0;
        if ($withFuel == '1' || $withFuel === 1 || $withFuel === true) {
            $fuelCost = 200000 * ($fuelDays ?? ceil($days));
        }

        $total = $price + $driverCost + $fuelCost;

        return [$total, $discount, $endDate];
    }
}
