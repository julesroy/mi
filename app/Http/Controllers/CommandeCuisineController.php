<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeCuisineController extends Controller
{
    public function index()
    {
        return view('admin.commandes');
    }

    public function getCommandes(Request $request)
    {
        try {
            $query = DB::table('commandes')
                ->leftJoin('utilisateurs', 'commandes.numeroCompte', '=', 'utilisateurs.numeroCompte')
                ->select('commandes.idCommande', 'commandes.numeroCommande', 'utilisateurs.nom as nomClient','utilisateurs.prenom as prenomClient', 'commandes.categorieCommande', 'commandes.prix', 'commandes.date', 'commandes.commentaire', 'commandes.etat')
                ->whereDate('commandes.date', Carbon::today())
                ->whereIn('commandes.etat', [0, 1, 2, 3, 4])
                ->orderBy('commandes.date', 'asc');

            $commandes = $query->get();

            if ($commandes->isEmpty()) {
                return response()->json([$this->getTestCommande()]);
            }

            return response()->json($commandes);
        } catch (\Exception $e) {
            return response()->json([$this->getTestCommande()]);
        }
    }
    
    public function getInventaireItems()
    {
        try {
            // Récupère TOUTES les colonnes mais on n'utilisera que idingredient, Nom et categorieingredient
            $items = DB::table('inventaire')
                ->select('*') // Sélectionne toutes les colonnes
                ->orderBy('categorieingredient')
                ->orderBy('idingredient')
                ->get()
                ->map(function ($item) {
                    return [
                        'idIngredient' => $item->idingredient,
                        'nom' => $item->Nom,
                        'categorieIngredient' => $item->categorieingredient,
                        // On garde toutes les données au cas où, mais on n'utilisera que ces 3 champs
                        'fullData' => $item 
                    ];
                });

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function getCommandeDetails($id)
    {
        try {
            $commande = DB::table('commandes')
                ->leftJoin('utilisateurs', 'commandes.numeroCompte', '=', 'utilisateurs.numeroCompte')
                ->select('commandes.idCommande', 'commandes.numeroCommande', 'utilisateurs.nom as nomClient', 
                        'utilisateurs.prenom as prenomClient', 'commandes.commentaire', 'commandes.stock')
                ->where('commandes.idCommande', $id)
                ->first();

            if (!$commande) {
                return response()->json(['error' => 'Commande non trouvée'], 404);
            }

            // On retourne simplement le stock brut, le traitement sera fait côté client
            return response()->json([
                'idCommande' => $commande->idCommande,
                'numeroCommande' => $commande->numeroCommande,
                'nomClient' => $commande->nomClient,
                'prenomClient' => $commande->prenomClient,
                'commentaire' => $commande->commentaire,
                'stock' => $commande->stock // On envoie la chaîne brute directement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function marquerCommandePayee(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non payeable'], 400);
        }

        try {
            DB::table('commandes')
                ->where('idCommande', $id)
                ->update(['etat' => 1]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function marquerCommandePrete(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non modifiable'], 400);
        }

        try {
            DB::table('commandes')
                ->where('idCommande', $id)
                ->update(['etat' => 2]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function marquerCommandeServie(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non serviable'], 400);
        }

        try {
            DB::table('commandes')
                ->where('idCommande', $id)
                ->update(['etat' => 3]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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
        DB::table('commandes')
            ->where('idCommande', $id)
            ->update([
                'commentaire' => $validated['commentaire'] ?? null,
                'stock' => $stockValue
            ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function annulerCommande(Request $request, $id)
    {
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non modifiable'], 400);
        }

        try {
            DB::table('commandes')
                ->where('idCommande', $id)
                ->update(['etat' => 4]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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