<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Carte;
use App\Models\Inventaire;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * CommandeUtilisateurController
 *
 * Ce contrôleur gère les opérations liées à la commande utilisateur.
 * Il permet d'afficher le menu, de valider une commande et de gérer les paniers.
 */
class CommandeUtilisateurController extends Controller
{
    /**
     * Affiche la page de commande.
     *
     * Récupère les plats, menus, viandes et ingrédients disponibles dans la base de données
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $plats = Carte::where('typePlat', 0)->get();
        $menus = Menu::get();
        $viandes = Inventaire::where('categorieIngredient', 1)->get();
        $ingredients = Inventaire::all();
        $snacks = Carte::whereIn('typePlat', [1, 2])->get();

        return view('commander', compact('plats', 'menus', 'viandes', 'ingredients', 'snacks'));
    }

    /**
     * Valide la commande de l'utilisateur, l'ajoute à la base de données.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

                        Commande::insert([
                            'numeroCommande'    => $numeroCommande,
                            'prix'              => $plat['prix'],
                            'etat'              => 0,
                            'stock'             => $ingredientString,
                            'menu'              => $idMenu ?? 0, // 0 si plat à la carte
                            'commentaire'       => '',
                            'idUtilisateur'      => Auth::id(),
                            'categorieCommande' => $plat['categoriePlat'] ?? 99,
                        ]);
                    }
                }

                // traitement des snacks
                if (isset($commande['snacks'])) {
                    foreach ($commande['snacks'] as $snack) {
                        $ingredientStringSnacks = $snack['ingredientsElements'] ?? '';

                        Commande::insert([
                            'numeroCommande'    => $numeroCommande,
                            'prix'              => $snack['prix'] ?? 0,
                            'etat'              => 3,
                            'stock'             => $ingredientStringSnacks,
                            'menu'              => $idMenu ?? 0,
                            'commentaire'       => '',
                            'idUtilisateur'      => Auth::id(),
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
