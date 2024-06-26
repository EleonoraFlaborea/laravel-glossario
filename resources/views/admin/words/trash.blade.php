@extends('layouts.app')

@section('title', 'Cestino')

@section('content')
    <div class="container">
        <header class="d-flex align-items-center justify-content-between flex-column py-3">
            <h1 class="m-0">Parole Eliminate</h1>
            <div class="d-flex justify-content-between w-100">
                {{-- Back to home --}}
                <a href="{{ route('admin.words.index') }}" class="btn btn-secondary d-block">
                    <i class="far fa-hand-point-left me-2"></i>Torna al Glossario
                </a>
                <div class="d-flex justify-content-between gap-2">
                    {{-- massive drop --}}
                    <form action="{{ route('admin.words.massivedrop') }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal">
                            <i class="fas fa-trash me-2"></i>Svuota cestino</a>
                        </button>
                    </form>
                    {{-- massive restore --}}
                    <form action="{{ route('admin.words.massiverestore') }}" method="POST" class="restore-form">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
                            <i class="fas fa-arrows-rotate me-2"></i>Ripristina tutto</a>
                        </button>
                    </form>
                </div>
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
                                href="{{ route('admin.words.show', $word) }}">[...]</a>
                        </td>
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
                                <form action="{{ route('admin.words.drop', $word->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                                {{-- Pulsante restore --}}
                                <form action="{{ route('admin.words.restore', $word->id) }}" method="POST"
                                    class="restore-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal">
                                        <i class="fas fa-arrows-rotate"></i>
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
    </div>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
