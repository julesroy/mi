<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GestionComptesController extends Controller
{
    public function afficherComptes(Request $request)
    {
        //On verifie l'entree de l'utilisateur
        $request->validate([
            'recherche' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s]+/',
            'triage' => 'nullable|string|in:solde_desc,solde_asc,nom_asc,nom_desc,prenom_asc,prenom_desc,numeroCompte_asc,numeroCompte_desc'
        ]);

        //On recupere la valeur de recherche
        $recherche = $request->input('recherche');

        //On recupere la valeur de triage
        $triage = $request->input('triage');

        //On renvoie les données de la table utilisateurs selon le terme de recherche utilise
        $utilisateurs = DB::table('utilisateurs')
            ->when($recherche, function ($query, $recherche) {
                $query->where('nom', 'LIKE', "%{$recherche}%")
                      ->orWhere('prenom', 'LIKE', "%{$recherche}%")
                      ->orWhere('numeroCompte', 'LIKE', "%{$recherche}%")
                      ->orWhereRaw("CONCAT(nom, ' ', prenom) LIKE ?", ["%{$recherche}%"])
                      ->orWhereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%{$recherche}%"]);
            })
            ->when($triage, function($query, $triage) {
                switch ($triage) {
                    case 'solde_desc':
                        $query->orderBy('solde', 'desc');
                        break;
                    case 'solde_asc':
                        $query->orderBy('solde', 'asc');
                        break;
                    case 'nom_asc':
                        $query->orderBy('nom', 'asc');
                        break;
                    case 'nom_desc':
                        $query->orderBy('nom', 'desc');
                        break;
                    case 'prenom_asc':
                        $query->orderBy('prenom', 'asc');
                        break;
                    case 'prenom_desc':
                        $query->orderBy('prenom', 'desc');
                        break;
                    case 'numeroCompte_asc':
                        $query->orderBy('numeroCompte', 'asc');
                        break;
                    case 'numeroCompte_desc':
                        $query->orderBy('numeroCompte', 'desc');
                        break;
                }
            })
            ->get();

        //On renvoie la vue avec les utilisateurs et le terme de recherche
        return view('gestion-comptes', compact('utilisateurs', 'recherche', 'triage'));
    }
}