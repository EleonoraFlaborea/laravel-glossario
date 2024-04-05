<?php

namespace App\Http\Controllers\Guest;

use App\Models\Word;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $words = Word::all();
        return view('guest.home', compact('words'));
    }

    public function show(Word $word)
    {
        $tags = Tag::all();
        return view('guest.words.show', compact('word', 'tags'));
    }
}
