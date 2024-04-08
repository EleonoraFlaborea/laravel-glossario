@extends('layouts.app')

@section('title', $word->word_name)

@section('content')
    <div class="container w-75 m-auto">

        @include('includes.words.card')

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.words.index') }}" class="btn btn-secondary">Torna indietro</a>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.words.edit', $word) }}" class="btn btn-warning">Modifica</a>

                {{-- Tasto per eliminare la parola --}}
                <form action="{{ route('admin.words.destroy', $word) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can me-2"></i>Elimina</button>
                </form>
            </div>
        </div>
    </div>
@endsection
