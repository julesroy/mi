<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Classe de gestion/affichage du planning
 */
class PlanningController extends Controller
{
    public function afficher(Request $req)
    {
        // Durée à chercher sur la DB (jour, semaine ou mois)
        $timeRange = $req->input('scope');
        // Date autour de laquelle chercher (valeur par défaut : aujourd'hui)
        $date = strtotime($req->input('date') ?? "Today");

        // Query de la réservation + nom prénom de la personne inscrite
        $query = DB::table('planning')
            ->leftJoin('utilisateurs', 'utilisateurs.idUtilisateur', '=', 'planning.numeroCompte')
            ->select(['date', 'poste', 'idInscription', 'utilisateurs.prenom', 'utilisateurs.nom', 'planning.numeroCompte']);

        // Fetch pour 1 mois (t = nb de jours dans le mois)
        if ($timeRange == "month") $query = $query->where([['date', '>=', date('Ym01', $date)], ['date', '<=', date('Ymt', $date)]]);

        // Fetch pour 1 jour
        else if ($timeRange == "day") $query = $query->where('date', '=', date('Ymd', $date));

        // Sinon, fetch pour 1 semaine
        else $query = $query->where([['date', '>=', date("Ymd", strtotime("Monday this week", $date))], ['date', '<=', date("Ymd", strtotime("Sunday this week", $date))]]);

        return view('admin.planning', ['planning' => $query->get(), 'scope' => $timeRange, 'date' => date('Y-m-d', $date), 'userId' => Auth::id(), 'userPrivileges']);
    }

    public function supprimer(Request $req)
    {
        $idInscription = $req->json()->get('idInscription');

        $query = DB::table('planning')
            ->where('idInscription', '=', $idInscription);

        // Vérifie si l'utilisateur est super-admin ou non
        if ($req->acces < 3) {
            // Si l'utilisateur tente de supprimer un créneau qui n'est pas sien, on le ratio
            $inscriptionUserId = $query->first()->numeroCompte;
            if($inscriptionUserId != Auth::id()) return response("Accès admin requis", 403); // Accès manquant, donc erreur 403
        }

        // On va tenter de supprimer l'inscription donnée

        $query->delete();

        return response("Désinscription effectuée", 200);
    }
}
