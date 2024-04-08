<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Word;
use App\Models\Tag;
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
        $tags = Tag::all();

        return view('admin.words.index', compact('words', 'tags'));
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
                // url:http,https
                'word_name' => 'required|string|min:1|max:50|unique:words',
                'description' => 'required|string',
                'links' => 'nullable|array',
                'links.*.name' => 'nullable|string',
                'links.*.url' => 'nullable|url:http,https|unique:links,url',

            ],
            [
                'word_name.required' => 'La parola è obbligatoria',
                'word_name.unique' => 'La parola è già presente',
                'word_name.max' => 'La parola deve essere massimo di :max caratteri',
                'word_name.min' => 'La parola deve essere minimo più di :min caratteri',
                'description.required' => 'La descrizione è obbligatoria',
                'links.*.url.url' => 'Link non valido',
                'links.*.url.unique' => 'Fonte già usata',
            ]
        );
        $data = $request->all();
        // dd($data);
        $new_word = new Word();
        $new_word->fill($data);
        $new_word->save();
        if (array_key_exists('links', $data)) {
            foreach ($data['links'] as $link) {
                if ($link['name'] && $link['url']) {
                    $new_link = new Link();
                    $new_link->name = $link['name'];
                    $new_link->url = $link['url'];
                    $new_link->word_id = $new_word->id;
                    $new_link->save();
                }
            }
        }
        return to_route('admin.words.show', $new_word);
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        $tags = Tag::all();
        return view('admin.words.show', compact('word', 'tags'));
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
        // dd($word->links);
        $request->validate([
            'word_name' => ['required', 'string', 'min:1', 'max:50', Rule::unique('words')->ignore($word->id)],
            'description' => 'required|string',
            'name_links' => 'nullable|array',
            'links.*.name' => 'nullable|string',
            // 'links.*.url' => 'nullable|url:http,https|unique:links,url',
            // 'links.*.url' => ['nullable', 'url', Rule::unique('links,url')->ignore($word->links->word_id)],
            // 'nullable|url:http,https|unique:links,url',
            // ['nullable', 'url', Rule::unique('links,url')->ignore($word->links->id)],
        ], [
            'word_name.required' => 'La parola è obbligatorio',
            'word_name.unique' => 'La parola è già presente',
            'word_name.min' => 'La parola deve essere almeno :min lunga',
            'word_name.max' => 'La parola deve essere massimo :max lunga',
            'description.required' => 'La descrizione è obbligatoria',
            'links.*.url.url' => 'Link non valido',
            'links.*.url.unique' => 'Fonte già usata',
        ]);

        $data = $request->all();
        $word->fill($data);

        $word->save();
        // Controllo che arrivino dei links
        if (array_key_exists('links', $data)) {
            // Rinomino i link degli input
            $input_links = $data['links'];
            // Faccio un ciclo lungo quanti gli input arrivati
            for ($i = 0; $i < count($input_links); $i++) {
                // Recupero il link
                $link = $input_links["link-$i"];
                // Controllo se ha  modificato alcuni link esistenti
                if ($i < count($word->links)) {
                    if (!$link['name'] && !$link['url']) $word->links[$i]->delete();
                    if ($link['name'] && $link['url']) {
                        $word->links[$i]->name = $link['name'];
                        $word->links[$i]->url = $link['url'];
                        $word->links[$i]->save();
                    }
                    // Altrimenti creo dei nuovi link 
                } else {
                    if ($link['name'] && $link['url']) {
                        $new_link = new Link();
                        $new_link->name = $link['name'];
                        $new_link->url = $link['url'];
                        $new_link->word_id = $word->id;
                        $new_link->save();
                    }
                }
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

        return to_route('admin.words.index')
            ->with('toast-button-type', 'danger')
            ->with('toast-message', 'Progetto eliminato')
            ->with('toast-label', config('app.name'))
            ->with('toast-method', 'PATCH')
            // ->with('toast-route', route('admin.words.restore', $project->id))
            ->with('toast-route', 'NADA')
            ->with('toast-button-label', 'Annulla');
    }
}
