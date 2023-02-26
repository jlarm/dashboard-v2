<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
<body>
<header class="w-full bg-gray-50">
    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6">
        <h1 class="font-black text-3xl text-arm-blue-500">{{ tenant('name') }}</h1>
    </div>
</header>
<div class="max-w-3xl mx-auto py-20">
    <div class="mb-16">
        <h2 class="font-bold text-2xl text-arm-blue-500">Risk Assessment Form</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at cum deleniti eius esse harum, hic ipsa
            labore maiores nisi nostrum odio odit pariatur provident, qui, quidem sequi similique vero.</p>
    </div>
    <livewire:dealer.vendor.form/>
</div>
@livewireScripts
<script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
</body>
</html>
