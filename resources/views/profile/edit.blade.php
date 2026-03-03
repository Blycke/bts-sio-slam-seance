@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Éditer mon profil</h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}">
        </div>
        <div class="mb-3">
            <label for="courriel" class="form-label">Courriel</label>
            <input type="email" name="courriel" class="form-control" value="{{ old('courriel', $user->courriel) }}">
        </div>
        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>

    <hr>
    <h3>Changer de mot de passe</h3>
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input type="password" name="current_password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button class="btn btn-warning" type="submit">Modifier le mot de passe</button>
    </form>

    <hr>
    <h3>Supprimer mon compte</h3>
    <form action="{{ route('profile.delete') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-danger" type="submit">Supprimer mon compte</button>
    </form>
</div>
@endsection
