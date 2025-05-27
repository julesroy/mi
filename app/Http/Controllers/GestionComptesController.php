<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * CarteController
 *
 * Ce contrôleur gère les opérations liées à la carte du restaurant.
 * Il permet d'afficher, ajouter, modifier et supprimer des éléments de la carte.
 */
class GestionComptesController extends Controller
{
    /**
     * Affiche la page de gestion des comptes.
     *
     * @return \Illuminate\View\View
     */
    public function afficherComptes(Request $requete)
    {
        // On récupère les données de la table utilisateurs
        $utilisateurs = Utilisateur::orderBy('idUtilisateur', 'asc')->get();

        // On renvoie la vue avec les utilisateurs
        return view('admin.gestion-comptes', compact('utilisateurs'));
    }

    /**
     * Met à jour un utilisateur de la base de données.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $idUtilisateur = $request->input('id');
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $email = $request->input('email');
        $solde = $request->input('solde');
        $acces = $request->input('acces');
        
        $roue = $request->input('roue'); // juste pour le cirday

        // Mise à jour des données dans la base de données
        Utilisateur::where('idUtilisateur', $idUtilisateur)
            ->update([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'solde' => $solde,
                'acces' => $acces,
                'roue' => $roue // juste pour le cirday
            ]);

        return response()->json(['success' => true]);
    }
}
