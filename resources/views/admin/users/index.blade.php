@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Utilisateurs</h2>
    <table class="table">
        <thead>
            <tr><th>ID</th><th>Nom</th><th>Courriel</th><th>Rôle</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->nom }}</td>
                <td>{{ $u->courriel }}</td>
                <td>
                    {{ $u->role }}
                    @if(auth()->user()->isAdmin() && auth()->id() !== $u->id)
                        <form action="{{ route('admin.users.updateRole', $u->id) }}" method="POST" class="d-inline-block ms-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="form-select form-select-sm d-inline w-auto">
                                <option value="utilisateur" {{ $u->role=='utilisateur'?'selected':'' }}>Utilisateur</option>
                                <option value="bibliothecaire" {{ $u->role=='bibliothecaire'?'selected':'' }}>Bibliothécaire</option>
                                <option value="admin" {{ $u->role=='admin'?'selected':'' }}>Admin</option>
                            </select>
                            <button class="btn btn-sm btn-secondary" type="submit">OK</button>
                        </form>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-primary">Voir</a>
                    @if(auth()->user()->isAdmin() && auth()->id() !== $u->id)
                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
