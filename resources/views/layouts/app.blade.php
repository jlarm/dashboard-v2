<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/ios-icon.png') }}">

    <title>@if(tenant('company'))
            {{ tenant('company') }} |
        @endif{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;900&display=swap"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-white">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
{{--<script type="text/javascript">!function (e, t, n) {--}}
{{--        function a() {--}}
{{--            var e = t.getElementsByTagName("script")[0], n = t.createElement("script");--}}
{{--            n.type = "text/javascript", n.async = !0, n.src = "https://beacon-v2.helpscout.net", e.parentNode.insertBefore(n, e)--}}
{{--        }--}}

{{--        if (e.Beacon = n = function (t, n, a) {--}}
{{--            e.Beacon.readyQueue.push({method: t, options: n, data: a})--}}
{{--        }, n.readyQueue = [], "complete" === t.readyState) return a();--}}
{{--        e.attachEvent ? e.attachEvent("onload", a) : e.addEventListener("load", a, !1)--}}
{{--    }(window, document, window.Beacon || function () {--}}
{{--    });--}}
{{--</script>--}}
{{--<script type="text/javascript">window.Beacon('init', 'd2b94abf-c277-46fc-8bc7-5ce562b91d12')</script>--}}
<x-notification/>
@livewire('slide-over-pro')
@livewire('modal-pro')
@livewireScripts
</body>
</html>
