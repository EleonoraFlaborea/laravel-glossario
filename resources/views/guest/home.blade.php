@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="container pb-5">

        <h1 class="py-3 text-center">GLOSSARIO</h1>
        <div class="row g-4">

            @forelse($words as $word)
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $word->word_name }}</h5>
                                <a href="{{ route('guest.words.show', $word) }}" class="btn btn-sm btn-primary">VEDI</a>
                            </div>
                            <div class="pb-2">
                                @forelse($word->tags as $tag)
                                    <span class="badge rounded-pill"
                                        style="background-color: {{ $tag->color }}">{{ $tag->label }}</span>
                                @empty
                                    N/A
                                @endforelse
                            </div>
                            <p class="card-text">
                                {{ $word->getAbstract() }}
                                ...
                            </p>

                            @forelse ($word->links as $link)
                                <a href="{{ $link->url }}">{{ $link->name }}</a>
                            @empty
                                <p class="m-0"><i>Nessun Link</i></p>
                            @endforelse

                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <h3 class="text-center">Non ci sono parole</h3>
                </div>
            @endforelse


        </div>
    </div>

@endsection
