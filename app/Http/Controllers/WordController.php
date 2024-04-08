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
                'name_links' => 'nullable|array',
                'name_links.*' => 'nullable|string',
                'urls' => 'nullable|array',
                'urls.*' => 'nullable|url:http,https|unique:links,url',

            ],
            [
                'word_name.required' => 'La parola è obbligatoria',
                'word_name.unique' => 'La parola è già presente',
                'word_name.max' => 'La parola deve essere massimo di :max caratteri',
                'word_name.min' => 'La parola deve essere minimo più di :min caratteri',
                'description.required' => 'La descrizione è obbligatoria',
                'urls.*.url' => 'Link non valido',
                'urls.*.unique' => 'Fonte già usata',
            ]
        );
        // dd($data);
        $data = $request->all();
        $new_word = new Word();
        $new_word->fill($data);
        $new_word->save();
        if ($data['urls']) {
            $length = count($data['urls']);
            for ($i = 0; $i < $length; $i++) {
                if ($data['name_links'][$i] && $data['urls'][$i]) {
                    $new_link = new Link();
                    $new_link->name = $data['name_links'][$i];
                    $new_link->url = $data['urls'][$i];
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
        $request->validate([
            'word_name' => ['required', 'string', 'min:1', 'max:50', Rule::unique('words')->ignore($word->id)],
            'description' => 'required|string',
            'name_links' => 'nullable|array',
            'name_links.*' => 'nullable|string',
            'urls' => 'nullable|array',
            'urls.*' => 'nullable|url:http,https|unique:links,url',
        ], [
            'word_name.required' => 'La parola è obbligatorio',
            'word_name.unique' => 'La parola è già presente',
            'word_name.min' => 'La parola deve essere almeno :min lunga',
            'word_name.max' => 'La parola deve essere massimo :max lunga',
            'description.required' => 'La descrizione è obbligatoria',
            'urls.*.url' => 'Link non valido',
            'urls.*.unique' => 'Fonte già usata',

        ]);

        $data = $request->all();

        $word->fill($data);

        $word->save();
        if ($data['urls']) {
            $length = count($data['urls']);
            for ($i = 0; $i < $length; $i++) {
                if ($data['name_links'][$i] && $data['urls'][$i]) {
                    $new_link = new Link();
                    $new_link->name = $data['name_links'][$i];
                    $new_link->url = $data['urls'][$i];
                    $new_link->word_id = $word->id;
                    $new_link->save();
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
            ->with('toast-route', route('admin.words.restore', $word->id))
            ->with('toast-button-label', 'Annulla');
    }

        // * Rotte Soft Delete
    
        public function trash(){
            $words = Word::onlyTrashed()->get();
            return view('admin.words.trash', compact('words'));
        }
        
        public function restore(Word $word){
            $word->restore();
            return to_route('admin.words.index')->with('type', 'success')->with('message', 'Progetto ripristinato con successo');
        }
        
        public function drop(Word $word){
    
            if($word->has('tags')) $word->tags()->detach();

            $word->forceDelete();
    
            return to_route('admin.words.trash')->with('type', 'warning')->with('message', 'Progetto eliminato definitivamente con successo');
        }

        // Rotte Delete All e Restore all
        public function massiveDrop(){
            $words = Word::onlyTrashed()->get();
            foreach($words as $word){
                $word->forceDelete();
            }
            return to_route('admin.words.trash')->with('type', 'warning')->with('message', 'Tutti i progetti sono stati eliminati definitivamente con successo');
        }

        public function massiveRestore(){
            $words = Word::onlyTrashed()->get();
            foreach($words as $word){
                $word->restore();
            }
            return to_route('admin.words.index')->with('type', 'success')->with('message', 'Tutti i progetti sono stati ripristinati con successo');
        }
    
}
