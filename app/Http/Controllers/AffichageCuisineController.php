<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffichageCuisineController extends Controller
{
    /**
     * Affiche la page de la cuisine avec les commandes en cours.
     *
     * @return \Illuminate\View\View
     */
    public function afficher()
    {
        // On récupère toutes les commandes en cours (etat = 1)
        // et on les trie par date décroissante (plus récentes en premier)
        $commandes = DB::table('commandes')
            ->where('etat', 1)
            ->orderBy('date', 'desc')
            ->get();

        // On passe simplement la variable $commandes à la vue
        return view('admin.affichage-cuisine', compact('commandes'));
    }
    
    /**
     * Met à jour l'état d'une commande.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEtat($id, Request $request)
    {
        DB::table('commandes')
            ->where('idCommande', $id)
            ->update(['etat' => $request->etat]);
            
        return redirect()->back()->with('success', 'État de la commande mis à jour');
    }
}