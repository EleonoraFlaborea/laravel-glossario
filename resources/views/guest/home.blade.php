@extends('layouts.app')
@section('content')

<div class="container pt-5">

    <h1>GLOSSARIO</h1>
    <div class="row g-2">

        @forelse($words as $word)
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between pb-4">
                    <h5 class="card-title">{{$word->word_name}}</h5>
                    <a href="{{route('guest.words.show', $word) }}" class="btn btn-sm btn-primary">VEDI</a>
                  </div>
                  <p class="card-text">
                    {{$word->getAbstract()}}
                     ...
                  </p>

                  @forelse ($word->links as $link)
                  <a href="{{$link->url}}">{{$link->name}}</a>
                  @empty

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