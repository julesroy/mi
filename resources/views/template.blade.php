<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Le nom de votre page</title>
    </head>

    <body>
        @include('header')

        Le contenu de votre page ici

        @include('footer')
    </body>
</html>
