<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Classe de gestion/affichage du planning
 */
class PasswordController extends Controller
{
    public function requestReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? response("Un email vous a été envoyé", 200)
            : response("Veuillez donner votre email !", 400);
    }

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
            'confirmed' => 'Veuillez confirmer le mot de passe'
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
            : back()->withErrors(['email' => "Erreur : " . $status]);
    }
}
