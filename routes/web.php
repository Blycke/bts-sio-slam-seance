<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\LivreController;

/*
|--------------------------------------------------------------------------
| SÉANCE 1 : Routes Fondamentales
|--------------------------------------------------------------------------
| Focus : Comprendre le routage Laravel basique
| - Routes simples
| - Paramètres d'URL
| - Routes nommées
| - Contrôleurs
*/

Route::get('/test-debug', function () { 
    return 'Laravel fonctionne !'; 
});

// 1. Accueil - Route simple
Route::get('/', [AccueilController::class, 'index'])->name('home');

// 2. À propos - Route vers vue directe  
Route::get('/about', function () {
    return view('about');
})->name('about');

// 3. Liste livres - Route vers contrôleur
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');

// 4. Détail livre - Route avec paramètre
Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');

// Recherche livre (peut aussi pointer vers l'index avec query)
Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

// Catégories (séances 1–3)
Route::get('/categories', [App\Http\Controllers\CategorieController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [App\Http\Controllers\CategorieController::class, 'show'])->name('categories.show');

// Route de démonstration pour comprendre les paramètres
Route::get('/demo/hello/{nom?}', function ($nom = 'Étudiant') {
    return view('demo.hello', ['nom' => $nom]);
})->name('demo.hello');

// Route de test pour déboguer - retourne du HTML simple
Route::get('/test', function () {
    return '<h1>Test Laravel fonctionne !</h1><p>Si vous voyez ce message, Laravel fonctionne.</p>';
})->name('test');

// Route pour le diagramme UML
Route::get('/diagramme-uml', function () {
    return view('diagramme_uml');
})->name('diagramme.uml');

// ---------------------------------------------------------
// SÉANCE 4 : Authentification & gestion des utilisateurs
// ---------------------------------------------------------

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;

// 🔓 Routes publiques (login / register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// 🔐 routes nécessitant une connexion
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // profil utilisateur
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');

    // tableau de bord selon rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // statistiques globales similaires à la page d'accueil
        $totalLivres = \App\Models\Livre::count();
        $livresAvecCouverture = \App\Models\Livre::whereNotNull('couverture')->count();
        $stats = [
            'totalLivres' => $totalLivres,
            'livresDisponibles' => \App\Models\Livre::disponible()->count(),
            'totalEmprunts' => 0, // placeholder pour future séance
            'totalUtilisateurs' => \App\Models\Utilisateur::count(),
            'totalCategories' => \App\Models\Categorie::actives()->count(),
            'livresAvecCouverture' => $livresAvecCouverture,
            'pourcentageCouverture' => $totalLivres ? round(100 * $livresAvecCouverture / $totalLivres) : 0,
        ];

        return match ($user->role) {
            'admin' => view('dashboard.admin', ['user' => $user, 'stats' => $stats]),
            'bibliothecaire' => view('dashboard.bibliothecaire', [
                'user' => $user, 
                'stats' => $stats,
                'livresParCategorie' => \App\Models\Categorie::with('livres')->get()
            ]),
            default => view('dashboard.user', ['user' => $user, 'stats' => $stats]),
        };
    })->name('dashboard');
});

// routes réservées aux administrateurs
Route::middleware(['auth', CheckRole::class . ':admin'])
    ->prefix('/admin')->name('admin.')
    ->group(function () {
        Route::get('/utilisateurs', [UserController::class, 'index'])->name('users.index');
        Route::get('/utilisateurs/{id}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/utilisateurs/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::patch('/utilisateurs/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

// exemple de route pour bibliothécaire
Route::middleware(['auth', CheckRole::class . ':bibliothecaire'])
    ->prefix('/biblio')->name('biblio.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.bibliothecaire');
        })->name('dashboard');
    });

// Routes de gestion des livres (Admin + Bibliothécaire)
Route::middleware(['auth', CheckRole::class . ':admin,bibliothecaire'])->group(function () {
    // Créer un livre : réservé à admin et bibliothécaire
    Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
    Route::post('/livres', [LivreController::class, 'store'])->name('livres.store');
});
