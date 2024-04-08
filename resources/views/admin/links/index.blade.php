@extends('layouts.app')

@section('title', 'Link')

@section('content')
    <div class="container">

        <h1 class="text-center py-3">LINK</h1>

        <table class="table table-striped table-dark">
            <thead>
                <tr class="align-middle">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Url</th>
                    <th scope="col">Creato il</th>
                    <th scope="col">Modificato il</th>
                    <th scope="col">
                        <div class="text-center">
                            <a href="{{ route('admin.links.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                                Nuovo
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($links as $link)
                    <tr>
                        <th scope="row">{{ $link->id }}</th>
                        <td>{{ $link->name }}</td>
                        <td> {{ $link->url }}</td>
                        <td>{{ $link->getFormattedDate('created_at') }}</td>
                        <td>{{ $link->getFormattedDate('updated_at') }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                {{-- Icona modifica parola --}}
                                <a href="{{ route('admin.links.edit', $link) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                {{-- Pulsante elimina --}}
                                <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST"
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
                            <h3 class="text-center">Non ci sono link da mostrare!</h3>
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
