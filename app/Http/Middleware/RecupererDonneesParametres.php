<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

/**
 * RecupererDonneesParametres
 *
 * Ce middleware permet de récupérer les données des paramètres depuis la base de données
 * et de les partager avec toutes les vues.
 */
class RecupererDonneesParametres
{
    /**
     * Permet de récupérer les données des paramètres depuis la base de données.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // on récupère les données des paramètres
        $donneesParametres = DB::table('parametres')->where('idParametre', 1)->first();

        // on partage la donnée récupérée avec toutes les vues
        View::share('donneesParametres', $donneesParametres);

        return $next($request);
    }
}
