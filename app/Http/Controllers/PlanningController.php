<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Classe de gestion/affichage du planning
 */
class PlanningController extends Controller
{
    public function afficher(Request $req)
    {
        $servers = [];
        // Récupère les serveurs et leurs noms si l'utilisateur actuel est un superadmin
        if (Auth::user()->acces == 3) {
            $servers = DB::table('utilisateurs')
                ->select(['idUtilisateur', 'nom', 'prenom'])
                ->where('acces', '>', '0')
                ->get();
        }

        return view('admin.planning', ['userId' => Auth::id(), 'servers' => $servers]);
    }

    public function donnees(Request $req, $date)
    {
        $planning = [];

        // Date autour de laquelle chercher (valeur par défaut : aujourd'hui)
        $date = new DateTime($date);

        // Date de début du calendrier (potentiellement le mois précédent)
        $startDay = new DateTime($date->format('Y-m-01'))->modify('Monday this week');

        // Date de fin du calendrier (potentiellement le mois suivant)
        $endDay = new DateTime($date->format('Y-m-t'))->modify('Sunday this week');


        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDay, $interval, $endDay, DatePeriod::INCLUDE_END_DATE);

        foreach ($period as $day) {
            // On ignore les weekends (pour ne pas transférer de données inutiles)
            if ($day->format('N') >= 6) continue;

            // 4 tableaux par jour : 1 par poste
            $planning[$day->format('Y-m-d')] = [
                [],
                [],
                [],
                []
            ];
        }

        // Query de la réservation + nom prénom de la personne inscrite
        $data = DB::table('planning')
            ->leftJoin('utilisateurs', 'utilisateurs.idUtilisateur', '=', 'planning.numeroCompte')
            ->select(['date', 'poste', 'idInscription', 'utilisateurs.prenom', 'utilisateurs.nom', 'planning.numeroCompte'])
            ->where([['date', '>=', $startDay->format('Ymd')], ['date', '<=', $endDay->format('Ymd')]])->get();

        foreach ($data as $day) {
            array_push($planning[$day->date][$day->poste], ['id' => $day->idInscription, 'numeroCompte' => $day->numeroCompte, 'nom' => $day->prenom . ' ' . strtoupper($day->nom)]);
        }

        return response()->json($planning);
    }

    public function supprimer(Request $req, $idInscription, $date)
    {
        $query = DB::table('planning')->where('idInscription', '=', $idInscription);

        // Vérifie si l'utilisateur est super-admin ou non
        if (Auth::user()->acces < 3) {
            // Si l'utilisateur tente de supprimer un créneau qui n'est pas sien, on le ratio
            $inscriptionUserId = $query->first()->numeroCompte;
            if ($inscriptionUserId != Auth::id()) {
                return response('Accès admin requis', 403);
            } // Accès manquant, donc erreur 403
        }

        // On va tenter de supprimer l'inscription donnée
        $query->delete();

        // Si l'on a supprimé l'inscription, on renvoie les nouvelles données
        return $this->donnees($req, $date);
    }

    public function ajouter(Request $req)
    {
        $serverId = $req->input('serveur');
        $job = intval($req->input('poste'));
        // Force la validité de la date
        $date = date('Y-m-d', strtotime($req->input('date')));

        // Vérification des droits de l'utilisateur
        if (Auth::user()->acces < 3 && $serverId != Auth::id()) {
            return response('Inscription impossible pour un autre compte que le sien', 403);
        }

        // Vérifie que le numéro de compte existe bien
        if (empty(DB::table('utilisateurs')->where('idUtilisateur', $serverId)->first())) return response("Serveur inexistant " . $serverId . $date . ' ' . $req->input('date') . ' ' . $job . ' !', 400);

        // Validité du numéro de job
        if ($job > 4 || $job < 0) {
            return response('Poste donné invalide', 400);
        }

        // Si on a l'accès, ajoute l'entrée dans la DB
        DB::table('planning')->insert([
            'poste' => $job,
            'date' => $date,
            'numeroCompte' => $serverId,
        ]);

        // Si l'on a réussi à insérer la ligne, on renvoie les nouvelles données
        return $this->donnees($req, $date);
    }
}
