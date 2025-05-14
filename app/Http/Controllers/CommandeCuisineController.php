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
            return response()->json(['error' => 'Commande test non modifiable'], 400);
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
        if ($id == 999) {
            return response()->json(['error' => 'Commande test non modifiable'], 400);
        }

        try {
            $validated = $request->validate([
                'commentaire' => 'nullable|string',
                'items' => 'nullable|array',
            ]);

            DB::table('commandes')
                ->where('idCommande', $id)
                ->update([
                    'commentaire' => $validated['commentaire'] ?? null,
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
