<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word)
    {
        return view('admin.words.edit', compact('word'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Word $word)
    {
        $request->validate([
            'word_name' => 'required|string|min:1|max:50|unique:words',
            'description' => 'required|text',
        ], [
            'word_name.required' => 'La parola è obbligatorio',
            'word_name.unique' => 'La parola è già presente',
            'word_name.min' => 'La parola deve essere almeno :min lunga',
            'word_name.max' => 'La parola deve essere massimo :max lunga',
            'description.required' => 'La descrizione è obbligatoria',
        ]);

        $data = $request->all();

        $word->fill($data);

        $word->save();

        return to_route('admin.words.show', $word)->with('message', 'Parola modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        //
    }
}
