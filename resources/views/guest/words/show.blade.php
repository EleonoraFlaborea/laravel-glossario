@extends('layouts.app')

@section('content')
    <div class="container w-75 m-auto">
        <div class="card mt-5">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ $word->word_name }}</h5>
                    <div>
                        @foreach ($word->tags as $tag)
                            <a href="#" class="badge text-decoration-none"
                                style="background-color:{{ $tag->color }}">{{ $tag->label }}</a>
                        @endforeach
                    </div>
                </div>
                <p class="card-text">{{ $word->description }}</p>
                <div>
                    Fonte:
                    @forelse ($word->links as $link)
                        <a href="{{ $link->url }}">{{ $link->name }}</a>
                    @empty
                        <div>
                            Non ci sono link associati
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('guest.home') }}" class="btn btn-secondary">Torna indietro</a>
        </div>
    </div>
@endsection
