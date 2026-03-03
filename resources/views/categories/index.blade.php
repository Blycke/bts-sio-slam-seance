@extends('layouts.app', ['title' => 'Catégories'])

@section('content')
<div class="container mt-5">
    <h1>Catégories</h1>
    <table class="table table-striped">
        <thead>
            <tr><th>Nom</th><th>Livres</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td>{{ $cat->nom }}</td>
                <td>{{ $cat->livres_count }}</td>
                <td>
                    <a href="{{ route('categories.show', $cat->id) }}" class="btn btn-sm btn-primary">Voir</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center">Aucune catégorie</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $categories->links() }}
</div>
@endsection
