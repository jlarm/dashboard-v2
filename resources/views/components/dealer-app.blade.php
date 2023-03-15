@props(['title'])
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">

    <title>{{ tenant('name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;900&display=swap"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    @include('layouts.mobile-navigation')

    <!-- Static sidebar for desktop -->
    @include('layouts.light-navigation')

    <div class="flex flex-col md:pl-64">

        @include('layouts.top-bar')

        <main class="flex-1 bg-gray-50">
            <div class="py-6">
                <div class="mx-auto px-4 sm:px-6 md:px-8">
                    {{ $slot }}
                </div>
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
