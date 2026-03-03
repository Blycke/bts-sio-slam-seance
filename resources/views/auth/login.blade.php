@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🔐 Connexion</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="courriel" class="form-label">Courriel</label>
                            <input type="email" name="courriel" class="form-control @error('courriel') is-invalid @enderror" value="{{ old('courriel') }}" required>
                            @error('courriel')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control @error('mot_de_passe') is-invalid @enderror" required>
                            @error('mot_de_passe')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Connexion</button>
                    </form>

                    <hr>
                    <p class="text-center">
                        Pas de compte ? <a href="{{ route('register') }}">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
