@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Mon espace</h1>
    <p>Bonjour {{ $user->nom }}, vous êtes connecté comme {{ $user->role }}.</p>

    @if(isset($stats))
        <hr>
        <h2 class="mt-4">Quelques chiffres</h2>
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
                        <p class="card-text">% couvert</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
