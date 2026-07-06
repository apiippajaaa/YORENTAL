<?php

namespace App\Http\Controllers\Backend;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use App\Models\CarPhoto;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $cars = Car::with(['category', 'photos'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('plate_number', 'like', '%' . $search . '%')
                    ->orWhere('price_per_day', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10);

        return view('pages.backend.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CarCategory::all();
        return view('pages.backend.cars.partials.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'car_category_id' => 'required|exists:car_categories,id',
            'plate_number' => 'required|string|max:255',
            'year' => 'required|integer',
            'seats' => 'required|integer',
            'transmission' => 'required|string',
            'color' => 'required|string|max:50',
            'price_per_12_hours' => 'required|numeric',
            'price_per_day' => 'required|numeric',
            'description' => 'nullable|string',
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $car = new Car();
        $car->name = $validated['name'];
        $car->car_category_id = $validated['car_category_id'];
        $car->plate_number = $validated['plate_number'];
        $car->year = $validated['year'];
        $car->seats = $validated['seats'];
        $car->transmission = $validated['transmission'];
        $car->color = $validated['color'];
        $car->price_per_12_hours = $validated['price_per_12_hours'];
        $car->price_per_day = $validated['price_per_day'];
        $car->description = $validated['description'];
        $car->save();

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {

                $path = $file->store('cars/photos', 'public');

                $carPhoto = new CarPhoto();
                $carPhoto->car_id = $car->id;
                $carPhoto->photo_path = $path;
                $carPhoto->save();
            }
        }

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan!');
    }






    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load('photos', 'category');

        return view('pages.backend.cars.partials.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $categories = CarCategory::all();
        $car->load('photos');
        return view('pages.backend.cars.partials.edit', compact('car', 'categories'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'car_category_id' => 'required|exists:car_categories,id',
            'plate_number' => 'required|string|max:255',
            'year' => 'required|integer',
            'seats' => 'required|integer',
            'transmission' => 'required|string',
            'color' => 'required|string|max:50',
            'price_per_12_hours' => 'required|numeric',
            'price_per_day' => 'required|numeric',
            'description' => 'nullable|string',
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $car->name = $validated['name'];
        $car->car_category_id = $validated['car_category_id'];
        $car->plate_number = $validated['plate_number'];
        $car->year = $validated['year'];
        $car->seats = $validated['seats'];
        $car->transmission = $validated['transmission'];
        $car->color = $validated['color'];
        $car->price_per_12_hours = $validated['price_per_12_hours'];
        $car->price_per_day = $validated['price_per_day'];
        $car->description = $validated['description'];
        $car->save();

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $path = $file->store('cars/photos', 'public');

                $carPhoto = new CarPhoto();
                $carPhoto->car_id = $car->id;
                $carPhoto->photo_path = $path;
                $carPhoto->save();
            }
        }

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diupdate!');
    }



    public function destroyPhoto($id)
    {
        $photo = CarPhoto::findOrFail($id);
        Storage::delete($photo->photo_path);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $hasActiveRental = $car->rentals()
            ->whereIn('status', ['menunggu_konfirmasi', 'booked'])
            ->exists();

        if ($hasActiveRental) {
            return redirect()->route('cars.index')->withErrors([
                'msg' => 'Mobil tidak bisa dihapus karena masih ada penyewaan aktif.'
            ]);
        }

        foreach ($car->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
