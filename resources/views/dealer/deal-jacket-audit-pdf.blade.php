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

{{--Cover Page--}}
<div class="w-full h-screen bg-white grid grid-cols-8 grid-rows-6">
    <div class="col-span-3 col-start-1 p-20">
        <x-application-logo class="h-auto w-full"/>
    </div>
    <div class="col-span-5 row-span-4 col-start-1 row-start-2 bg-arm-blue-500 z-10 py-10 pr-10">
        <div class="w-full h-full flex flex-row items-center border-t border-r border-b border-white ">
            <div class="flex flex-col ml-10">
                <h1 class="text-7xl text-white">Deal Jacket Report<span
                        class="block font-bold">{{ $audit->store->name }}</span></h1>
                <p class="text-white text-2xl my-10">Complete On: {{ $audit->audit_date->format('n/d/Y') }}</p>
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
        style="background-image: url('{{ url('deal-jacket-audit-bg.jpg') }}');"
        class="col-span-5 row-span-6 bg-arm-orange-500 col-start-4 row-start-1 z-0 bg-cover"></div>
</div>

{{--Manager Issue Count--}}
<div class="w-full h-screen">
    <div class="p-10 h-screen">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
            @foreach($auditCount as $key => $value)
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 text-center">
                    <dt class="truncate text-2xl font-medium text-gray-500">{{ $key }}</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $value }}</dd>
                    <p class="text-gray-500">
                        @if($value > 1)
                            Issues
                        @else
                            Issue
                        @endif
                        Found
                    </p>
                </div>
            @endforeach
        </dl>
    </div>
</div>

{{--Issues by Question--}}
<div class="w-full h-screen">
    <div class="p-10">
        <h1 class="text-5xl text-center font-bold my-10 bg-arm-blue-500">
            <span class="bg-white px-5">Deal Jacket Audit Summary</span>
        </h1>
        <table class="table-fixed mx-auto divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Issue
                </th>
                @foreach($managers as $manager => $count)
                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        <span class="inline-block transform rotate-180"
                              style="writing-mode: vertical-rl;">{{ $manager }}</span>
                    </th>
                @endforeach
                <th scope="col" class="flex px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                    <span class="inline-block transform rotate-180"
                          style="writing-mode: vertical-rl;">Total Issues
                    </span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach($managerIssueCount as $question => $count)
                <tr class="divide-x divide-gray-200">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ \App\Enums\DealJacketQuestions::fromKey($question) }}
                    </td>
                    @foreach($count as $a)
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $a }}</td>
                    @endforeach
                </tr>
            @endforeach
            <tr class="divide-x divide-gray-200">
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">Total Issues</td>
                @foreach($totals as $total)
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $total }}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
</div>

{{--Issues by Manager--}}
@foreach($managers as $manager => $results)
    <div class="prose w-full min-w-full p-10">
        <h1 class="bg-arm-blue-500 leading-none"><span class="bg-white pr-5">{{ $manager }}</span>
        </h1>
        @foreach($results as $key => $value)
            <div class="page-break">
                <h3>{{ \App\Enums\DealJacketQuestions::fromKey($key) }}</h3>
                <ul class="divide-y divide-gray-100 list-none pl-0">
                    @foreach($value as $a)
                        <li class="pl-0 my-0 py-2">{{ $a[1] }} - {{ $a[3] }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endforeach

{{--Issues by Deal Jacket--}}
<div class="w-full h-screen p-10">
    <h1 class="text-5xl text-center font-bold my-10 bg-arm-blue-500"><span
            class="bg-white px-5">Details by Deal Jacket</span></h1>
    <ul class="divide-y divide-gray-300">
        @foreach($audits as $key => $audit)
            <li class="prose min-w-full py-10">
                <div>
                    <div class="w-1/3">
                        <table class="mt-0">
                            <tbody>
                            <tr>
                                <td>Customer Name:</td>
                                <td>{{ $audit->id }}: {{ $audit->customer_name }}</td>
                            </tr>
                            <tr>
                                <td>Customer Number:</td>
                                <td>{{ $audit->customer_number }}</td>
                            </tr>
                            <tr>
                                <td>Finance Manager:</td>
                                <td>{{ $audit->manager->name }}</td>
                            </tr>
                            <tr>
                                <td>Deal Type:</td>
                                <td>
                                    @if($audit->individual_q1_answer == 1)
                                        Cash
                                    @elseif($audit->individual_q1_answer == 2)
                                        Finance
                                    @elseif($audit->individual_q1_answer == 3)
                                        Lease
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Vehicle Type:</td>
                                <td>
                                    @if($audit->individual_q2_answer == 1)
                                        New
                                    @elseif($audit->individual_q2_answer == 2)
                                        Used
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Odometer Reading:</td>
                                <td>{{ $audit->mileage }}</td>
                            </tr>
                            <tr>
                                <td>Date of Delivery:</td>
                                <td>{{ $audit->deal_jacket_date->format('F d, Y') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @for($i = 3; $i <= 40; $i++)
                        @if($audit->{'individual_q' . $i . '_answer'} == 2)
                            <h4>{{ \App\Enums\DealJacketQuestions::fromKey('individual_q' . $i . '_answer') }}</h4>
                        @endif
                    @endfor
                    <div class="w-full grid grid-cols-2 gap-24">
                        @foreach($audit->getMedia('individual_audit_images') as $image)
                            <img class="w-full"
                                 src="{{ $image->getUrl() }}" alt="">
                        @endforeach
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>
