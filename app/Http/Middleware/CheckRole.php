<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Vérifie si l'utilisateur a l'un des rôles requis.
     * Utilisation: middleware('auth', 'role:admin,bibliothecaire')
     * ou: middleware('auth', 'role:admin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors('Authentification requise');
        }

        // Si aucun rôle spécifié, autoriser
        if (empty($roles)) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a l'un des rôles requis
        $userRole = auth()->user()->role;
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('/dashboard')->withErrors('Vous n\'avez pas accès à cette page (rôle requis: ' . implode(', ', $roles) . ')');
    }
}
