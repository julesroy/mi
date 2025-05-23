<?php

namespace App\Http\Controllers;

use App\Models\Commande;

/**
 * AffichageCuisineController
 *
 * Ce contrôleur gère l'affichage de la cuisine.
 * Il récupère les commandes en cours et les affiche sur la page de la cuisine.
 */
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
        $commandes = Commande::where('etat', 1)
            ->orderBy('date', 'desc')
            ->get();

        // On passe simplement la variable $commandes à la vue
        return view('admin.affichage-cuisine', compact('commandes'));
    }
}
