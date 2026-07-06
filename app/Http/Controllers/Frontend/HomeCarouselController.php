<?php

namespace App\Http\Controllers\Frontend;

use App\Models\HomeCarousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HomeCarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $homecarousels = HomeCarousel::all();
        return view('pages.backend.personalize.home-carousel.index', compact('homecarousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.personalize.home-carousel.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('carousels', 'public');

        HomeCarousel::create(['image' => $path]);

        return redirect()->route('home-carousel.index')->with('success', 'Gambar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeCarousel $homeCarousel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeCarousel $homeCarousel)
    {
        return view('pages.backend.personalize.home-carousel.partials.edit', compact('homeCarousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeCarousel $homeCarousel)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($homeCarousel->image);

            $path = $request->file('image')->store('carousels', 'public');
            $homeCarousel->update(['image' => $path]);
        }

        return redirect()->route('home-carousel.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeCarousel $homeCarousel)
    {
        Storage::disk('public')->delete($homeCarousel->image);
        $homeCarousel->delete();

        return redirect()->route('home-carousel.index')->with('success', 'Gambar berhasil dihapus.');
    }
}
