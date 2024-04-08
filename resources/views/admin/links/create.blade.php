@extends('layouts.app')

@section('title', 'Crea Nuovo Link')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('admin.links.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-6">
                    <label class="form-check-label" for="name">Inserisci il nome dell'url</label>
                    <input id="name" class="form-control my-2 " type="text" name="name">
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="url">Inserisci l'url</label>
                    <input id="url" class="form-control my-2" type="text" name="url">
                </div>
            </div>

            {{-- Bottoni --}}
            <div class="d-flex justify-content-between my-4">
                <a href="{{ route('admin.words.index') }}" class="btn btn-outline-secondary"><i
                        class="far fa-hand-point-left me-2"></i>Torna indietro</a>
                <div>
                    <button type="reset" class="btn btn-info"><i class="fas fa-eraser me-2"></i>Ripristina</button>
                    <button type="submit" class="btn btn-success"><i class="far fa-floppy-disk me-2"></i>Salva</button>
                </div>
            </div>
        </form>
    </div>
@endsection
