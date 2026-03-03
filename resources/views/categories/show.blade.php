@extends('layouts.app', ['title' => 'Catégorie '.$categorie->nom])

@section('content')
<div class="container mt-5">
    <h1>{{ $categorie->nom }}</h1>
    <p>{{ $categorie->description }}</p>

    <h3 class="mt-4">Livres dans cette catégorie</h3>
    <div class="row">
        @forelse($livres as $livre)
        <div class="col-md-4 mb-4">
            <x-livre-card :livre="$livre" />
        </div>
        @empty
        <p>Aucun livre pour le moment.</p>
        @endforelse
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $livres->links() }}
        </div>
    </div>
</div>
@endsection
