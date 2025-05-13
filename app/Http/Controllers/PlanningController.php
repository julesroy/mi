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
        $servers = [];
        // Récupère les serveurs et leurs noms si l'utilisateur actuel est un superadmin
        if ($req->acces == 3) {
            $servers = DB::table('utilisateurs')
                ->select(['idUtilisateur', 'nom', 'prenom'])
                ->where('acces', '>', '0')
                ->get();
        }

        return view('admin.planning', ['userId' => Auth::id(), 'servers' => $servers]);
    }

    public function donnees(Request $req, $date)
    {
        // Date autour de laquelle chercher (valeur par défaut : aujourd'hui)
        $date = strtotime($date);

        // Query de la réservation + nom prénom de la personne inscrite
        $query = DB::table('planning')
            ->leftJoin('utilisateurs', 'utilisateurs.idUtilisateur', '=', 'planning.numeroCompte')
            ->select(['date', 'poste', 'idInscription', 'utilisateurs.prenom', 'utilisateurs.nom', 'planning.numeroCompte'])
            ->orderBy('date')
            ->where([['date', '>=', date('Ym01', $date)], ['date', '<=', date('Ymt', $date)]]);

        return response()->json($query->get());
    }

    public function supprimer(Request $req, $idInscription)
    {
        $query = DB::table('planning')->where('idInscription', '=', $idInscription);

        // Vérifie si l'utilisateur est super-admin ou non
        if ($req->acces < 3) {
            // Si l'utilisateur tente de supprimer un créneau qui n'est pas sien, on le ratio
            $inscriptionUserId = $query->first()->numeroCompte;
            if ($inscriptionUserId != Auth::id()) {
                return response('Accès admin requis', 403);
            } // Accès manquant, donc erreur 403
        }

        // On va tenter de supprimer l'inscription donnée

        $query->delete();

        return response('Désinscription effectuée', 200);
    }

    public function ajouter(Request $req)
    {
        $serverId = $req->input('serveur');
        $job = intval($req->input('poste'));
        $date = $req->input('date');

        // Vérification des droits de l'utilisateur
        if ($req->acces < 3 && $serverId != Auth::id()) {
            return response('Inscription impossible pour un autre compte que le sien', 403);
        }

        // Vérifie que le numéro de compte existe bien
        $noAccount = empty(DB::table('utilisateurs')->where('idUtilisateur', '=', $serverId)->first());

        // Validité du numéro de job
        if ($job > 4 || $job < 0 || $noAccount) {
            return response('Valeurs données invalides', 400);
        }

        // Si on a l'accès, ajoute l'entrée dans la DB
        DB::table('planning')->insert([
            'poste' => $job,
            'date' => $date,
            'numeroCompte' => $serverId,
        ]);

        // Retourne un succès
        return back();
    }
}
