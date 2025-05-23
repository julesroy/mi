<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use App\Models\Inventaire;

/**
 * PriseCommandeController
 *
 * Ce contrôleur gère l'affichage de la page de prise de commande.
 */
class PriseCommandeController extends Controller
{
    /**
     * Affiche la page de prise de commande.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $carteItems = Carte::select('nom', 'prix', 'typePlat')->get()
            ->map(function ($item) {
                if (in_array($item->typePlat, [5, 6])) {
                    $item->typePlat = 4;
                }
                return $item;
            })
            ->groupBy('typePlat');

        $inventaire = Inventaire::all()->keyBy('nom');

        $typeLabels = [
            0 => 'Plats',
            1 => 'Snacks',
            2 => 'Boissons',
            3 => 'Menus',
            4 => 'Menus spéciaux'
        ];

        return view('admin.prise-commande', compact('carteItems', 'inventaire', 'typeLabels'));
    }
}
