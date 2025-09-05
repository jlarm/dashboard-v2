@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/ios-icon.png') }}">

    <title>{{ $fileName }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="w-full h-screen bg-gray-50 grid grid-cols-8 grid-rows-6">
    <div class="col-span-3 col-start-1 p-20">
        <x-application-logo class="h-auto w-full"/>
    </div>
    <div class="col-span-5 row-span-4 col-start-1 row-start-2 bg-arm-blue-500 z-10 py-10 pr-10">
        <div class="w-full h-full flex flex-row items-center border-t border-r border-b border-white ">
            <div class="flex flex-col ml-10">
                <h1 class="text-7xl text-white">OSHA Report <span class="block font-bold">{{ $audit->store->name }}</span></h1>
                @if(isset($remediation))
                    <h1 class="text-7xl text-white">Remediation</h1>
                @endif
                <p class="text-white text-2xl my-10">Complete On: {{ $audit->date->format('n/d/Y') }}</p>
                <p class="text-white text-2xl">Report Created By:</p>
                <p class="text-white text-xl">
                    {{ $audit->user->name }}<br/>
                    {{ $audit->user->phoneNumber }}<br/>
                    {{ $audit->user->email }}
                </p>
            </div>
        </div>
    </div>
    <div
        style="background-image: url('{{ asset('deal-jacket-audit-bg.jpg') }}');" class="col-span-5 row-span-6 bg-arm-orange-500 col-start-4 row-start-1 z-0 bg-cover"></div>
</div>
<div class="w-full h-screen p-10">
    <div class="prose prose-img:my-0 min-w-full divide-y divide-gray-200">
        @foreach($audit->violations as $violation)
            <div class="page-break">
                <div class="flex items-baseline gap-5">
                    <h3 class="w-5/6">{{ $violation->statement }}</h3>
                    <div class="w-1/6 text-right">
                        @if($violation->risk)
                            <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">High Risk</span>
                        @endif
                    </div>
                </div>
                @if($violation->violation_date)
                    <div>
                        <p>Date of occurrence: {{ $violation->violation_date?->format('F d, Y') }}</p>
                    </div>
                @endif
                <p class="italic">{{ $violation->comment }}</p>
                <div class="flex gap-5">
                    @if($violation->getMedia('violation_files_0')->first())
                        <div class="w-1/3 h-56 overflow-hidden">
                            <img class="h-full w-full object-cover" src="{{ $violation->getMedia('violation_files_0')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addHour(), 'thumb') }}" alt="">
                        </div>
                    @endif
                    @if($violation->getMedia('violation_files_1')->first())
                        <div class="w-1/3 h-56 overflow-hidden">
                            <img class="h-full w-full object-cover" src="{{ $violation->getMedia('violation_files_1')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addHour(), 'thumb') }}" alt="">
                        </div>
                    @endif
                    @if($violation->getMedia('violation_files_2')->first())
                        <div class="w-1/3 h-56 overflow-hidden">
                            <img class="h-full w-full object-cover" src="{{ $violation->getMedia('violation_files_2')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addHour(), 'thumb') }}" alt="">
                        </div>
                    @endif
                </div>
                @if(isset($remediation))
                    @if($violation->remediation)
                        <div class="mb-10 bg-gray-100 p-5">
                            <p class="font-bold">Remediation:</p>
                            <p>{{ $violation->remediation?->comment }}</p>
                            @if($violation->remediation->getFirstMedia('remediations'))
                                <div class="size-64 overflow-hidden">
                                    <img class="h-full w-full object-cover" src="{{ $violation->remediation->getFirstMedia('remediations')->getTemporaryUrl(Carbon::now()->addMinutes(5), 'thumb') }}" alt="">
                                </div>
                            @endif
                            <p class="text-sm">{{ $violation->remediation->updated_at?->format('m-d-Y') }} by {{ $violation->remediation->user->name }}</p>
                        </div>
                    @endif
                @endif
                @if($violation->auditComments->count() > 0)
                    <div class="mt-8">
                        <h2>Comments</h2>
                        @foreach($violation->auditComments as $comment)
                            <div class="mb-4 p-4 bg-gray-50 rounded" wire:key="$comment->id">
                                <div class="flex justify-between">
                                    <div>
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                    @if($comment->getFirstMedia('comments'))
                                        <div class="mt-2">
                                            <img class="h-32 w-auto object-cover rounded" src="{{ $comment->getFirstMedia('comments')->getTemporaryUrl(\Carbon\Carbon::now()->addHour(), 'thumb') }}" alt="Comment attachment">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
