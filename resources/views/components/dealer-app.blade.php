<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'ARMP') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
</head>
<body class="font-sans text-gray-900 antialiased">
    <main class="min-h-screen p-6">
        <a href="{{ route('dealer.dashboard') }}" class="text-sm text-gray-500 hover:underline">&larr; Dashboard</a>
        <div class="mt-4">
            {{ $slot }}
        </div>
    </main>
    @livewireScripts
    @fluxScripts
</body>
</html>
