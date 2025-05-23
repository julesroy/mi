<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Permet de manipuler les dates

/**
 * TresorerieController
 *
 * Ce contrôleur gère l'affichage de la page de la trésorerie.
 * Il récupère les informations sur les comptes utilisateurs, le solde total,
 * le solde de la caisse et les statistiques des comptes.
 */
class TresorerieController extends Controller
{
    /**
     * Récupère le solde total de tous les comptes utilisateurs.
     *
     * @return float
     */
    private function obtenirSoldeTotalComptes()
    {
        // On récupère le solde total de tous les utilisateurs
        $resultat = Utilisateur::sum('solde');

        return $resultat ?? 0; // Si aucun solde n'est trouvé, on retourne 0
    }

    /**
     * Récupère le solde de la caisse.
     *
     * @return float
     */
    private function obtenirSoldeCaisse()
    {
        // On récupère le solde de la caisse
        $resultat = DB::table('tresorerie')->select('contenuCaisse')->first();

        return $resultat->solde ?? 0; // Si aucun solde n'est trouvé, on retourne 0
    }

    /**
     * Récupère les statistiques des comptes utilisateurs.
     *
     * @return array
     */
    private function obtenirStatistiquesComptes()
    {
        // On récupère le nombre total de comptes et les comptes crédités, non crédités et à découvert
        $comptesTotal = Utilisateur::count();
        $comptesCredites = Utilisateur::where('solde', '>', 0)->count();
        $comptesNonCredites = Utilisateur::where('solde', '=', 0)->count();
        $comptesDecouverts = Utilisateur::where('solde', '<', 0)->count();

        // On retourne les statistiques sous forme de tableau
        return [
            'total' => $comptesTotal,
            'credites' => $comptesCredites,
            'non_credites' => $comptesNonCredites,
            'decouverts' => $comptesDecouverts,
        ];
    }

    /**
     * Affiche la page de la trésorerie.
     *
     * @return \Illuminate\View\View
     */
    public function afficher()
    {

        //On recupère tous les comptes utilisateurs
        $utilisateurs = Utilisateur::all();

        // On renvoie la vue tresorerie avec le solde total
        $soldeTotal = $this->obtenirSoldeTotalComptes();

        // On récupère le solde de la caisse
        $soldeCaisse = $this->obtenirSoldeCaisse();

        // On récupère les statistiques des comptes
        $statistiquesComptes = $this->obtenirStatistiquesComptes();

        // Comptes crédités
        $comptesCredites = Utilisateur::where('solde', '>', 0)->get();

        // Comptes non crédités
        $comptesNonCredites = Utilisateur::where('solde', '=', 0)->get();

        // Comptes à découvert
        $comptesDecouverts = Utilisateur::where('solde', '<', 0)->get();

        // Commandes depuis le début de l'année
        $commandesAnnee = Commande::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->where('etat', 3)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Commandes depuis le début du mois
        $commandesMois = Commande::selectRaw('DAY(date) as day, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('etat', 3)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Commandes depuis le début de la semaine
        $commandesSemaine = Commande::selectRaw('DAY(date) as day, COUNT(*) as count')
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('etat', 3)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Commandes depuis le début de la journée
        $commandesJour = Commande::selectRaw('HOUR(date) as hour, COUNT(*) as count')
            ->whereDate('date', Carbon::now()->toDateString())
            ->where('etat', 3)
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
