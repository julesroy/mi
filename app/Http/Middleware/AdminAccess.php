<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AdminAccess
{
    /**
     * Récupère les privilèges (niveau d'accès admin) de l'utilisateur connecté
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Accès de base : 0 (pas partie de l'asso)
        $acces = 0;

        if (Auth::check())
            $acces = DB::table('utilisateurs')
                ->where('idUtilisateur', Auth::id())
                ->first()->acces;

        // Partage avec les vues
        View::share('acces', $acces);

        // Partage avec les middleware & controllers
        $request->merge(['acces' => $acces]);

        return $next($request);
    }
}
