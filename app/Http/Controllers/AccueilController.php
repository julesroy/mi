<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actu;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * AccueilController
 *
 * Ce contrôleur gère l'affichage de la page d'accueil de l'application.
 * Il récupère les actualités, les informations sur le service et la commande en cours.
 */
class AccueilController extends Controller
{
    /**
     * Récupère les actualités.
     *
     * @return \Illuminate\Support\Collection
     */
    private function recupActus()
    {
        // On récupère la dernière actualité
        $actus = Actu::orderBy('date', 'desc')
            ->limit(1)
            ->get();

        return $actus;
    }

    /**
     * Récupère les informations sur le service.
     *
     * @return array
     */
    private function recupInfo()
    {
        $ouvert = DB::table('parametres')->value('service');
        $horairesDebutCommandes = DB::table('parametres')->value('horairesDebutCommandes');
        $horairesFinCommandes = DB::table('parametres')->value('horairesFinCommandes');

        // Formattage des horaires
        $horairesDebutCommandes = Carbon::parse($horairesDebutCommandes)->format('H\h');
        $horairesFinCommandes = Carbon::parse($horairesFinCommandes)->format('H\h');
        return [
            'ouvert' => $ouvert,
            'horairesDebutCommandes' => $horairesDebutCommandes,
            'horairesFinCommandes' => $horairesFinCommandes
        ];
    }

    /**
     * Récupère la commande en cours pour l'utilisateur.
     *
     * @param string $idUtilisateur
     * @return array|null
     */
    private function recupCommandeEnCours($idUtilisateur)
    {
        // Récupérer la commande en cours pour l'utilisateur
        $commande = Commande::where('idUtilisateur', $idUtilisateur)
            ->where('etat', 1) // 1 : Commande en cours
            ->orderBy('date', 'asc')
            ->first();

        if (!$commande) {
            return null; // Pas de commande en cours
        }

        // Initialiser les positions à null
        $positionChaud = null;
        $positionFroid = null;

        // Vérifier la catégorie de la commande et calculer la position uniquement pour cette catégorie
        if ($commande->categorieCommande == 2 || $commande->categorieCommande == 1) { //Chaud ou hotdog
            $positionChaud = Commande::where('etat', 1) // Commandes en cours
                ->where('categorieCommande', 2) // 2 : Chaud
                ->where('categorieCommande', 1) // 1: Hotdog
                ->where('date', '<', $commande->date)
                ->count() + 1;
                
        } elseif ($commande->categorieCommande == 0) { // 0 : Froid
            $positionFroid = Commande::where('etat', 1) // Commandes en cours
                ->where('categorieCommande', 0) // 0 : Froid
                ->where('date', '<', $commande->date)
                ->count() + 1;
        }

        return [
            'numeroCommande' => $commande->numeroCommande,
            'positionChaud' => $positionChaud,
            'positionFroid' => $positionFroid,
        ];
    }

    /**
     * Affiche la page d'accueil.
     *
     * @return \Illuminate\View\View
     */
    public function afficher()
    {
        $actus = $this->recupActus();
        $info = $this->recupInfo();

        // Récupérer l'ID de l'utilisateur connecté
        $idUtilisateur = Auth::id() ?? null;

        // Récupérer les informations sur la commande en cours
        $commandeEnCours = $idUtilisateur ? $this->recupCommandeEnCours($idUtilisateur) : null;

        return view('accueil', [
            'actus' => $actus,
            'ouvert' => $info['ouvert'],
            'horairesDebutCommandes' => $info['horairesDebutCommandes'],
            'horairesFinCommandes' => $info['horairesFinCommandes'],
            'commandeEnCours' => $commandeEnCours,
        ]);
    }
}
