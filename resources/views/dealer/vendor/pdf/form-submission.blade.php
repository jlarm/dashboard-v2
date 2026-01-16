<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Automotive Risk Management Partners</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="h-screen flex justify-center items-center">
        <div class="text-center space-y-5">
            <x-application-logo class="w-auto h-20 text-gray-600" />
            <h1 class="text-4xl font-bold text-arm-blue-500">3rd Party Service Agreement</h1>
            <h2 class="text-2xl font-bold text-arm-blue-500">{{ $vendor->vendor->name }}</h2>
            <h3 class="text-arm-blue-500">{{ $vendor->updated_at->format('F d, Y') }}</h3>
        </div>
    </div>
    <div class="w-full max-w-4xl mx-auto space-y-5 my-20">
        @foreach($vendor->data as $key => $question)
            <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
                <h4 class="{{ ($question['response'] === 'no' || $question['response'] === 'na') ? 'text-red-500' : '' }} font-bold text-xl">{{ $question['question'] }}</h4>
                <p class="capitalize">{{ $question['response'] }}</p>
                @if(!empty($question['comment']))
                <p class="text-sm">{{ $question['comment'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
    <div>
        <h3>{{ $vendor->name }} - {{ $vendor->vendor->name }}</h3>
        <img src="{{ storage_path() }}/app/signatures/{{ $vendor->signature }}" alt="Signature"/>
    </div>
</body>
</html>
