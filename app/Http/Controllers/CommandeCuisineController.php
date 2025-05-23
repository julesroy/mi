<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Commande;
use App\Models\Ingredient;
use App\Models\Menu;

/**
 * CommandeCuisineController
 *
 * Ce contrôleur gère les opérations liées aux commandes en cuisine.
 * Il permet d'afficher, modifier et gérer les commandes.
 */
class CommandeCuisineController extends Controller
{
    /**
     * Affiche la page de gestion des commandes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.commandes');
    }

    /**
     * Affiche la vue de la cuisine pour les commandes.
     *
     * @return \Illuminate\View\View
     */
    public function vueCuisine()
    {
        // Récupère uniquement les noms des menus, dans l'ordre
        $menus = Menu::select('nom', 'idMenu')->orderBy('idMenu')->get()->keyBy('idMenu')->map(fn($menu) => $menu->nom);

        return view('admin.affichage-cuisine', compact('menus'));
    }

    /**
     * Récupère les commandes du jour.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCommandes(Request $request)
    {
        try {
            // Cherche toutes les commandes de la journée par date, ainsi que les infos nécessaires de l'utilisateur
            $query = Commande::with(['utilisateur' => fn($query) => $query->select('idUtilisateur', 'nom', 'prenom')])
                ->whereDate('commandes.date', Carbon::today())
                ->whereIn('commandes.etat', [0, 1, 2, 3, 4])
                ->orderBy('commandes.date', 'asc');

            $commandes = $query->get();

            return response()->json($commandes);
        } catch (\Exception $e) {
            return response()->json([$this->getTestCommande()]);
        }
    }

    /**
     * Récupère les données des plats à préparer en cuisine actuellement
     * @return \Illuminate\Http\JsonResponse
     */
    public function aCuisiner()
    {
        // Récupère tous les ingrédients de la BDD avant (réduit l'impact sur la performance)
        $ingredients = Ingredient::select('idIngredient', 'nom')->get();

        $commandes = Commande::whereIn('categorieCommande', [0, 1, 2])->get()->map(function ($commande) use ($ingredients) {
            // Va chercher tous les ingrédients de la commande
            $commande->items = array_map(function ($item) use ($ingredients) {
                [$itemId, $quantity, $optional] = explode(',', $item);

                // Récupère l'ingrédient, et ajoute ses informations additionnelles
                $ingredient = $ingredients->where('idIngredient', $itemId)->first();
                $ingredient->optionnel = intval($optional);
                $ingredient->quantite = $quantity;

                return $ingredient;
            }, explode(';', $commande->stock));
            return $commande;
        });

        return response()->json($commandes);
    }

    /**
     * Récupère les détails d'une commande.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCommandeDetails(int $id)
    {
        try {
            $commande = Commande::with(['utilisateur' => fn($query) => $query->select('idUtilisateur', 'nom', 'prenom')])
                ->select(
                    'commandes.idCommande',
                    'commandes.numeroCommande',
                    'commandes.commentaire',
                    'commandes.stock'
                )
                ->where('commandes.idCommande', $id)
                ->first();

            if (!$commande) {
                return response()->json(['error' => 'Commande non trouvée'], 404);
            }

            // On retourne simplement le stock brut, le traitement sera fait côté client
            return response()->json($commande);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Marque une commande comme payée.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function marquerCommandePayee(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non payeable'], 400);
        }

        try {
            Commande::where('idCommande', $id)
                ->update(['etat' => 1]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Marque une commande comme prête.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function marquerCommandePrete(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non modifiable'], 400);
        }

        try {
            Commande::where('idCommande', $id)
                ->update(['etat' => 2]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Marque une commande comme servie.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function marquerCommandeServie(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non serviable'], 400);
        }

        try {
            Commande::where('idCommande', $id)
                ->update(['etat' => 3]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Modifie une commande.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifierCommande(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'commentaire' => 'nullable|string',
                'items' => 'required|array',
                'items.*.idIngredient' => 'required|integer',
                'items.*.quantite' => 'required|integer|min:1',
                'items.*.obligatoire' => 'required|integer|in:0,1'
            ]);

            // Construire la chaîne stock
            $stockItems = [];
            foreach ($validated['items'] as $item) {
                $stockItems[] = implode(',', [
                    $item['idIngredient'],
                    $item['quantite'],
                    $item['obligatoire']
                ]);
            }
            $stockValue = implode(';', $stockItems);

            // Mettre à jour la commande
            Commande::where('idCommande', $id)
                ->update([
                    'commentaire' => $validated['commentaire'] ?? null,
                    'stock' => $stockValue
                ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Annule une commande.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function annulerCommande(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non modifiable'], 400);
        }

        try {
            Commande::where('idCommande', $id)
                ->update(['etat' => 4]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Récupère la commande de test.
     *
     * @param int $etat
     * @return string
     */
    private function getTestCommande()
    {
        return [
            'idCommande' => 999,
            'numeroCommande' => 'CMD-TEST',
            'nomClient' => 'Client Test',
            'prenomClient' => 'Prénom Test',
            'categorieCommande' => 2,
            'prix' => 12.5,
            'date' => now()->toDateTimeString(),
            'commentaire' => 'COMMANDE TEST - Vérifiez la connexion à la base de données',
            'etat' => 1,
        ];
    }

    private function getEtatText($etat)
    {
        $etats = [
            0 => 'Non payée',
            1 => 'Payée',
            2 => 'Prête',
            3 => 'Servie',
            4 => 'Annulée',
        ];
        return $etats[$etat] ?? 'Inconnu';
    }

    private function getTypeText($type)
    {
        $types = [
            0 => 'Froid',
            1 => 'Hot-dog',
            2 => 'Chaud',
        ];
        return $types[$type] ?? 'Non spécifié';
    }
}
