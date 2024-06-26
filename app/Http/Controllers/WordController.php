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
        $tags = Tag::select('id', 'label')->get();
        return view('admin.words.create', compact('word', 'links', 'tags'));
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
                'links' => 'nullable|array',
                'links.*.name' => 'nullable|string',
                'links.*.url' => 'nullable|url:http,https',

            ],
            [
                'word_name.required' => 'La parola è obbligatoria',
                'word_name.unique' => 'La parola è già presente',
                'word_name.max' => 'La parola deve essere massimo di :max caratteri',
                'word_name.min' => 'La parola deve essere minimo più di :min caratteri',
                'description.required' => 'La descrizione è obbligatoria',
                'links.*.url.url' => 'Link non valido o inserire un url completo'
            ]
        );
        $data = $request->all();
        $new_word = new Word();
        $new_word->fill($data);
        $new_word->word_name = ucfirst($new_word->word_name);
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

        // Creo il legame con possibili tags
        if (Arr::exists($data, 'tags')) $new_word->tags()->sync($data['tags']);

        return to_route('admin.words.index', $new_word)->with('message', 'Parola creata con successo')->with('type', 'success');
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
        $tags = Tag::select('id', 'label')->get();
        $old_links = $word->links->pluck('id')->toArray();
        $old_tags = $word->tags->pluck('id')->toArray();
        return view('admin.words.edit', compact('word', 'links', 'tags', 'old_links', 'old_tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Word $word)
    {
        $request->validate([
            'word_name' => ['required', 'string', 'min:1', 'max:50', Rule::unique('words')->ignore($word->id)],
            'description' => 'required|string',
            'name_links' => 'nullable|array',
            'links.*.name' => 'nullable|string',
            'links.*.url' => 'nullable|url:http,https',
        ], [
            'word_name.required' => 'La parola è obbligatorio',
            'word_name.unique' => 'La parola è già presente',
            'word_name.min' => 'La parola deve essere almeno :min lunga',
            'word_name.max' => 'La parola deve essere massimo :max lunga',
            'description.required' => 'La descrizione è obbligatoria',
            'links.*.url.url' => 'Link non valido o inserire un url completo',
        ]);

        $data = $request->all();
        $word->fill($data);
        $word->word_name = ucfirst($word->word_name);
        $word->save();

        // Controllo che arrivino dei links
        if (array_key_exists('links', $data)) {
            $word->links()->delete();
            foreach ($data['links'] as $link) {
                if ($link['name'] && $link['url']) {
                    $new_link = new Link();
                    $new_link->name = $link['name'];
                    $new_link->url = $link['url'];
                    $new_link->word_id = $word->id;
                    $new_link->save();
                }
            }
        }

        // Aggiorno il legame tra i tag e le tecnologie
        if (Arr::exists($data, 'tags')) $word->tags()->sync($data['tags']);
        elseif (!Arr::exists($data, 'tags') && $word->has('tags')) $word->tags()->detach();

        return to_route('admin.words.index', $word)->with('message', 'Parola modificata con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        $word->delete();

        return to_route('admin.words.index')
            ->with('toast-button-type', 'danger')
            ->with('toast-message', 'Eliminazione avvenuta con successo')
            ->with('toast-label', config('app.name'))
            ->with('toast-method', 'PATCH')
            ->with('toast-route', route('admin.words.restore', $word->id))
            ->with('toast-button-label', 'Annulla');
    }

    // * Rotte Soft Delete

    public function trash()
    {
        $words = Word::onlyTrashed()->get();
        return view('admin.words.trash', compact('words'));
    }

    public function restore(Word $word)
    {
        $word->restore();
        return to_route('admin.words.index')->with('type', 'success')->with('message', 'Parola ripristinata con successo');
    }

    public function drop(Word $word)
    {

        if ($word->has('tags')) $word->tags()->detach();

        $word->forceDelete();

        return to_route('admin.words.trash')->with('type', 'warning')->with('message', 'Parola eliminata definitivamente con successo');
    }

    // Rotte Delete All e Restore all
    public function massiveDrop()
    {
        $words = Word::onlyTrashed()->get();
        foreach ($words as $word) {
            $word->forceDelete();
        }
        return to_route('admin.words.trash')->with('type', 'warning')->with('message', 'Tutti i progetti sono stati eliminati definitivamente con successo');
    }

    public function massiveRestore()
    {
        $words = Word::onlyTrashed()->get();
        foreach ($words as $word) {
            $word->restore();
        }
        return to_route('admin.words.index')->with('type', 'success')->with('message', 'Tutti i progetti sono stati ripristinati con successo');
    }
}
