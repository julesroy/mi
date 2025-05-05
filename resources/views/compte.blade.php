<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Compte</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-18 md:pt-28">
        @include('header')

        Compte
        <br />
        <a href="/deconnexion">Déconnexion</a>

        @include('footer')
    </body>
</html>
