<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Carte;

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
            ]);
    }

    public function modifier(Request $request)
    {
            $validated = $request->validate([
                'id' => 'required|integer|exists:carteElements,idElement',
                'nom' => 'required|string|max:255',
                'categorieElementCarte' => 'required|integer',
                'prix' => 'required|numeric',
                'prixServeur' => 'required|numeric',
                'description' => 'nullable|string',
                'composition' => 'required|string',
            ]);

            DB::table('carteElements')
                ->where('idElement', $validated['id'])
                ->update([
                    'nom' => $validated['nom'],
                    'typePlat' => $validated['categorieElementCarte'],
                    'prix' => $validated['prix'],
                    'prixServeur' => $validated['prixServeur'],
                    'description' => $validated['description'],
                    'ingredientsElements' => $validated['composition'],
                ]);
    }
}
