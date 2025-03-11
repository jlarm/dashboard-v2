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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://js.sentry-cdn.com/487c58c833df4192b1a5311b2e1a849e.min.js" crossorigin="anonymous"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
<x-notification />
<x-course-completion-modal />
<div x-data="{ open: false }" @keydown.window.escape="open = false">
    @include('layouts.light-navigation')

    <div class="flex flex-col lg:pl-64">

        @include('layouts.top-bar')

        <main class="p-4">
            @if(isset($header))
            <div class="sm:flex sm:items-end sm:justify-between mb-2">
                <div class="min-w-0 flex-1">
                    <h1 class="font-bold text-arm-blue-900 sm:truncate leading-normal">{{ $pageTitle }}</h1>
                </div>
                <div>
                    @if(isset($actions))
                        {{ $actions}}
                    @endif
                </div>
            </div>
            @endif
            <div class="mx-auto">
                <div class="{{ (Route::currentRouteName() === 'dealer.dashboard' || Route::currentRouteName() === 'dealer.stores.home') ? '' : 'p-5 bg-white border border-gray-200 shadow-sm rounded-xl' }}">
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
<script>
    window.addEventListener('refresh-page', event => {
        location.reload();
    });
</script>
</body>
</html>
