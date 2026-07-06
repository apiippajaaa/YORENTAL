<?php

namespace App\Http\Controllers\Backend;

use App\Models\CarCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CarCategory::all();
        return view('pages.backend.cars.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.cars.categories.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CarCategory::create($request->all());

        return redirect()->route('car-categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarCategory $carCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarCategory $carCategory)
    {
        return view('pages.backend.cars.categories.partials.edit', compact('carCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarCategory $carCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $carCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('car-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarCategory $carCategory)
    {
        $carCategory->delete();

        return redirect()->route('car-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
