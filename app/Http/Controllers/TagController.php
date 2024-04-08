<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderByDesc('updated_at')->orderByDesc('created_at')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = new Tag();
        $tags = Tag::select('label', 'color')->get();

        return view('admin.tags.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique:tags',
            'color' => 'required|string|unique:tags',

        ], [
            'label.required' => 'Il nome è obbligatorio',
            'label.unique' => 'Non possono esistere due tag con lo stesso nome',
            'color.required' => 'Il colore è obbligatorio',
            'color.unique' => 'Non possono esistere due tag con lo stesso colore',
        ]);



        $data = $request->all();

        $tag = new Tag();
        $tag->fill($data);

        $tag->save();

        return to_route('admin.tags.index', $tag)->with('message', 'Tag creato con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {

        $request->validate([
            'label' => ['required', 'string', Rule::unique('tags')->ignore($tag->id)],
            'color' => ['required', 'string', Rule::unique('tags')->ignore($tag->id)],

        ], [
            'label.required' => 'Il nome è obbligatorio',
            'label.unique' => 'Non possono esistere due tag con lo stesso nome',
            'color.required' => 'Il colore è obbligatorio',
            'color.unique' => 'Non possono esistere due tag con lo stesso colore',
        ]);


        $data = $request->all();
        $tag->fill($data);

        $tag->save();

        return to_route('admin.tags.index', $tag)->with('message', 'Tag modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return to_route('admin.tags.index')->with('type', 'danger')->with('message', 'Tag eliminato con successo');
    }
}
