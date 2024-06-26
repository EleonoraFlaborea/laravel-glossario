@extends('layouts.app')

@section('title', 'Parole')

@section('content')
    <div class="container pb-5">

        <header class="pb-3 text-center">
            <h1 class="m-0 py-3">PAROLE</h1>
            <div class="d-flex justify-content-between w-100">
                <div>
                    <a href="{{ route('admin.words.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                        Aggiungi Nuova Parola</a>
                </div>
                <a href="{{ route('admin.words.trash') }}" class="btn btn-secondary d-block">
                    <i class="fas fa-trash-arrow-up me-2"></i>Guarda Cestino</a>
            </div>
        </header>

        <table class="table table-striped table-dark">
            <thead>
                <tr class="align-middle">
                    <th scope="col">#</th>
                    <th scope="col">Parola</th>
                    <th scope="col">Tag</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Creato il</th>
                    <th scope="col">Modificato il</th>
                    <th scope="col">
                        {{-- <div class="text-center">
                        <a href="{{ route('admin.words.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                            Nuovo</a>
                    </div> --}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($words as $word)
                    <tr>
                        <th scope="row">{{ $word->id }}</th>
                        <td>{{ $word->word_name }}</td>
                        <td>
                            @forelse($word->tags as $tag)
                                <span class="badge rounded-pill"
                                    style="background-color: {{ $tag->color }}">{{ $tag->label }}</span>
                            @empty
                                N/A
                            @endforelse
                        </td>
                        <td class="w-50">{{ $word->getAbstract() }} <a
                                href="{{ route('admin.words.show', $word) }}">[...]</a></td>
                        <td>{{ $word->getFormattedDate('created_at') }}</td>
                        <td>{{ $word->getFormattedDate('updated_at') }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                {{-- Icona visualizza parola --}}
                                <a href="{{ route('admin.words.show', $word) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Icona modifica parola --}}
                                <a href="{{ route('admin.words.edit', $word) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                {{-- Pulsante elimina --}}
                                <form action="{{ route('admin.words.destroy', $word->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal">
                                        <i class="fas fa-trash-can"></i>
                                    </button>

                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <h3 class="text-center">Non ci sono parole da mostrare!</h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
