<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wishr</title>

        @vite('resources/sass/app.scss')
        @vite('resources/js/app.js')

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.icon') }}" sizes="32x32">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"><!-- 180×180 -->
        <link rel="manifest" href="{{ asset('manifest.webmanifest.json') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" media="screen">
    </head>
    <body id="app" class="bg-slate-950 text-slate-400 subpixel-antialiased overflow-y-scroll flex items-stretch font-medium">
    </body>

    <script>
        window.initialData = @json($initial_data);
        window.user = {};

        @auth
            window.authenticated = true;
            window.user.id = '{{ auth()->user()->id }}';
            window.user.name = '{{ auth()->user()->name }}';
            window.user.email = '{{ auth()->user()->email }}';
        @else
            window.authenticated = false;
        @endauth
    </script>
</html>
