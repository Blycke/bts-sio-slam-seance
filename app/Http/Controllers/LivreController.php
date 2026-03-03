<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Categorie;

class LivreController extends Controller
{
    /**
     * Affichage liste avec base de données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour récupérer les données depuis SQLite
     */
    public function index(Request $request)
    {
        // base query with eager loading
        $query = Livre::with('categorie');

        // recherche texte sur titre/auteur
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('auteur', 'LIKE', "%{$search}%");
            });
        }

        // filtre par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // pagination et maintien des paramètres dans les liens
        $livres = $query->orderBy('titre')
                        ->paginate(10)
                        ->appends($request->all());

        $categories = Categorie::actives()->orderBy('nom')->get();

        $statistiques = [
            'totalLivres' => Livre::count(),
            'livresDisponibles' => Livre::disponible()->count(),
            'totalCategories' => $categories->count()
        ];

        return view('livres.index', [
            'livres' => $livres,
            'categories' => $categories,
            'stats' => $statistiques,
            'total' => $livres->total(),
        ]);
    }

    /**
     * Affichage détail avec paramètre d'URL et Eloquent
     * SÉANCE 2 : Utiliser Eloquent pour récupérer un enregistrement spécifique
     */
    public function show($id)
    {
        // Conversion de l'ID en entier pour éviter les erreurs
        $id = (int) $id;

        // Récupération du livre avec sa catégorie via Eloquent
        $livre = Livre::with('categorie')->findOrFail($id);

        return view('livres.show', [
            'livre' => $livre
        ]);
    }

    /**
     * Recherche de livres
     * redirige vers index en conservant paramètres
     */
    public function search(Request $request)
    {
        // on utilise la même logique que index sachant que
        // celui-ci traite déjà 'q' et 'categorie_id'.
        return $this->index($request);
    }

    /**
     * Formulaire de création d'un livre
     * Réservé aux admins et bibliothécaires
     */
    public function create()
    {
        $categories = Categorie::actives()->orderBy('nom')->get();
        return view('livres.create', ['categories' => $categories]);
    }

    /**
     * Sauvegarde un nouveau livre dans la base de données
     * Réservé aux admins et bibliothécaires
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'annee' => 'nullable|integer|min:1000|max:' . date('Y'),
            'nb_pages' => 'nullable|integer|min:1',
            'isbn' => 'nullable|string|max:20',
            'resume' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'disponible' => 'nullable|boolean',
        ]);

        // Créer le livre
        $livre = Livre::create($validated);

        return redirect()->route('livres.show', $livre->id)
            ->with('success', 'Livre "' . $livre->titre . '" créé avec succès!');
    }
}
