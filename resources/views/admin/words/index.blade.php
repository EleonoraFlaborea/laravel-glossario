@extends('layouts.app')

@section('title', 'Words List')

@section('cdn')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'
        integrity='sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=='
        crossorigin='anonymous' />
@endsection

@section('content')
    <div class="container">

        <h1 class="text-center py-3">WORDS</h1>

        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Word</th>
                    <th scope="col">Description</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($words as $word)
                    <tr>
                        <th scope="row">{{ $word->id }}</th>
                        <td>{{ $word->word_name }}</td>
                        <td>{{ $word->description }}</td>
                        <td>{{ $word->created_at }}</td>
                        <td>{{ $word->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                {{-- Icona visualizza parola --}}
                                <a href="{{ route('admin.words.show', $word) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Icona modifica parola --}}
                                <a href="{{ route('admin.words.edit', $word) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.words.destroy', $word->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-can"></i>
                                    </button>

                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <h3 class="text-center">Non ci sono parole da mostrare!</h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
