<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset("images/favicon.ico") }}" />

<!-- Icons -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset("images/icons/favicon-16x16.png") }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset("images/icons/favicon-32x32.png") }}" />
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset("images/icons/favicon-48x48.png") }}" />
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset("images/icons/favicon-96x96.png") }}" />
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset("images/icons/favicon-192x192.png") }}" />

<!-- Apple icons -->
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset("images/icons/apple-touch-icon-57x57.png") }}" />
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset("images/icons/apple-touch-icon-60x60.png") }}" />
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset("images/icons/apple-touch-icon-72x72.png") }}" />
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset("images/icons/apple-touch-icon-76x76.png") }}" />
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset("images/icons/apple-touch-icon-114x114.png") }}" />
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset("images/icons/apple-touch-icon-120x120.png") }}" />
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset("images/icons/apple-touch-icon-144x144.png") }}" />
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset("images/icons/apple-touch-icon-152x152.png") }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset("images/icons/apple-touch-icon-180x180.png") }}" />

<!-- Chrome / Android icons -->
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset("images/icons/android-chrome-192x192.png") }}" />
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset("images/icons/android-chrome-512x512.png") }}" />

<!-- CSS -->
<link href="{{ asset("css/app.css") }}" rel="stylesheet" />

@php
    use Illuminate\Support\Str;
@endphp

<style>
    @if (Str::contains(request()->path(), 'admin'))
        body {
            font-family: 'opensauce', sans-serif;
        }

        header {
            font-family: 'lobstertwo', sans-serif;
        }
    @else
        body {
            font-family: 'lobstertwo', sans-serif;
        }
    @endif    input {
        font-family: 'opensauce', sans-serif;
    }

    button {
        cursor: pointer;
    }
</style>
