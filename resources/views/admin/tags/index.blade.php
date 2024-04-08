@extends('layouts.app')

@section('title', 'Words List')

@section('content')
    <div class="container">

        <h1 class="text-center py-3">TAGS</h1>

        <table class="table table-striped table-dark">
            <thead>
                <tr class="align-middle">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Colore</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">
                        <div class="text-center">
                            <a href="{{ route('admin.tags.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                                Nuovo</a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $tag)
                    <tr>
                        <th scope="row">{{ $tag->id }}</th>
                        <td>{{ $tag->label }}</td>
                        <td>
                            <span style="background-color:{{$tag->color}}" class="badge">
                              {{ $tag->color }}

                            </span>
                           
                        </td>
                        <td>{{ $tag->getFormattedDate('created_at') }}</td>
                        <td>{{ $tag->getFormattedDate('updated_at') }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                {{-- Icona modifica tag --}}
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                {{-- Pulsante elimina --}}
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
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
                        <td colspan="5">
                            <h3 class="text-center">Non ci sono tag da mostrare!</h3>
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
