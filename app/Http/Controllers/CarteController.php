<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * CarteController
 *
 * Ce contrôleur gère les opérations liées à la carte du restaurant.
 * Il permet d'afficher, ajouter, modifier et supprimer des éléments de la carte.
 */
class CarteController extends Controller
{
    /**
     * affiche la page de gestion de la carte
     */
    public function afficherGestionCarte()
    {
        $elementsCarte = DB::table('carteElements')->get();
        $elementsInventaire = DB::table('inventaire')->get();
        return view('admin.gestion-carte', compact('elementsCarte', 'elementsInventaire'));
    }

    /**
     * Ajoute un nouvel élément à la carte
     *
     * @return \Illuminate\View\View
     */
    public function ajouter(Request $request)
    {
            // Valider les données
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'categorieElementCarte' => 'required|integer',
                'prix' => 'required|numeric',
                'prixServeur' => 'required|numeric',
                'description' => 'nullable|string',
                'composition' => 'required|string',
                'categoriePlat' => 'required|integer'
            ]);

            // Insérer les données dans la table principale (par exemple, "carte")
            $idElement = DB::table('carteElements')->insertGetId([
                'nom' => $validated['nom'],
                'typePlat' => $validated['categorieElementCarte'],
                'prix' => $validated['prix'],
                'prixServeur' => $validated['prixServeur'],
                'description' => $validated['description'],
                'ingredientsElements' => $validated['composition'],
                'categoriePlat' => $validated['categoriePlat'],
            ]);

            return redirect()->route('admin.gestion-carte');
    }

    /**
     * Met à jour un élément de la carte
     *
     * @return \Illuminate\View\View
     */
    public function modifier(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:carteElements,idElement',
            'nom' => 'required|string|max:255',
            'categorieElementCarte' => 'required|integer',
            'prix' => 'required|numeric',
            'prixServeur' => 'required|numeric',
            'composition' => 'required|string',
            'categoriePlat' => 'required|integer'
        ]);

        DB::table('carteElements')
            ->where('idElement', $validated['id'])
            ->update([
                'nom' => $validated['nom'],
                'typePlat' => $validated['categorieElementCarte'],
                'prix' => $validated['prix'],
                'prixServeur' => $validated['prixServeur'],
                'ingredientsElements' => $validated['composition'],
                'categoriePlat' => $validated['categoriePlat'],
            ]);

        
        return response()->json([
            'success' => true,
            'id' => $validated['id'],
            'nom' => $validated['nom'],
            'prix' => $validated['prix'],
            'prixServeur' => $validated['prixServeur'],
            'composition' => $validated['composition'],
            'categoriePlat' => $validated['categoriePlat'],
            'typePlat' => $validated['categorieElementCarte'],
        ]);
    }

    /**
     * Supprime un élément de la carte
     *
     * @return \Illuminate\View\View
     */
    public function supprimer(Request $request)
    {
        $id = $request->input('id');
        DB::table('carteElements')->where('idElement', $id)->delete();
        return response()->json(['success' => true]);
    }
}
