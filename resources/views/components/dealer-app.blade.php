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
</head>
<body class="font-sans antialiased bg-white">
<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <!-- Static sidebar for desktop -->
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
{{--@hasanyrole('Admin|super-admin|Consultant')--}}
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
{{--@endhasanyrole--}}
@livewire('slide-over-pro')
@livewire('modal-pro')
@livewire('notifications')
@livewireScripts
</body>
</html>
