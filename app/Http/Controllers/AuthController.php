<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function afficherFormulaireConnexion()
    {
        return view('connexion');
    }

    public function connecter(Request $requete)
    {
        // récupération des données du formulaire
        $email = $requete->input('email');
        $motDePasse = $requete->input('mdp');

        // vérification de l'existence de l'utilisateur
        $utilisateur = DB::table('utilisateurs')->where('email', $email)->first();
    
        if (!$utilisateur) {
            return back()->withErrors(['email' => 'Adresse e-mail non trouvée.']);
        }
    
        // vérification du mot de passe hashé
        if (!Hash::check($motDePasse, $utilisateur->mdp)) {
            return back()->withErrors(['mdp' => 'Mot de passe incorrect.']);
        }
    
        // connexion de l'utilisateur
        Auth::loginUsingId($utilisateur->idUtilisateur);
    
        // redirection vers la page de compte
        return redirect('/compte');
    }

    public function deconnecter(Request $requete)
    {
        Auth::logout();
        $requete->session()->invalidate();
        $requete->session()->regenerateToken();

        return redirect('/connexion');
    }
}