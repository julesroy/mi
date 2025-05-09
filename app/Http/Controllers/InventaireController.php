<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock; // Remplace par le nom réel de ton modèle

class InventaireController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Stock::query();

        // Filtres
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('categorie')) {
            $query->where('categorieElement', 'like', '%' . $request->categorie . '%');
        }
        if ($request->filled('etat') && in_array($request->etat, ['0', '1', '2'])) {
            $query->where('etat', $request->etat);
        }

        // Colonnes autorisées pour le tri
        $sortable = [
            'nom', 'categorieElement', 'numeroLot', 'datePeremption',
            'nombrePortions', 'dateOuverture', 'dateFermeture', 'etat'
        ];

        $sort = $request->get('sort', 'nom');
        $direction = $request->get('direction', 'asc');

        // Sécurité : on vérifie que la colonne demandée est autorisée
        if (!in_array($sort, $sortable)) {
            $sort = 'nom';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);

        $stocks = $query->get();

        return view('admin/inventaire', compact('stocks', 'sort', 'direction'));
    }

}


