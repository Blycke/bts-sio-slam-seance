@extends('layouts.app', [
    'title' => 'Ajouter un nouveau livre',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => route('livres.index')],
        ['label' => 'Ajouter un livre', 'url' => null]
    ]
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- En-tête --}}
            <div class="mb-4">
                <h1 class="display-6 fw-bold text-dark mb-2">
                    <i class="fas fa-plus-circle text-success"></i> Ajouter un nouveau livre
                </h1>
                <p class="text-muted">
                    Complétez le formulaire ci-dessous pour ajouter un livre au catalogue.
                </p>
            </div>

            {{-- Formulaire de création --}}
            <form method="POST" action="{{ route('livres.store') }}" class="card border-0 shadow-sm">
                @csrf
                <div class="card-body p-4">
                    
                    {{-- Messages d'erreur génériques --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong>⚠️ Erreur de validation</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Titre --}}
                    <div class="mb-3">
                        <label for="titre" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('titre') is-invalid @enderror" 
                            id="titre" 
                            name="titre" 
                            placeholder="Ex: Le Seigneur des Anneaux"
                            value="{{ old('titre') }}"
                            required
                        >
                        @error('titre')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Auteur --}}
                    <div class="mb-3">
                        <label for="auteur" class="form-label fw-bold">Auteur <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('auteur') is-invalid @enderror" 
                            id="auteur" 
                            name="auteur" 
                            placeholder="Ex: J.R.R. Tolkien"
                            value="{{ old('auteur') }}"
                            required
                        >
                        @error('auteur')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Catégorie --}}
                    <div class="mb-3">
                        <label for="categorie_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                        <select 
                            class="form-select @error('categorie_id') is-invalid @enderror" 
                            id="categorie_id" 
                            name="categorie_id"
                            required
                        >
                            <option value="">-- Sélectionnez une catégorie --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ligne 2 : Année, Pages, ISBN --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="annee" class="form-label fw-bold">Année de publication</label>
                            <input 
                                type="number" 
                                class="form-control @error('annee') is-invalid @enderror" 
                                id="annee" 
                                name="annee"
                                min="1000"
                                max="{{ date('Y') }}"
                                placeholder="Ex: 1954"
                                value="{{ old('annee') }}"
                            >
                            @error('annee')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="nb_pages" class="form-label fw-bold">Nombre de pages</label>
                            <input 
                                type="number" 
                                class="form-control @error('nb_pages') is-invalid @enderror" 
                                id="nb_pages" 
                                name="nb_pages"
                                min="1"
                                placeholder="Ex: 423"
                                value="{{ old('nb_pages') }}"
                            >
                            @error('nb_pages')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="isbn" class="form-label fw-bold">ISBN</label>
                            <input 
                                type="text" 
                                class="form-control @error('isbn') is-invalid @enderror" 
                                id="isbn" 
                                name="isbn"
                                placeholder="Ex: 978-0544003415"
                                value="{{ old('isbn') }}"
                            >
                            @error('isbn')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Résumé --}}
                    <div class="mb-3">
                        <label for="resume" class="form-label fw-bold">Résumé</label>
                        <textarea 
                            class="form-control @error('resume') is-invalid @enderror" 
                            id="resume" 
                            name="resume"
                            rows="4"
                            placeholder="Entrez une brève description du livre..."
                        >{{ old('resume') }}</textarea>
                        @error('resume')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Disponibilité --}}
                    <div class="mb-4">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="disponible" 
                                name="disponible" 
                                value="1"
                                {{ old('disponible') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="disponible">
                                Ce livre est <strong>disponible</strong> (à consulter sur place)
                            </label>
                        </div>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                            <i class="fas fa-save"></i> Ajouter le livre
                        </button>
                        <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </div>
            </form>

            {{-- Info utilisateur connecté --}}
            <div class="alert alert-info mt-4" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info :</strong>
                Cette action sera enregistrée et visible par tous les utilisateurs de la bibliothèque.
                Sur action de <strong>{{ auth()->user()->nom }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection
