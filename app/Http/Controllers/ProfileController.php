<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nom'      => 'required|string|max:255',
            'courriel' => 'required|email|unique:utilisateurs,courriel,' . auth()->id(),
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profil mis à jour');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->mot_de_passe)) {
            return back()->withErrors(['current_password' => 'Mot de passe incorrect']);
        }

        auth()->user()->update([
            'mot_de_passe' => Hash::make($validated['password']),
        ]);

        Log::info('Mot de passe modifié', ['user_id' => auth()->id()]);

        return back()->with('success', 'Mot de passe changé');
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($validated['password'], auth()->user()->mot_de_passe)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect']);
        }

        $user = auth()->user();
        auth()->logout();
        $request->session()->invalidate();

        $user->delete();

        Log::warning('Compte utilisateur supprimé', ['id' => $user->id]);

        return redirect('/')->with('success', 'Compte supprimé');
    }
}
