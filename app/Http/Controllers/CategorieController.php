<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Livre;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories (avec nombre de livres)
     * Exercice séance 2/3
     */
    public function index()
    {
        $categories = Categorie::withCount('livres')
            ->orderBy('nom')
            ->paginate(12);

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Affiche une catégorie et les livres qui lui sont associés
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);

        $livres = $categorie->livres()
            ->with('categorie')
            ->orderBy('titre')
            ->paginate(15);

        return view('categories.show', [
            'categorie' => $categorie,
            'livres' => $livres,
        ]);
    }
}
