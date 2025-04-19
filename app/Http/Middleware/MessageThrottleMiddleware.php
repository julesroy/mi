<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class MessageThrottleMiddleware extends ThrottleRequests
{
    /**
     * on donne un message quand la limite est dépassée.
     */
    protected function buildException($request, $key, $maxAttempts, $responseCallback = null)
    {
        // avec un message flash, on indique à l'utilisateur qu'il a atteint la limite de tentatives de connexion
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->withErrors([
                    'email' => 'Trop de tentatives de connexion. Réessaye dans une minute.'
                ])
        );
    }
}