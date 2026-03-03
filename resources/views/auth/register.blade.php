@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">📝 Inscription</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                            @error('nom')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="courriel" class="form-label">Courriel</label>
                            <input type="email" name="courriel" class="form-control @error('courriel') is-invalid @enderror" value="{{ old('courriel') }}" required>
                            @error('courriel')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe (8+ caractères)</label>
                            <input type="password" name="mot_de_passe" class="form-control @error('mot_de_passe') is-invalid @enderror" required>
                            @error('mot_de_passe')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe_confirmation" class="form-label">Confirmer</label>
                            <input type="password" name="mot_de_passe_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                    </form>

                    <hr>
                    <p class="text-center">
                        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
