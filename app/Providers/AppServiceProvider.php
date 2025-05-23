<?php

namespace App\Providers;

use App\Models\Utilisateur;
use Illuminate\Auth\Notifications\ResetPassword;
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
            return in_array(Auth::user()->acces, [1, 2, 3]);
        });

        /**
         * Vérifier si l'utilisateur à les accès administrateur (2 et 3)
         */
        Gate::define('verifier-acces-administrateur', function () {
            return in_array(Auth::user()->acces, [2, 3]);
        });

        /**
         * Vérifier si l'utilisateur à les accès super-administrateur (3)
         */
        Gate::define('verifier-acces-super-administrateur', function () {
            return in_array(Auth::user()->acces, [3]);
        });

        /**
         * Définit l'URL de mise à jour du mot de passe
         */

        ResetPassword::createUrlUsing(function (Utilisateur $user, string $token) {
            return 'https://example.com/changement-mdp/' . $token;
        });
    }
}
