<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\Utilisateur;

/**
 * CompteController
 *
 * Ce contrôleur gère les opérations liées au compte utilisateur.
 */
class CompteController extends Controller
{
    /**
     * Affiche la page du compte utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        // Paiements du compte, avec les commandes associées
        $paiements = Paiement::with('commandes')
            ->where('idUtilisateur', $user->idUtilisateur)
            ->orderByDesc('date')
            ->get();

        // Correspondance articles (idElement => nom) depuis carteElements
        $carteElements = Carte::all();
        $articlesMap = [];
        foreach ($carteElements as $item) {
            $articlesMap[$item->idElement] = $item->nom;
        }

        return view('compte', [
            'user' => $user,
            'paiements' => $paiements,
            'articlesMap' => $articlesMap,
        ]);
    }

    /**
     * Modifie le mot de passe de l'utilisateur s'il est oublié.
     *
     * @return \Illuminate\View\View
     */
    public function lostPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? response()->json(["message" => "Email de changement de mot de passe envoyé à " . $request->input('email')], 200)
            : response()->json(["message" => "Veuillez donner un email valide !"], 400);
    }

    /**
     * Réinitialise le mot de passe de l'utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        // Valide les inputs
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'required' => "Champ requis",
            'min' => 'Le mot de passe doit faire au minimum 8 caractères',
            'confirmed' => 'Veuillez confirmer le mot de passe',
            'email' => 'Veuillez donner une adresse email valide'
        ]);

        // Effectue le reset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Utilisateur $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(10));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // En fonction du statut, renvoie une réponse
        return $status === Password::PasswordReset
            ? redirect()->route('connexion')
            : back()->withErrors($status === Password::INVALID_TOKEN ? ['token' => "La requête a expiré : veuillez faire une nouvelle demande de changement de mot de passe"] : ['email' => "Email non valide"]);
    }
}
