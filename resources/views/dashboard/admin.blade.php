@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tableau de bord administrateur</h1>
    <p>Bienvenue {{ $user->nom }} ({{ $user->role }})</p>
    <p><a href="{{ route('admin.users.index') }}">Gérer les utilisateurs</a></p>

    @if(isset($stats))
        <hr>
        <h2 class="mt-4">Statistiques générales</h2>
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="card text-center h-100 border-primary">
                    <div class="card-body">
                        <i class="fas fa-book fa-2x text-primary mb-2"></i>
                        <h3 class="text-primary">{{ $stats['totalLivres'] }}</h3>
                        <p class="card-text">Livres au total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-center h-100 border-success">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h3 class="text-success">{{ $stats['livresDisponibles'] }}</h3>
                        <p class="card-text">Disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-center h-100 border-warning">
                    <div class="card-body">
                        <i class="fas fa-hand-holding fa-2x text-warning mb-2"></i>
                        <h3 class="text-warning">{{ $stats['totalEmprunts'] }}</h3>
                        <p class="card-text">Emprunts actifs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-center h-100 border-info">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x text-info mb-2"></i>
                        <h3 class="text-info">{{ $stats['totalUtilisateurs'] }}</h3>
                        <p class="card-text">Utilisateurs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-center h-100 border-secondary">
                    <div class="card-body">
                        <i class="fas fa-image fa-2x text-secondary mb-2"></i>
                        <h3 class="text-secondary">{{ $stats['livresAvecCouverture'] }}</h3>
                        <p class="card-text">Avec couvertures</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
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
</div>
@endsection
