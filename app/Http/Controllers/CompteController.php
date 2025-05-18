<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Paiements du compte
        $paiements = DB::table('paiements')
            ->where('numeroCompte', $user->numeroCompte)
            ->orderByDesc('date')
            ->get();

        // Commandes du compte (on suppose que tu as ajouté une colonne idPaiement dans commandes)
        $commandes = DB::table('commandes')
            ->where('numeroCompte', $user->numeroCompte)
            ->get();

        // Regroupe les commandes par idPaiement
        $commandesParPaiement = [];
        foreach ($paiements as $paiement) {
            $commandesParPaiement[$paiement->idPaiement] = $commandes->where('idPaiement', $paiement->idPaiement)->all();
        }

        // Correspondance articles (idElement => nom) depuis carteElements
        $carteElements = DB::table('carteElements')->get();
        $articlesMap = [];
        foreach ($carteElements as $item) {
            $articlesMap[$item->idElement] = $item->nom;
        }

        return view('compte', [
            'user' => $user,
            'paiements' => $paiements,
            'commandesParPaiement' => $commandesParPaiement,
            'articlesMap' => $articlesMap,
        ]);
    }
}
