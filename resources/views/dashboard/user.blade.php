@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Mon espace</h1>
    <p>Bonjour {{ $user->nom }}, vous êtes connecté comme {{ $user->role }}.</p>
</div>
@endsection
