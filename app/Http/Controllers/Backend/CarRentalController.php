<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarRental;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BookingNotification;
use Carbon\Carbon;

class CarRentalController extends Controller
{
    public function index(Request $request)
    {
        // $rentals = CarRental::with(['car', 'user'])->get();
        // return view('pages.backend.cars.ketersediaan.index', compact('rentals'));

        $query = CarRental::with(['user', 'car']);

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', $request->start_date);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('sort_status')) {
            $query->orderBy('status', $request->sort_status);
        } else {

            $query->orderBy('created_at', 'desc');
        }
        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $rentals */
        $rentals = $query->paginate(10)->withQueryString();

        $statusOptions = [
            'all' => 'Semua',
            'booked' => 'Booked',
            'on_rent' => 'Sedang Disewa',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            'ditolak' => 'Ditolak',
            'menunggu konfirmasi' => 'Menunggu Konfirmasi',
        ];

        return view('pages.backend.cars.ketersediaan.index', compact('rentals', 'statusOptions'));
    }

    public function create()
    {
        $cars = Car::all();
        $users = User::all();
        return view('pages.backend.cars.ketersediaan.partials.create', compact('cars', 'users'));
    }

    public function store(Request $request, CarRental $carRental)
    {
        $request->validate([
            'nama_perental' => 'required|string|max:100',
            'car_id' => 'required|exists:cars,id',
            'duration_type' => 'required|in:12,24,custom',
            'start_date' => 'required|date',
            // 'driver_type' => 'required|in:none,near,far',
            // 'with_fuel' => 'required|in:0,1',

            'with_driver' => 'required|in:0,1',
            'driver_days' => 'nullable|integer|min:1|required_if:with_driver,1',

            'with_fuel' => 'required|in:0,1',
            'fuel_days' => 'nullable|integer|min:1|required_if:with_fuel,1',
            'custom_duration' => 'nullable|required_if:duration_type,custom|integer|min:1',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $userId = 1;
        $namaLengkap = $request->nama_perental . ' - Offline';

        $car = Car::findOrFail($request->car_id);
        $start = Carbon::parse($request->start_date);

        // Hitung harga, tanggal selesai, dan diskon
        [$totalPrice, $discount, $end] = $this->calculateOfflineRentalPrice(
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
            return back()->withErrors(['start_date' => 'Mobil ini sudah dibooking pada tanggal tersebut. Silakan pilih tanggal lain.']);
        }

        $booking = CarRental::create([
            'user_id' => $userId,
            'nama' => $namaLengkap,
            'car_id' => $car->id,
            'duration_type' => $request->duration_type,
            'custom_duration' => $request->custom_duration,
            'start_date' => $start,
            'end_date' => $end,
            // 'driver_type' => $validated['driver_type'],
            // 'with_fuel' => $validated['with_fuel'],

            'with_driver' => $request->with_driver == '1',
            'driver_days' => $request->with_driver == '1' ? $request->driver_days : null,

            'with_fuel' => $request->with_fuel == '1',
            'fuel_days' => $request->with_fuel == '1' ? $request->fuel_days : null,

            'discount' => $discount,
            'total_price' => $totalPrice,
            'status' => 'menunggu_konfirmasi',
        ]);

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

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new BookingNotification($booking));
        }

        return redirect()->route('car_rentals.index')->with('success', 'Penyewaan mobil berhasil dibuat!');
    }

    private function calculateOfflineRentalPrice($car, $durationType, $customDuration, $withDriver, $driverDays, $withFuel, $startDate)
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

    public function show($id)
    {
        $rental = CarRental::with(['user', 'car'])->findOrFail($id);

        return view('pages.backend.cars.ketersediaan.partials.show', compact('rental'));
    }





    public function edit($id)
    {
        $rental = CarRental::findOrFail($id);
        $cars = Car::all();
        $users = User::all();

        return view('pages.backend.cars.ketersediaan.partials.edit', compact('rental', 'cars', 'users'));
    }
    public function update(Request $request, CarRental $carRental)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'duration_type' => 'required|in:12,24,custom',
            'custom_duration' => 'nullable|required_if:duration_type,custom|integer|min:1',
            'start_date' => 'required|date',
            'status' => 'required|in:menunggu_konfirmasi,booked,on_rent,selesai,dibatalkan,ditolak',
            'with_driver' => 'required|in:0,1',
            'driver_days' => 'nullable|integer|min:1|required_if:with_driver,1',
            'with_fuel' => 'required|in:0,1',
            'fuel_days' => 'nullable|integer|min:1|required_if:with_fuel,1',
        ]);

        $car = Car::findOrFail($request->car_id);
        $start = Carbon::parse($request->start_date);
        $basePrice = 0;
        $discount = 0;

        if ($request->duration_type === '12') {
            $end = (clone $start)->addHours(12);
            $basePrice = $car->price_per_12_hours;
        } elseif ($request->duration_type === '24') {
            $end = (clone $start)->addHours(24);
            $basePrice = $car->price_per_day;
        } else {
            $customDays = $request->custom_duration ?? 1;
            $end = (clone $start)->addDays($customDays);
            $basePrice = $customDays * $car->price_per_day;
            $discount = floor($customDays / 3) * 50000;
        }

        // Cek bentrok jadwal (kecuali dirinya sendiri)
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
            return back()->withErrors(['start_date' => 'Mobil sudah dibooking pada tanggal tersebut.'])->withInput();
        }

        // Hitung biaya tambahan
        $driverPrice = $request->with_driver == '1' ? (intval($request->driver_days) * 200000) : 0;
        $fuelPrice = $request->with_fuel == '1' ? (intval($request->fuel_days) * 200000) : 0;

        $totalPrice = ($basePrice - $discount) + $driverPrice + $fuelPrice;

        $carRental->update([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'duration_type' => $request->duration_type,
            'custom_duration' => $request->duration_type === 'custom' ? $request->custom_duration : null,
            'start_date' => $start,
            'end_date' => $end,
            'with_driver' => $request->with_driver == '1',
            'driver_days' => $request->with_driver == '1' ? $request->driver_days : null,
            'with_fuel' => $request->with_fuel == '1',
            'fuel_days' => $request->with_fuel == '1' ? $request->fuel_days : null,
            'discount' => $discount,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('car_rentals.index')->with('success', 'Penyewaan mobil berhasil diperbarui!');
    }




    public function destroy(CarRental $carRental)
    {
        $carRental->delete();
        return redirect()->route('car_rentals.index')->with('success', 'Penyewaan mobil berhasil dihapus!');
    }
}
