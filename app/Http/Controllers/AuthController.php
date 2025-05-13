<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

/**
 * classe pour l'authentification
 */
class AuthController extends Controller
{
    /**
     * affiche le formulaire de connexion
     */
    public function afficherFormulaireConnexion()
    {
        return view('connexion');
    }

    /**
     * permet de lancer une tentative de connexion
     */
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

        // ajouts de données à la session
        $requete->session()->put('emailUtilisateur', $utilisateur->email);

        // mise en place des cookies
        $dureeVieCookie = 7 * 24 * 60; // durée de vie du cookie d'une semaine
        Cookie::queue('idUtilisateur', Crypt::encryptString($utilisateur->idUtilisateur), $dureeVieCookie, null, null, false, true, false, 'Lax');
        Cookie::queue('emailUtilisateur', Crypt::encryptString($utilisateur->email), $dureeVieCookie, null, null, false, true, false, 'Lax');

        // connexion de l'utilisateur
        Auth::loginUsingId($utilisateur->idUtilisateur);
    
        // redirection vers la page d'accueil
        return redirect('/');
    }

    /**
     * affiche le formulaire d'inscription
     */
    public function afficherFormulaireInscription()
    {
        return view('inscription');
    }

    /**
     * permet d'inscrire un nouvel utilisateur
     */
    public function inscrire(Request $requete)
    {

        $validatedData = $requete->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs,email',
            'mdp' => 'required|string|min:8|confirmed'
        ]);

        $idUtilisateur = DB::table('utilisateurs')->insertGetId([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'mdp' => Hash::make($validatedData['mdp'])
        ]);

        // mise en place des cookies
        $dureeVieCookie = 7 * 24 * 60; // durée de vie du cookie d'une semaine
        Cookie::queue('idUtilisateur', Crypt::encryptString($idUtilisateur), $dureeVieCookie, null, null, false, true, false, 'Lax');
        Cookie::queue('emailUtilisateur', Crypt::encryptString($validatedData['email']), $dureeVieCookie, null, null, false, true, false, 'Lax');

        Auth::loginUsingId($idUtilisateur);

        // ajouts de données à la session
        $requete->session()->put('emailUtilisateur', $validatedData['email']);

        // Regenerate session
        $requete->session()->regenerate();

        return redirect('/compte')->with('success', 'Inscription réussie ! Bienvenue.');
    }

    /**
     * permet de se déconnecter
     */
    public function deconnecter(Request $requete)
    {
        Auth::logout();
        $requete->session()->invalidate();
        $requete->session()->regenerateToken();

        // supprimer les cookies
        Cookie::queue(Cookie::forget('idUtilisateur'));
        Cookie::queue(Cookie::forget('emailUtilisateur'));

        return redirect('/connexion');
    }
}