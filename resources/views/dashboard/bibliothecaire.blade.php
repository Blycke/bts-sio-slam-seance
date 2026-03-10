@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tableau de bord bibliothécaire</h1>
    <p>Bonjour {{ $user->nom }}, bienvenue.</p>

    @if(isset($stats))
        <hr>
        <h2 class="mt-4">Statistiques</h2>
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100 border-primary">
                    <div class="card-body">
                        <i class="fas fa-book fa-2x text-primary mb-2"></i>
                        <h3 class="text-primary">{{ $stats['totalLivres'] }}</h3>
                        <p class="card-text">Livres</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100 border-success">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h3 class="text-success">{{ $stats['livresDisponibles'] }}</h3>
                        <p class="card-text">Disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100 border-secondary">
                    <div class="card-body">
                        <i class="fas fa-image fa-2x text-secondary mb-2"></i>
                        <h3 class="text-secondary">{{ $stats['livresAvecCouverture'] }}</h3>
                        <p class="card-text">Couvertures</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100 border-dark">
                    <div class="card-body">
                        <i class="fas fa-percent fa-2x text-dark mb-2"></i>
                        <h3 class="text-dark">{{ $stats['pourcentageCouverture'] }}<sup>%</sup></h3>
                        <p class="card-text">Couverture (%)</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($livresParCategorie))
        <hr>
        <h2 class="mt-4">Livres par Catégorie</h2>
        @foreach($livresParCategorie as $categorie)
            <div class="mb-4">
                <h3 class="text-primary">{{ $categorie->nom }}</h3>
                @if($categorie->livres->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Année</th>
                                    <th>Disponibilité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorie->livres as $livre)
                                    <tr>
                                        <td>{{ $livre->titre }}</td>
                                        <td>{{ $livre->auteur }}</td>
                                        <td>{{ $livre->annee }}</td>
                                        <td>
                                            @if($livre->disponible)
                                                <span class="badge bg-success">Disponible</span>
                                            @else
                                                <span class="badge bg-danger">Emprunté</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Aucun livre dans cette catégorie.</p>
                @endif
            </div>
        @endforeach
    @endif

    <hr>
    <h2 class="mt-4">Outils de développement</h2>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-project-diagram text-info me-2"></i>
                        Diagramme UML
                    </h5>
                    <p class="card-text">
                        Visualisez la structure UML complète du projet BiblioTech avec les classes, relations et contrôleurs.
                    </p>
                    <a href="{{ route('diagramme.uml') }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>
                        Voir le diagramme
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
