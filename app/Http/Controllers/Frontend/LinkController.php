<?php

namespace App\Http\Controllers\Frontend;

use App\Models\link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $link = link::all();
        return view('pages.backend.personalize.link.index', compact('link'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.personalize.link.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:128',
            'title' => 'required|string|max:128',
            'account' => 'required|string|max:128',
            'url' => 'required|string|max:128',

        ]);

        $link = new link();
        $link->icon = $request->icon;
        $link->title = $request->title;
        $link->account = $request->account;
        $link->url = $request->url;

        $link->save();

        return redirect()->route('links.index')->with('success', 'link berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(link $link)
    {
        return view('pages.backend.personalize.link.partials.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, link $link)
    {
        $request->validate([
            'icon' => 'required|string|max:128',
            'title' => 'required|string|max:128',
            'account' => 'required|string|max:128',
            'url' => 'required|string|max:128',
        ]);

        $link->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'account' => $request->account,
            'url' => $request->url,
        ]);

        return redirect()->route('links.index')->with('success', 'link berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(link $link)
    {
        $link->delete();
        return redirect()->route('links.index')->with('success', 'link berhasil dihapus!');
    }
}
