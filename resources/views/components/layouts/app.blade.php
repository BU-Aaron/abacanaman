<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <title>{{ $title ?? 'Abacanaman' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @filamentStyles
        {{-- @livewireStyles --}}

    </head>
    <body class="bg-gray-100 dark:bg-gray-800">

        @livewire('partials.navbar')

        <main>{{ $slot }}</main>

        @livewire('partials.footer')

        @livewireScripts

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <x-livewire-alert::scripts />

        @stack('scripts')

    </body>
</html>
