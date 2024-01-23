@props(['title'])
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ global_asset('favicon.svg') }}" type="image/x-icon">

    <title>{{ tenant('name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://js.sentry-cdn.com/487c58c833df4192b1a5311b2e1a849e.min.js" crossorigin="anonymous"></script>
</head>
<body class="font-sans antialiased bg-white">
<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <!-- Static sidebar for desktop -->
{{--    @include('layouts.nav-main')--}}
    @include('layouts.light-navigation')

    <div class="flex flex-col lg:pl-64">

        @include('layouts.top-bar')

        <main class="flex-1 bg-white">
            <div class="mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
@livewire('slide-over-pro')
@livewire('modal-pro')
@livewire('notifications')
@livewireScripts
</body>
</html>
