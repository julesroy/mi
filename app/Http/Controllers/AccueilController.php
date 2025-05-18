<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


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
        $serviceMidi = DB::table('parametres')->value('horairesCommandes');
       
        // dd($serviceMidi); // Debug the value here

        return [
            'ouvert' => $ouvert,
            'serviceMidi' => $serviceMidi
        ];
    }

    private function recupCommandes() {
            $numeroCompte = DB::table('utilisateurs')->value('numeroCompte');
            $commandes = DB::table('commandes')
                ->where('numeroCompte', $numeroCompte) -> count();
    
            return $commandes;
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
        $commandes = $this->recupCommandes();
        return view('accueil',
            [
                'actus' => $actus,
                'commandes' => $commandes,
                'ouvert' => $info['ouvert'],
                'serviceMidi' => $info['serviceMidi'],
            ]);
    }
}