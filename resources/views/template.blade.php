<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Le nom de votre page</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include("header")

        Le contenu de votre page ici

        @include("footer")
    </body>
</html>
