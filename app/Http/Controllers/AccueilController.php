<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        $actus = DB::table('actus')
            ->orderBy('date', 'desc')
            ->limit(1)
            ->get();
    
        return $actus;
    }

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

    private function recupFestiVendredi()
    {
        // Récupérer la date actuelle
        $dateActuelle = Carbon::now()->format('d-m-Y');

        // Récupérer le prochain événement Festi'vendredi
        $festiVendredi = DB::table('events')
            ->where('typeEvent', 1) // 1: Festi'vendredi
            ->where('date', '>=', $dateActuelle)
            ->orderBy('date', 'asc')
            ->first();

        return $festiVendredi;
    }

    private function recupCommandeEnCours($numeroCompte)
    {
        // Récupérer la commande en cours pour l'utilisateur
        $commande = DB::table('commandes')
            ->where('numeroCompte', $numeroCompte)
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
            $positionChaud = DB::table('commandes')
                ->where('etat', 1) // Commandes en cours
                ->where('categorieCommande', 2) // 2 : Chaud
                ->where('categorieCommande', 1) // 1: Hotdog
                ->where('date', '<', $commande->date)
                ->count() + 1;
        } elseif ($commande->categorieCommande == 0) { // 0 : Froid
            $positionFroid = DB::table('commandes')
                ->where('etat', 1) // Commandes en cours
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

        // Récupérer le numéro de compte de l'utilisateur connecté
        $numeroCompte = auth()->user()->numeroCompte ?? null;

        // Récupérer les informations sur la commande en cours
        $commandeEnCours = $numeroCompte ? $this->recupCommandeEnCours($numeroCompte) : null;

        // Récupérer les informations sur Festi'vendredi
        $festiVendredi = $this->recupFestiVendredi();

        return view('accueil', [
            'actus' => $actus,
            'ouvert' => $info['ouvert'],
            'horairesDebutCommandes' => $info['horairesDebutCommandes'],
            'horairesFinCommandes' => $info['horairesFinCommandes'],
            'commandeEnCours' => $commandeEnCours,
            'festiVendredi' => $festiVendredi,
        ]);
    }
}