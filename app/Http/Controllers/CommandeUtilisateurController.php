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
        $plats = DB::table('carteElements')->where('typePlat', 0)->get();
        $menus = DB::table('carteMenus')->get();
        $viandes = DB::table('inventaire')->where('categorieIngredient', 1)->get();
        $ingredients = DB::table('inventaire')->get();
        $snacks = DB::table('carteElements')->where('typePlat', 1)->get();
        $boissons = DB::table('carteElements')->where('typePlat', 2)->get();

        return view('commander', compact('plats', 'menus', 'viandes', 'ingredients', 'snacks', 'boissons'));
    }

    public function validerCommande(Request $request)
    {
        try {
            $panier = $request->input();

            // Génération d’un identifiant unique
            $numeroCommande = '';
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            for ($i = 0; $i < 6; $i++) {
                $numeroCommande .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            foreach ($panier['commandes'] as $commande) {
                foreach ($commande['plats'] as $plat) {
                    // Récupération des données du plat
                    $ingredientsElements = DB::table('carte')->where('idElement', $plat['plat'])->value('ingredientsElements');
                    $ingredientsElements = json_decode($ingredientsElements, true);

                    $quantiteViande = 0;
                    $quantiteIngredient = 0;

                    // Quantité de viande
                    foreach ($ingredientsElements['elements'] as $element) {
                        if ($element['idIngredient'] == $plat['viande']) {
                            $quantiteViande = $element['quantite'];
                            break;
                        }
                    }

                    // Quantité d'ingrédient
                    foreach ($ingredientsElements['elements'] as $element) {
                        if ($element['idIngredient'] == $plat['ingredient']) {
                            $quantiteIngredient = $element['quantite'];
                            break;
                        }
                    }

                    $categoriePlat = DB::table('carte')->where('idElement', $plat['plat'])->value('categoriePlat');

                    // Insertion d’un plat
                    DB::table('commandes')->insert([
                        'numeroCommande' => $numeroCommande,
                        'prix' => $commande['prix'],
                        'etat' => 0,
                        'stock' => json_encode([[$plat['viande'] => $quantiteViande, $plat['ingredient'] => $quantiteIngredient]]),
                        'menu' => $commande['menu'],
                        'commentaire' => '',
                        'numeroCompte' => Auth::user()->numeroCompte,
                        'categorieCommande' => $categoriePlat,
                    ]);
                }

                // Insertion des snacks (en tant que commandes séparées)
                foreach ($commande['snacks'] as $snack) {
                    $categorieSnack = DB::table('carte')->where('idElement', $snack['id'])->value('categoriePlat');

                    DB::table('commandes')->insert([
                        'numeroCommande' => $numeroCommande,
                        'prix' => 0, // ou un prix fixe si nécessaire
                        'etat' => 0,
                        'stock' => json_encode([[$snack['id'] => 1]]),
                        'menu' => $commande['menu'],
                        'commentaire' => '',
                        'numeroCompte' => Auth::user()->numeroCompte,
                        'categorieCommande' => $categorieSnack ?? 'Snack',
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Commande validée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
