<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Permet de manipuler les dates

class TresorerieController extends Controller
{
    private function obtenirSoldeTotalComptes()
    {
        // On récupère le solde total de tous les utilisateurs
        $resultat = DB::table('utilisateurs')->select(DB::raw('SUM(solde) as solde_total'))->first();

        return $resultat->solde_total ?? 0; // Si aucun solde n'est trouvé, on retourne 0
    }

    private function obtenirSoldeCaisse()
    {
        // On récupère le solde de la caisse
        $resultat = DB::table('tresorerie')->select('contenuCaisse')->first();

        return $resultat->solde ?? 0; // Si aucun solde n'est trouvé, on retourne 0
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
        $soldeTotal = $this->obtenirSoldeTotalComptes();

        // On récupère le solde de la caisse
        $soldeCaisse = $this->obtenirSoldeCaisse();

        // On récupère les statistiques des comptes
        $statistiquesComptes = $this->obtenirStatistiquesComptes();

        // Comptes crédités
        $comptesCredites = DB::table('utilisateurs')->where('solde', '>', 0)->get();

        // Comptes non crédités
        $comptesNonCredites = DB::table('utilisateurs')->where('solde', '=', 0)->get();

        // Comptes à découvert
        $comptesDecouverts = DB::table('utilisateurs')->where('solde', '<', 0)->get();

        // Commandes depuis le début de l'année
        $commandesAnnee = DB::table('commandes')
            ->selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->where('etat', 1)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Commandes depuis le début du mois
        $commandesMois = DB::table('commandes')
            ->selectRaw('DAY(date) as day, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('etat', 1)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Commandes depuis le début de la semaine
        $commandesSemaine = DB::table('commandes')
            ->selectRaw('DAY(date) as day, COUNT(*) as count')
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('etat', 1)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Commandes depuis le début de la journée
        $commandesJour = DB::table('commandes')
            ->selectRaw('HOUR(date) as hour, COUNT(*) as count')
            ->whereDate('date', Carbon::now()->toDateString())
            ->where('etat', 1)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return view('admin.tresorerie', [
            'utilisateurs' => $utilisateurs,
            'solde' => $soldeTotal,
            'caisse' => $soldeCaisse,
            'stats' => $statistiquesComptes,
            'commandesAnnee' => $commandesAnnee,
            'commandesMois' => $commandesMois,
            'commandesSemaine' => $commandesSemaine,
            'commandesJour' => $commandesJour,
            'comptesCredites' => $comptesCredites,
            'comptesNonCredites' => $comptesNonCredites,
            'comptesDecouverts' => $comptesDecouverts,
        ]);
    }
}
