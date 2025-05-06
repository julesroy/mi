<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Le nom de votre page</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <ul>
            @foreach ($session as $key => $value)
                <li>{{ $key }} : {{ is_array($value) ? json_encode($value) : $value }}</li>
            @endforeach
        </ul>

        <p>ID : {{ $id }}</p>

        @include('footer')
    </body>
</html>
