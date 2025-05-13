<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GestionComptesController extends Controller
{
    public function afficherComptes(Request $requete)
    {
        // On vérifie l'entrée de l'utilisateur
        $requete->validate([
            'recherche' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s]+/',
            'triage' => 'nullable|string|in:solde_desc,solde_asc,nom_asc,nom_desc,prenom_asc,prenom_desc,numeroCompte_asc,numeroCompte_desc'
        ]);

        // On récupère la valeur de recherche
        $recherche = $requete->input('recherche');

        // On récupère la valeur de triage
        $triage = $requete->input('triage');

        // On récupère les données de la table utilisateurs selon le terme de recherche utilisé
        $utilisateurs = DB::table('utilisateurs')
            ->when($recherche, function ($requete, $recherche) {
                $requete->where('nom', 'LIKE', "%{$recherche}%")
                        ->orWhere('prenom', 'LIKE', "%{$recherche}%")
                        ->orWhere('numeroCompte', 'LIKE', "%{$recherche}%")
                        ->orWhereRaw("CONCAT(nom, ' ', prenom) LIKE ?", ["%{$recherche}%"])
                        ->orWhereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%{$recherche}%"]);
            })
            ->when($triage, function ($requete, $triage) {
                switch ($triage) {
                    case 'solde_desc':
                        $requete->orderBy('solde', 'desc');
                        break;
                    case 'solde_asc':
                        $requete->orderBy('solde', 'asc');
                        break;
                    case 'nom_asc':
                        $requete->orderBy('nom', 'asc');
                        break;
                    case 'nom_desc':
                        $requete->orderBy('nom', 'desc');
                        break;
                    case 'prenom_asc':
                        $requete->orderBy('prenom', 'asc');
                        break;
                    case 'prenom_desc':
                        $requete->orderBy('prenom', 'desc');
                        break;
                    case 'numeroCompte_asc':
                        $requete->orderBy('numeroCompte', 'asc');
                        break;
                    case 'numeroCompte_desc':
                        $requete->orderBy('numeroCompte', 'desc');
                        break;
                }
            })
            ->get();

        // On renvoie la vue avec les utilisateurs, le terme de recherche et le triage
        return view('gestion-comptes', compact('utilisateurs', 'recherche', 'triage'));
    }
}