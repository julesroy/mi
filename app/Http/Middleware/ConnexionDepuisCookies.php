<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\HttpFoundation\Response;

class ConnexionDepuisCookies
{
    /**
     * Permet de connecter l'utilisateur depuis les cookies créés lors de l'inscription ou de la connexion.
     * Rappel : les cookies ont une durée de validite d'une semaine.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // si l'utilisateur est déjà connecté, on passe à la suite
        if (Auth::check()) {
            return $next($request);
        }

        // on récupère les cookies
        $cookieIdUtilisateur = $request->cookie('idUtilisateur');
        $cookieEmailUtilisateur = $request->cookie('emailUtilisateur');

        // si les cookies existent, on vérifie que l'utilisateur existe bien dans la base de données, puis on crée la session pour le connecter
        if ($cookieIdUtilisateur && $cookieEmailUtilisateur) {
            try {
                // on déchiffre les cookies
                $idUtilisateur = Crypt::decryptString($cookieIdUtilisateur);
                $emailUtilisateur = Crypt::decryptString($cookieEmailUtilisateur);

                // on vérifie que l'utilisateur existe dans la base de données
                $utilisateur = DB::table('utilisateurs')
                                ->where('idUtilisateur', $idUtilisateur)
                                ->where('email', $emailUtilisateur)
                                ->first();

                // si l'utilisateur existe, on le connecte
                if ($utilisateur) {
                    Auth::loginUsingId($utilisateur->idUtilisateur);
                    $request->session()->regenerate(); // par sécurité, on régénère la session
                }

            } catch (DecryptException $e) {
                /** si le déchiffrement échoue (cookie invalide, modifié, clé changée, etc...), on supprime les cookies
                 */
                Cookie::queue(Cookie::forget('idUtilisateur'));
                Cookie::queue(Cookie::forget('emailUtilisateur'));
            }
        }

        return $next($request);
    }
}
