<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GestionComptesController extends Controller
{
    public function afficherComptes(Request $requete)
    {
        // On récupère les données de la table utilisateurs
        $utilisateurs = DB::table('utilisateurs')->orderBy('numeroCompte', 'asc')->get();

        // On renvoie la vue avec les utilisateurs
        return view('admin.gestion-comptes', compact('utilisateurs'));
    }

    public function update(Request $request)
    {
        $numeroCompte = $request->input('id');
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $email = $request->input('email');
        $solde = $request->input('solde');
        $acces = $request->input('acces');

        // Mise à jour des données dans la base de données
        DB::table('utilisateurs')
            ->where('numeroCompte', $numeroCompte)
            ->update([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'solde' => $solde,
                'acces' => $acces,
            ]);

        return response()->json(['success' => true]);
    }
}
