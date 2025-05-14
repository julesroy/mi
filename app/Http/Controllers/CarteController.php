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
        $elementsCarte = DB::table('carte')->get();
        $elementsInventaire = DB::table('inventaire')->get();
        $elementsMenus = DB::table('elementsMenus')->get();
        return view('admin.gestion-carte', compact('elementsCarte', 'elementsInventaire', 'elementsMenus'));
    }

    public function ajouter(Request $request)
    {
        try {
            // Valider les données
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'categorieElementCarte' => 'required|integer',
                'prix' => 'required|numeric',
                'prixServeur' => 'required|numeric',
                'description' => 'nullable|string',
                'composition' => 'required|json', // La composition doit être un JSON valide
            ]);

            // Insérer les données dans la table principale (par exemple, "carte")
            $idElement = DB::table('carte')->insertGetId([
                'nom' => $validated['nom'],
                'typePlat' => $validated['categorieElementCarte'],
                'prix' => $validated['prix'],
                'prixServeur' => $validated['prixServeur'],
                'description' => $validated['description'],
                'ingredientsElements' => $validated['composition'],
            ]);

            return response()->json(['success' => true, 'message' => 'Élément ajouté avec succès']);
        } catch (\Exception $e) {
            // Gérer les erreurs et renvoyer une réponse JSON
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }

    public function modifier(Request $request, $id)
    {
        try {
            // Valider les données
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'categorieElementCarte' => 'required|integer',
                'prix' => 'required|numeric',
                'prixServeur' => 'required|numeric',
                'description' => 'nullable|string',
                'composition' => 'required|json', // La composition doit être un JSON valide
            ]);

            // Mettre à jour l'élément dans la table "carte"
            DB::table('carte')
                ->where('idElement', $id)
                ->update([
                    'nom' => $validated['nom'],
                    'typePlat' => $validated['categorieElementCarte'],
                    'prix' => $validated['prix'],
                    'prixServeur' => $validated['prixServeur'],
                    'description' => $validated['description'],
                    'ingredientsElements' => $validated['composition'],
                ]);

            return response()->json(['success' => true, 'message' => 'Élément mis à jour avec succès']);
        } catch (\Exception $e) {
            // Gérer les erreurs et renvoyer une réponse JSON
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
}
