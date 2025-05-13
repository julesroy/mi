<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Vérifier si l'utilisateur à les accès serveur (1, 2 et 3)
         */
        Gate::define('verifier-acces-serveur', function () {
            $acces = DB::table('utilisateurs')->where('idUtilisateur', Auth::id())->value('acces');

            return in_array($acces, [1, 2, 3]);
        });

        /**
         * Vérifier si l'utilisateur à les accès administrateur (2 et 3)
         */
        Gate::define('verifier-acces-administrateur', function () {
            $acces = DB::table('utilisateurs')->where('idUtilisateur', Auth::id())->value('acces');

            return in_array($acces, [2, 3]);
        });

        /**
         * Vérifier si l'utilisateur à les accès super-administrateur (3)
         */
        Gate::define('verifier-acces-super-administrateur', function () {
            $acces = DB::table('utilisateurs')->where('idUtilisateur', Auth::id())->value('acces');

            return in_array($acces, [3]);
        });
    }
}
