<?php

namespace App\Http\Controllers\Frontend;

use App\Models\faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faq = faq::all();
        return view('pages.backend.personalize.faq.index', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.personalize.faq.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:128',
            'answer' => 'required|string|max:512',

        ]);

        $faq = new faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;

        $faq->save();

        return redirect()->route('faqs.index')->with('success', 'Faq berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(faq $faq)
    {
        return view('pages.backend.personalize.faq.partials.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:128',
            'answer' => 'required|string|max:512',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('faqs.index')->with('success', 'Faq berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(faq $faq)
    {
        $faq->delete();
        return redirect()->route('faqs.index')->with('success', 'Faq berhasil dihapus!');
    }
}
