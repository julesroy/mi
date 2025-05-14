<?php

namespace App\Http\Controllers;

use App\Models\PriseCommandeCarte;
use App\Models\PriseCommandeInventaire;

class PriseCommandeController extends Controller
{
    public function index()
    {
        $carteItems = PriseCommandeCarte::all()
            ->map(function ($item) {
                if (in_array($item->typePlat, [5, 6])) {
                    $item->typePlat = 4;
                }
                return $item;
            })
            ->groupBy('typePlat');

        $inventaire = PriseCommandeInventaire::all()->keyBy('nom');

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
