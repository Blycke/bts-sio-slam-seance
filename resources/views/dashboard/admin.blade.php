@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tableau de bord administrateur</h1>
    <p>Bienvenue {{ $user->nom }} ({{ $user->role }})</p>
    <p><a href="{{ route('admin.users.index') }}">Gérer les utilisateurs</a></p>
</div>
@endsection
