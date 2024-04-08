@extends('layouts.app')

@section('title', 'Modifica Tag')

@section('content')
    <div class="container mt-5">

        <form action="{{ route('admin.tags.update', $tag) }}" enctype="multipart/form-data" method="POST">
            @method('PUT')
            @csrf
            <div class="row g-4">
                {{-- Input tag label --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="tag_label">Inserisci tag</label>
                        <input id="tag_label"
                            class="form-control my-2 @error('tag_label') is-invalid @elseif(old('tag_label', '')) is-valid @enderror"
                            type="text" name="tag_label" value="{{ old('tag_label', $tag->label) }}">
                        @error('tag_label')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- Input description --}}
                <div class="col-12">
                    <div class="form-group">
                        <label for="exampleColorInput" class="form-label">Scegli il colore che preferisci</label>
                        <input type="color"
                            class="form-control form-control-color @error('tag_color') is-invalid @elseif(old('tag_color', '')) is-valid @enderror"
                            id="tag_color" value="{{ $tag->color }}" title="Choose your color">
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-between my-4">
                <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary"><i
                        class="far fa-hand-point-left me-2"></i>Torna indietro</a>
                <div>
                    <button type="reset" class="btn btn-info"><i class="fas fa-eraser me-2"></i>Svuota i campi</button>
                    <button type="submit" class="btn btn-success"><i class="far fa-floppy-disk me-2"></i>Salva</button>
                </div>
            </div>

        </form>
    </div>

@endsection
