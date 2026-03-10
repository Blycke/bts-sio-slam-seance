<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;



class AccueilController extends Controller
{
    /**
     * Affichage de la page d'accueil avec données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour les statistiques d'accueil
     */
    public function index()
    {
        // Statistiques réelles depuis la base de données
        $totalLivres = Livre::count();
        $livresAvecCouverture = Livre::whereNotNull('couverture')->count();

        $stats = [
            'totalLivres' => $totalLivres,
            'livresDisponibles' => Livre::disponible()->count(),
            'totalEmprunts' => 12, // Sera implémenté dans une séance future
            'totalUtilisateurs' => \App\Models\Utilisateur::count(),
            'totalCategories' => Categorie::actives()->count(),
            // nouvelles statistiques liées aux couvertures
            'livresAvecCouverture' => $livresAvecCouverture,
            'pourcentageCouverture' => $totalLivres ? round(100 * $livresAvecCouverture / $totalLivres) : 0,
        ];

        // Livres mis en avant (3 premiers livres de la base)
        $livresEnVedette = Livre::with('categorie')
            ->disponible()
            ->take(3)
            ->get();

        return view('welcome', [
            'stats' => $stats,
            'livresEnVedette' => $livresEnVedette
        ]);
    }
}
