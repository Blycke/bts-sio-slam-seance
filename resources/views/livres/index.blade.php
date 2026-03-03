@extends('layouts.app', [
    'title' => 'Catalogue des livres',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => null]
    ]
])

@section('content')
<div class="container">
    {{-- En-tête avec statistiques --}}
    <div class="row mb-4">
        <div class="col-12 text-center mb-4">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <i class="fas fa-book" style="font-size: 2.5rem;"></i>
                {{-- Bouton pour ajouter un livre (admin/bibliothécaire) --}}
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isBibliothecaire()))
                    <a href="{{ route('livres.create') }}" class="btn btn-success" style="font-size: 1rem;">
                        <i class="fas fa-plus-circle"></i> Ajouter un livre
                    </a>
                @endif
            </div>
            <h1 class="display-5 fw-bold text-dark mb-3">Catalogue des livres</h1>
            <p class="text-muted">
                {{ $stats['totalLivres'] }} livres • {{ $stats['livresDisponibles'] }} disponibles • {{ $stats['totalCategories'] }} catégories
            </p>
        </div>
        <div class="col-12">
            {{-- formulaire de recherche + filtre catégorie --}}
            <form method="GET" action="{{ route('livres.index') }}" class="row g-3 mb-3 justify-content-center">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Titre ou auteur..." value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <select name="categorie_id" class="form-select">
                        <option value="">Toutes catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des livres --}}
    <div class="row">
        @forelse($livres as $livre)
        <div class="col-md-6 col-lg-4 mb-4">
            <x-livre-card :livre="$livre" :show-details="true" />
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                Aucun livre n'est disponible pour le moment.
            </div>
        </div>
        @endforelse
    </div>

    {{-- pagination --}}
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $livres->links() }}
        </div>
    </div>

    {{-- Message informatif --}}
    @if(count($livres) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-light">
                <i class="fas fa-lightbulb"></i>
                <strong>Information :</strong> 
                Ces données sont statiques pour la Séance 1. 
                En Séance 2, nous connecterons une vraie base de données PostgreSQL !
            </div>
        </div>
    </div>
    @endif
</div>
@endsection