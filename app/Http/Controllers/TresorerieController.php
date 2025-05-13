<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Permet de manipuler les dates

class TresorerieController extends Controller
{
    private function obtenirSoldeTotal()
    {
        // On récupère le solde total de tous les utilisateurs
        $resultat = DB::table('utilisateurs')->select(DB::raw('SUM(solde) as solde_total'))->first();

        return $resultat->solde_total ?? 0; // Si aucun solde n'est trouvé, on retourne 0
    }

    private function obtenirStatistiquesComptes()
    {
        // On récupère le nombre total de comptes et les comptes crédités, non crédités et à découvert
        $comptesTotal = DB::table('utilisateurs')->count();
        $comptesCredites = DB::table('utilisateurs')->where('solde', '>', 0)->count();
        $comptesNonCredites = DB::table('utilisateurs')->where('solde', '=', 0)->count();
        $comptesDecouverts = DB::table('utilisateurs')->where('solde', '<', 0)->count();

        // On retourne les statistiques sous forme de tableau
        return [
            'total' => $comptesTotal,
            'credites' => $comptesCredites,
            'non_credites' => $comptesNonCredites,
            'decouverts' => $comptesDecouverts,
        ];
    }

    public function afficher()
    {
        //On recupère tous les comptes utilisateurs
        $utilisateurs = DB::table('utilisateurs')->get();

        // On renvoie la vue tresorerie avec le solde total
        $soldeTotal = $this->obtenirSoldeTotal();

        // On récupère les statistiques des comptes
        $statistiquesComptes = $this->obtenirStatistiquesComptes();

        // Commandes depuis le début de l'année
        $commandesAnnee = DB::table('commandes')
            ->whereYear('date', Carbon::now()->year)
            ->where('etat', 1) // Filtrer uniquement les commandes validées
            ->count();

        // Commandes depuis le début du mois
        $commandesMois = DB::table('commandes')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('etat', 1) // Filtrer uniquement les commandes validées
            ->count();
        // Commandes depuis le début de la semaine
        $commandesSemaine = DB::table('commandes')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->whereDay('date', '>=', Carbon::now()->startOfWeek()->day)
            ->where('etat', 1) // Filtrer uniquement les commandes validées
            ->count();

        // Commandes depuis le début de la journée
        $commandesJour = DB::table('commandes')
            ->whereDate('date', Carbon::now()->toDateString())
            ->where('etat', 1) // Filtrer uniquement les commandes validées
            ->count();

        // Comptes non crédités
        $comptesNonCredites = DB::table('utilisateurs')->where('solde', '=', 0)->get();

        // Comptes à découvert
        $comptesDecouverts = DB::table('utilisateurs')->where('solde', '<', 0)->get();

        return view('tresorerie', [
            'utilisateurs' => $utilisateurs,
            'solde' => $soldeTotal,
            'stats' => $statistiquesComptes,
            'commandesAnnee' => $commandesAnnee,
            'commandesMois' => $commandesMois,
            'commandesSemaine' => $commandesSemaine,
            'commandesJour' => $commandesJour,
            'comptesNonCredites' => $comptesNonCredites,
            'comptesDecouverts' => $comptesDecouverts,
        ]);
    }
}
