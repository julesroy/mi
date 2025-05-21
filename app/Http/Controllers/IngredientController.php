<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;

/**
 * IngredientController
 *
 * Ce contrôleur gère les opérations CRUD pour les ingrédients.
 */
class IngredientController extends Controller
{
    /**
     * Affiche la page de gestion des ingrédients.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Ingredient::query();

        // Filtre de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")->orWhere('marque', 'like', "%{$search}%");
            });
        }

        // Gestion du tri
        $sortable = ['nom', 'quantite', 'marque', 'estimationPrix', 'categorieIngredient'];
        $sort = $request->get('sort', 'nom');
        $direction = $request->get('direction', 'asc');

        if (!in_array($sort, $sortable)) {
            $sort = 'nom';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        if ($request->filled('categorie')) {
            $query->where('categorieIngredient', $request->categorie);
        }

        $query->orderBy($sort, $direction);

        $ingredients = $query->get();

        return view('admin.inventaire', compact('ingredients'));
    }

    /**
     * Ajout un nouvel ingrédient à la base de données.
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorieIngredient' => 'required|integer',
            'quantite' => 'required|numeric',
            'marque' => 'required|string|max:255',
            'commentaire' => 'nullable|string',
            'estimationPrix' => 'nullable|numeric',
        ]);

        try {
            $ingredient = new Ingredient();
            $ingredient->nom = $validated['nom'];
            $ingredient->categorieIngredient = $validated['categorieIngredient'];
            $ingredient->quantite = $validated['quantite'];
            $ingredient->marque = $validated['marque'];
            $ingredient->commentaire = $validated['commentaire'] ?? null;

            // Vérifier le niveau d'accès pour le prix
            if (Auth::user() && Auth::user()->acces == 3 && isset($validated['estimationPrix'])) {
                $ingredient->estimationPrix = $validated['estimationPrix'];
            }

            $ingredient->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Modifie un ingrédient existant.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:inventaire,idIngredient',
            'nom' => 'required|string|max:255',
            'quantite' => 'required|numeric',
            'marque' => 'required|string|max:255',
            'categorieIngredient' => 'required',
            'estimationPrix' => 'nullable|numeric',
            'commentaire' => 'nullable|string',
        ]);

        $item = \App\Models\Ingredient::findOrFail($validated['id']);
        $item->nom = $validated['nom'];
        $item->quantite = $validated['quantite'];
        $item->marque = $validated['marque'];
        $item->categorieIngredient = $validated['categorieIngredient'];
        if (Auth::user() && Auth::user()->acces == 3) {
            $item->estimationPrix = $validated['estimationPrix'] ?? null;
        }
        $item->commentaire = $validated['commentaire'] ?? null;
        $item->save();

        return response()->json(['success' => true]);
    }

    /**
     * Supprime un ingrédient de la base de données.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function delete(Request $request)
    {
        try {
            $ingredient = Ingredient::findOrFail($request->id);
            $ingredient->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
