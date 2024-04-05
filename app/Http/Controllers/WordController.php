<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $words = Word::all();

        return view('admin.words.index', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $word = new Word();
        $links = Link::select('id', 'name')->get();
        return view('admin.words.create', compact('word', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'word_name' => 'required|string|min:1|max:50|unique:words',
                'description' => 'required|string',
                // 'links' => 'nullable',
                // 'name_link' => 'required|string',url:http,https
                'urls' => 'required|string|unique:links',
            ],
            [
                'word_name.required' => 'La parola è obbligatoria',
                'word_name.unique' => 'La parola è già presente',
                'word_name.max' => 'La parola deve essere massimo di :max caratteri',
                'word_name.min' => 'La parola deve essere minimo più di :min caratteri',
                'description.required' => 'La descrizione è obbligatoria',
                // 'name_link.required' => 'Dai un nome alla fonte',
                // 'url.required' => 'Devi mettere un link per le fonti',
                // 'url.unique' => 'Fonte già usata',

            ]
        );
        $data = $request->all();
        // @dd($data);
        $new_word = new Word();
        $new_word->fill($data);
        $new_word->save();
        $length = count($data['urls']);
        // dd($length, $data);
        for ($i = 0; $i < $length; $i++) {
            if ($data['name_links'][$i] && $data['urls'][$i]) {
                $new_link = new Link();
                $new_link->name = $data['name_links'][$i];
                $new_link->url = $data['urls'][$i];
                $new_link->word_id = $new_word->id;
                $new_link->save();
            }
        }
        // foreach ($data['urls'] as $url) {
        //     $n
        // }
        return to_route('admin.words.show', $new_word);
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        return view('admin.words.show', compact('word'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word)
    {
        $links = Link::select('id', 'name')->get();
        $old_links = $word->links->pluck('id')->toArray();
        return view('admin.words.edit', compact('word', 'links', 'old_links'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Word $word)
    {
        $request->validate([
            'word_name' => ['required', 'string', 'min:1', 'max:50', Rule::unique('words')->ignore($word->id)],
            'description' => 'required|string',
            'links' => 'nullable|exists:links,id'
        ], [
            'word_name.required' => 'La parola è obbligatorio',
            'word_name.unique' => 'La parola è già presente',
            'word_name.min' => 'La parola deve essere almeno :min lunga',
            'word_name.max' => 'La parola deve essere massimo :max lunga',
            'description.required' => 'La descrizione è obbligatoria',
            'links.exists' => 'Il link usato non è contemplato'
        ]);

        $data = $request->all();

        $word->fill($data);

        $word->save();
        if (Arr::exists($data, 'links')) {
            foreach ($data['links'] as $id_link) {

                $ob_link = Link::whereId($id_link)->first();
                $ob_link->word_id = $word->id;
                $ob_link->save();
            }
        }
        return to_route('admin.words.show', $word)->with('message', 'Parola modificata con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        $word->delete();
        return to_route('admin.words.index')->with('type', 'danger')->with('message', 'Post eliminato con successo');
    }
}
