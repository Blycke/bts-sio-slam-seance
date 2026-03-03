@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tableau de bord bibliothécaire</h1>
    <p>Bonjour {{ $user->nom }}, bienvenue.</p>
</div>
@endsection
