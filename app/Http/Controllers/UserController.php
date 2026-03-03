<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = Utilisateur::paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    public function show($id)
    {
        $user = Utilisateur::findOrFail($id);

        if (auth()->user()->isAdmin() || auth()->id() === $id) {
            return view('admin.users.show', ['user' => $user]);
        }

        return redirect('/users')->withErrors('Non autorisé');
    }

    public function delete(Request $request, $id)
    {
        $user = Utilisateur::findOrFail($id);

        if (auth()->id() === $id) {
            return back()->withErrors('Vous ne pouvez pas vous supprimer');
        }

        $user->delete();
        Log::warning('Utilisateur supprimé', ['id' => $id, 'deleted_by' => auth()->id()]);

        // rediriger vers l'espace admin
        return redirect('/admin/utilisateurs')->with('success', 'Utilisateur supprimé');
    }

    public function updateRole(Request $request, $id)
    {
        $user = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            // migraton actuel ne comprend que 'admin' et 'utilisateur'
            'role' => 'required|in:admin,utilisateur',
        ]);

        $user->update(['role' => $validated['role']]);

        Log::info('Rôle utilisateur mis à jour', [
            'user_id' => $id,
            'new_role' => $validated['role'],
        ]);

        return back()->with('success', 'Rôle mis à jour');
    }
}
