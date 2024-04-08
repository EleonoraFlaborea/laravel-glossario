@extends('layouts.app')

@section('title', $word->word_name)

@section('content')
    <div class="container w-75 m-auto">

        @include('includes.words.card')

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('guest.home') }}" class="btn btn-secondary"><i class="far fa-hand-point-left me-2"></i>Torna indietro</a>
        </div>
    </div>
@endsection
