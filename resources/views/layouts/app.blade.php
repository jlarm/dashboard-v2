<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/ios-icon.png') }}">

    <title>{{ config('app.name', 'ARMP') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased min-h-screen bg-gray-100">
<x-notification />
<div x-data="{ open: false }" @keydown.window.escape="open = false">
    @include('components.central-sidebar-menu')
    @include('components.navigation.mobile-central-sidebar-menu')
    <div class="lg:pl-72">
        @include('layouts.nav')
        <div class="p-2">
            <div class="bg-white rounded-md p-6 min-h-[calc(100vh-theme(spacing.20))]">
                @if (isset($header))
                    <header class="p-5">
                        {{ $header }}
                    </header>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
@livewire('slide-over-pro')
@livewire('modal-pro')
@livewire('notifications')
@livewireScripts
</body>
</html>
