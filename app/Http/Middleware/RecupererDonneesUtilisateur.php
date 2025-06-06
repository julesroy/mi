<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Utilisateur;

/**
 * RecupererDonneesUtilisateur
 *
 * Ce middleware permet de récupérer les données de l'utilisateur depuis la base de données
 * et de les partager avec toutes les vues.
 */
class RecupererDonneesUtilisateur
{
    /**
     * Permet de récupérer les données de l'utilisateur depuis la base de données.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // on définit la variable qui contiendra les données de l'utilisateur
        $donneesUtilisateur = null;

        // si l'utilisateur est connecté, on récupère ses données
        if (Auth::check()) {
            // on récupère les données de l'utilisateur
            $donneesUtilisateur = Auth::user();
        }

        // on partage la donnée récupérée avec toutes les vues
        View::share('donneesUtilisateur', $donneesUtilisateur);

        return $next($request);
    }
}
