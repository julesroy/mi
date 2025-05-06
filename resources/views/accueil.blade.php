<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Accueil</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <a href="/connexion">Connexion</a>
        <br />
        <a href="/inscription">Inscription</a>

        @include('footer')
    </body>
</html>
