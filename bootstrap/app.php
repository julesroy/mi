<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * ici, c'est pour les pages dont on doit réduire l'accès quand l'utilisateur est connecté ou non (par exemple, quand l'utilisateur est connecté, 
         * on ne lui donne pas accès au formulaire de connexion/inscription)
         */
        $middleware->redirectUsersTo('/compte');
        $middleware->redirectGuestsTo('/connexion');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
