<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::all();
        return view('admin.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable|string',
            'url' => 'nullable|url:http,https',
        ], [
            'url.url' => 'L\'url inserito non è valido'
        ]);

        $data = $request->all();
        $link = new Link();
        $link->fill($data);
        $link->save();

        return to_route('admin.links.index')->with('message', 'Url creato con successo')->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        return view('admin.links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'name' => 'nullable|string',
            'url' => 'nullable|url:http,https',
        ], [
            'url.url' => 'L\'url inserito non è valido'
        ]);

        $data = $request->all();
        $link->update($data);

        return to_route('admin.links.index')->with('message', 'Url modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return to_route('admin.links.index')->with('message', 'Url eliminato con successo')->with('type', 'success');
    }
}
