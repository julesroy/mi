<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles / Scripts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-[#0a0a0a] text-white">
        <a href="/connexion">Connexion</a>
        <br>
        <a href="/inscription">Inscription</a>
    </body>
</html>
