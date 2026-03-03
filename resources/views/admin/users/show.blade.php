@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Utilisateur #{{ $user->id }}</h2>
    <p><strong>Nom :</strong> {{ $user->nom }}</p>
    <p><strong>Courriel :</strong> {{ $user->courriel }}</p>
    <p><strong>Rôle :</strong> {{ $user->role }}</p>

    @if(auth()->user()->isAdmin() && auth()->id() !== $user->id)
        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Supprimer</button>
        </form>
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <select name="role" class="form-select d-inline-block w-auto">
                <option value="utilisateur" {{ $user->role=='utilisateur'?'selected':'' }}>Utilisateur</option>
                <option value="bibliothecaire" {{ $user->role=='bibliothecaire'?'selected':'' }}>Bibliothécaire</option>
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
            </select>
            <button class="btn btn-sm btn-secondary">Changer rôle</button>
        </form>
    @endif
</div>
@endsection
