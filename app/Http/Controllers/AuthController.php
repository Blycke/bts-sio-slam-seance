<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * AuthController – gestion de l'authentification (séance 4)
 *
 * Utilise le modèle `Utilisateur` français avec champs nom/courriel/mot_de_passe.
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'courriel'    => 'required|email|exists:utilisateurs,courriel',
            'mot_de_passe' => 'required|min:8',
        ]);

        $credentials = [
            'courriel' => $validated['courriel'],
            'password' => $validated['mot_de_passe'], // Laravel s'attend toujours à "password" pour vérifier
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Utilisateur connecté', ['courriel' => $validated['courriel']]);

            return redirect('/dashboard')->with('success', 'Bienvenue !');
        }

        Log::warning('Tentative de connexion échouée', ['courriel' => $validated['courriel']]);

        return back()
            ->withErrors(['courriel' => 'Identifiants invalides'])
            ->onlyInput('courriel');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom'            => 'required|string|max:255',
            'courriel'       => 'required|email|unique:utilisateurs,courriel',
            'mot_de_passe'    => 'required|confirmed|min:8',
        ]);

        $user = Utilisateur::create([
            'nom'         => $validated['nom'],
            'courriel'    => $validated['courriel'],
            'mot_de_passe' => Hash::make($validated['mot_de_passe']),
            'role'        => 'utilisateur',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Log::info('Nouvel utilisateur inscrit', ['courriel' => $user->courriel]);

        return redirect('/dashboard')->with('success', 'Compte créé avec succès !');
    }

    public function logout(Request $request)
    {
        Log::info('Utilisateur déconnecté', ['id' => auth()->id()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie');
    }
}
