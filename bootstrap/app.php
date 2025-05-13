<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\MessageThrottleMiddleware;
use App\Http\Middleware\ConnexionDepuisCookies;
use App\Http\Middleware\RecupererDonneesUtilisateur;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * ici, c'est pour les pages dont on doit réduire l'accès quand l'utilisateur est connecté ou non (par exemple, quand l'utilisateur est connecté, 
         * on ne lui donne pas accès au formulaire de connexion/inscription)
         */
        $middleware->redirectUsersTo('/compte');
        $middleware->redirectGuestsTo('/connexion');

        /**
         * message d'erreur pour throttle
         * Récupération du niveau d'accès pour les pages admin
         */
        $middleware->alias([
            'messagethrottle' => MessageThrottleMiddleware::class,
        ]);

        /**
         * création de la session (connexion de l'utilisateur) depuis les cookies, avec append, on s'assure que le middleware est appelé pour chaque route du site
         */
        $middleware->appendToGroup('web', ConnexionDepuisCookies::class);

        /**
         * récupération des données de l'utilisateur depuis la base de données
         */
        $middleware->appendToGroup('web', RecupererDonneesUtilisateur::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
