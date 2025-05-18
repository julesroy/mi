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
        $snacks = DB::table('carteElements')
            ->whereIn('typePlat', [1, 2])
            ->get();

        return view('commander', compact('plats', 'menus', 'viandes', 'ingredients', 'snacks'));
    }

    public function validerCommande(Request $request)
    {
        try {
            $panier = $request->input('panier');
            $panier = json_decode($panier, true); // on décode le panier

            // on génère un identifiant unique pour la commande
            $numeroCommande = '';
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            for ($i = 0; $i < 6; $i++) {
                $numeroCommande .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            foreach ($panier as $commande) {
                $idMenu = $commande['idMenu'] ?? null;

                // traitement des plats
                if (isset($commande['plats'])) {
                    foreach ($commande['plats'] as $plat) {
                        $finalIngredients = [];

                        $allElements = array_map('trim', explode(';', $plat['ingredientsElements']));

                        $indexedElements = [];
                        foreach ($allElements as $element) {
                            [$id, $qte, $type] = explode(',', $element);
                            $indexedElements[$id] = $element;
                        }

                        foreach ($plat['ingredients'] as $ingredientId) {
                            if (isset($indexedElements[$ingredientId])) {
                                $finalIngredients[] = $indexedElements[$ingredientId];
                            }
                        }

                        foreach ($allElements as $element) {
                            $parts = explode(',', $element);
                            if (isset($parts[2]) && $parts[2] == '2') {
                                if (!in_array($element, $finalIngredients)) {
                                    $finalIngredients[] = $element;
                                }
                            }
                        }

                        $ingredientString = implode(';', $finalIngredients);

                        DB::table('commandes')->insert([
                            'numeroCommande'    => $numeroCommande,
                            'prix'              => $plat['prix'],
                            'etat'              => 0,
                            'stock'             => $ingredientString,
                            'menu'              => $idMenu ?? 0, // 0 si plat à la carte
                            'commentaire'       => '',
                            'numeroCompte'      => Auth::user()->numeroCompte,
                            'categorieCommande' => $plat['categoriePlat'] ?? 99,
                        ]);
                    }
                }

                // traitement des snacks
                if (isset($commande['snacks'])) {
                    foreach ($commande['snacks'] as $snack) {
                        $ingredientStringSnacks = $snack['ingredientsElements'] ?? '';

                        DB::table('commandes')->insert([
                            'numeroCommande'    => $numeroCommande,
                            'prix'              => $snack['prix'] ?? 0,
                            'etat'              => 3,
                            'stock'             => $ingredientStringSnacks,
                            'menu'              => $idMenu ?? 0,
                            'commentaire'       => '',
                            'numeroCompte'      => Auth::user()->numeroCompte,
                            'categorieCommande' => $snack['categoriePlat'] ?? 3,
                        ]);
                    }
                }
            }

            return redirect('/')->with('success', 'Votre commande a été validée avec succès !'); // on redirige vers la page d'accueil avec un message de succès
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
