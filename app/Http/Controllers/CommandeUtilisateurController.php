<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CommandeUtilisateurController extends Controller
{
    public function index()
    {
        $plats = DB::table('carte')->where('typePlat', 0)->get();
        $menus = DB::table('carte')->where('typePlat', 3)->get();
        $viandes = DB::table('inventaire')->where('categorieIngredient', 1)->get();
        $ingredients = DB::table('inventaire')->where('categorieIngredient', 0)->get();
        $snacks = DB::table('carte')->where('typePlat', 1)->get();
        $boissons = DB::table('carte')->where('typePlat', 2)->get();

        return view('commander', compact('plats', 'menus', 'viandes', 'ingredients', 'snacks', 'boissons'));
    }

    public function validerCommande(Request $request)
    {
        try {
            $panier = $request->input();

            // on génère un identifiant unique pour la commande
            $numeroCommande = strtoupper(Str::random(6));
            $numeroCommande = '';
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            for ($i = 0; $i < 6; $i++) {
                $numeroCommande .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            foreach ($panier['commandes'] as $commande) {
                // on récupère ingredientsElements pour le plat sélectionné
                $ingredientsElements = DB::table('carte')->where('idElement', $commande['plat'])->value('ingredientsElements');
                $ingredientsElements = json_decode($ingredientsElements, true);

                // on initialise les quantités
                $quantiteViande = 0;
                $quantiteIngredient = 0;

                // on parcourt les éléments pour trouver la quantité de l'idIngredient correspondant
                foreach ($ingredientsElements['elements'] as $element) {
                    if ($element['idIngredient'] == $commande['viande']) {
                        $quantiteViande = $element['quantite'];
                        break; // on sort de la boucle dès qu'on a trouvé l'élément
                    }
                }

                // on parcourt les éléments pour trouver la quantité de l'idIngredient correspondant
                foreach ($ingredientsElements['elements'] as $element) {
                    if ($element['idIngredient'] == $commande['ingredient']) {
                        $quantiteIngredient = $element['quantite'];
                        break; // on sort de la boucle dès qu'on a trouvé l'élément
                    }
                }

                // on récupère la catégorie du plat
                $categoriePlat = DB::table('carte')->where('idElement', $commande['plat'])->value('categoriePlat');

                DB::table('commandes')->insert([
                    'numeroCommande' => $numeroCommande,
                    'prix' => $commande['prix'],
                    'etat' => 0,
                    'stock' => json_encode([[$commande['viande'] => $quantiteViande, $commande['ingredient'] => $quantiteIngredient]]),
                    'menu' => 1,
                    'commentaire' => '',
                    'numeroCompte' => Auth::user()->numeroCompte,
                    'categorieCommande' => $categoriePlat,
                    //'snacks' => json_encode($commande['snacks'] ?? [])
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Commande validée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
