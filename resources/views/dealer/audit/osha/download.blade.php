@props(['title'])
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Osha Audit Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="max-w-4xl mx-auto">
    <div class="h-screen flex items-center justify-center">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto
        "/>
            @if($oshaAudit->store->logo)
                <img
                    class="py-20 mx-auto"
                    src="{{ asset($oshaAudit->store->logo) }}"
                    alt="">
            @endif
            @if(tenant('locations'))
                <h1 class="text-3xl font-bold text-arm-blue-600">Osha Audit Review
                    for {{ $oshaAudit->store->name }}</h1>
            @else
                <h1 class="text-3xl font-bold text-arm-blue-600">Osha Audit Review
                    for {{ tenant('name') }}</h1>
            @endif
            <p class="text-arm-blue-400">{{ $oshaAudit->audit_date->format('F d, Y') }}</p>
        </div>
    </div>
    <ul class="divide-y divide-gray-300">
        {{--        1--}}
        @if($oshaAudit->osha_q1_answer === 1 && $oshaAudit->osha_q1_comment || $oshaAudit->osha_q1_answer === 3 && $oshaAudit->osha_q1_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Oil Manifest</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q1_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q1_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Oil Manifest</p>
                    <p>
                        @if($oshaAudit->osha_q1_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q1_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q1_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q1_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>262.40 Recordkeeping.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q1_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q1_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q1_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        2--}}
        @if($oshaAudit->osha_q2_answer === 1 && $oshaAudit->osha_q2_comment || $oshaAudit->osha_q2_answer === 3 && $oshaAudit->osha_q2_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Battery Manifest</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q2_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q2_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Battery Manifest</p>
                    <p>
                        @if($oshaAudit->osha_q2_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q2_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q2_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q2_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Federal Code of Regulations 40 CFR part 273. Subpart G - Spent Lead-Acid
                                        Batteries Being Reclaimed
                                        § 266.80 Applicability and requirements.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q2_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q2_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q2_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        3--}}
        @if($oshaAudit->osha_q3_answer === 1 && $oshaAudit->osha_q3_comment || $oshaAudit->osha_q3_answer === 3 && $oshaAudit->osha_q3_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Tire Manifests</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q3_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q3_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Tire Manifests</p>
                    <p>
                        @if($oshaAudit->osha_q3_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q3_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q3_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q3_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Maintain copies of all tire manifest</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q3_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q3_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q3_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        4--}}
        @if($oshaAudit->osha_q4_answer === 1 && $oshaAudit->osha_q4_comment || $oshaAudit->osha_q4_answer === 3 && $oshaAudit->osha_q4_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Forklift Operators certifications</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q4_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q4_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Forklift Operators certifications</p>
                    <p>
                        @if($oshaAudit->osha_q4_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q4_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q4_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q4_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>
                                        <a href="https://www.osha.gov/laws-regs/regulations/standardnumber/1910/1910.178">29
                                            CFR 1910.178(l)(2)(ii) –
                                            Training requirements</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q4_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q4_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q4_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        5--}}
        @if($oshaAudit->osha_q5_answer === 1 && $oshaAudit->osha_q5_comment || $oshaAudit->osha_q5_answer === 3 && $oshaAudit->osha_q5_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the OSHA 300 & 300A being completed on an on-going basis and electronically
                    filed?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q5_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q5_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the OSHA 300 & 300A being completed on an on-going basis and electronically
                        filed?</p>
                    <p>
                        @if($oshaAudit->osha_q5_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q5_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q5_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q5_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>1904.41 Electronic submission of
                                        Employer Identification Number
                                        (EIN) and injury and illness records
                                        to OSHA.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q5_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q5_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q5_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--            6  --}}
        @if($oshaAudit->osha_q6_answer === 1 && $oshaAudit->osha_q6_comment || $oshaAudit->osha_q6_answer === 3 && $oshaAudit->osha_q6_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">SPCC filing</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q6_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q6_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">SPCC filing</p>
                    <p>
                        @if($oshaAudit->osha_q6_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q6_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q6_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q6_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Federal Code of Regulations 40
                                        CFR, 112. Self-certification is
                                        allowed but a full SPCC plan is
                                        required: an owner or operator may
                                        self-certify a spill plan in
                                        accordance with requirements of 40
                                        CFR, 112.7, in lieu of a professional
                                        engineer certified plan.  If there are
                                        10,000 gallons of liquid storage
                                        capacity, your plan must be
                                        prepared and certified by a
                                        registered professional engineer
                                        (PE).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q6_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q6_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q6_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        7--}}
        @if($oshaAudit->osha_q7_answer === 1 && $oshaAudit->osha_q7_comment || $oshaAudit->osha_q7_answer === 3 && $oshaAudit->osha_q7_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are any other local and state EPA filings uploaded to the dealership
                    dashboard?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q7_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q7_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are any other local and state EPA filings uploaded to the dealership
                        dashboard?</p>
                    <p>
                        @if($oshaAudit->osha_q7_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q7_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q7_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q7_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q7_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q7_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q7_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        8--}}
        @if($oshaAudit->osha_q8_answer === 1 && $oshaAudit->osha_q8_comment || $oshaAudit->osha_q8_answer === 3 && $oshaAudit->osha_q8_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do all employees know how to
                    access SDS’s?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q8_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q8_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do all employees know how to
                        access SDS’s?</p>
                    <p>
                        @if($oshaAudit->osha_q8_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q8_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q8_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q8_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>HCS 1910.1200 App E
                                        Each employee who may be
                                        &quot;exposed&quot; to hazardous chemicals
                                        when working must be provided
                                        information and trained prior to initial assignment to work with a
                                        hazardous chemical, and whenever
                                        the hazard changes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q8_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q8_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q8_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        9--}}
        @if($oshaAudit->osha_q9_answer === 1 && $oshaAudit->osha_q9_comment || $oshaAudit->osha_q9_answer === 3 && $oshaAudit->osha_q9_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">All employees have been exposure free from any chemicals in the
                    dealership?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q9_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q9_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">All employees have been exposure free from any chemicals in the
                        dealership?</p>
                    <p>
                        @if($oshaAudit->osha_q9_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q9_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q9_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q9_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>HCS 1910.1200 (c)

                                        Exposure or exposed means that an
                                        employee is subjected in the course
                                        of employment to a chemical that is
                                        a physical or health hazard, and
                                        includes potential (e.g., accidental
                                        or possible) exposure. &quot;Subjected&quot;
                                        in terms of health hazards includes
                                        any route of entry (e.g., inhalation,
                                        ingestion, skin contact or
                                        absorption.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q9_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q9_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q9_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        10--}}
        @if($oshaAudit->osha_q10_answer === 1 && $oshaAudit->osha_q10_comment || $oshaAudit->osha_q10_answer === 3 && $oshaAudit->osha_q10_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all secondary containers filled with chemicals properly labeled?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q10_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q10_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all secondary containers filled with chemicals properly labeled?</p>
                    <p>
                        @if($oshaAudit->osha_q10_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q10_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q10_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q10_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>HCS – 29 CFR 1910.1200(f)(9) –
                                        Transferring Chemicals in
                                        containers - The employer shall
                                        ensure that labels or other forms of
                                        warning are legible, in English, and
                                        prominently displayed on the
                                        container, or readily available in the
                                        work area throughout each work
                                        shift.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q10_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q10_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q10_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        11--}}
        @if($oshaAudit->osha_q11_answer === 1 && $oshaAudit->osha_q11_comment || $oshaAudit->osha_q11_answer === 3 && $oshaAudit->osha_q11_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the dealership accident free since the last audit?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q11_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q11_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the dealership accident free since the last audit?</p>
                    <p>
                        @if($oshaAudit->osha_q11_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q11_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q11_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q11_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Reference current OSHA 300
                                        log for details if needed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q11_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q11_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q11_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        12--}}
        @if($oshaAudit->osha_q12_answer === 1 && $oshaAudit->osha_q12_comment || $oshaAudit->osha_q12_answer === 3 && $oshaAudit->osha_q12_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the eye wash equipment readily
                    accessible?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q12_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q12_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the eye wash equipment readily
                        accessible?</p>
                    <p>
                        @if($oshaAudit->osha_q12_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q12_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q12_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q12_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>ANSI Z358.1-2014 - The ANSI
                                        standard states that all flushing
                                        equipment must be located in areas that are accessible within 10
                                        seconds (roughly 55 feet).
                                        The Safety Showers and or Eyewash
                                        Stations must be located on the
                                        same level as the hazard and the
                                        path of travel shall be free from
                                        obstructions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q12_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q12_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q12_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        13--}}
        @if($oshaAudit->osha_q13_answer === 1 && $oshaAudit->osha_q13_comment || $oshaAudit->osha_q13_answer === 3 && $oshaAudit->osha_q13_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the eye wash equipment been tested and cleaned and documented weekly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q13_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q13_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has the eye wash equipment been tested and cleaned and documented weekly?</p>
                    <p>
                        @if($oshaAudit->osha_q13_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q13_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q13_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q13_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.151(c), ANSI
                                        Z358.1-2009 - ANSI standard states
                                        that plumbed flushing equipment,
                                        “shall be activated weekly for a period
                                        long enough to verify operation and
                                        ensure that flushing fluid is available”.
                                        Furthermore, also requires Portable
                                        and Self-Contained equipment “be
                                        visually checked to determine if
                                        flushing fluid needs to be changed or
                                        supplemented”.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q13_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q13_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q13_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        14--}}
        @if($oshaAudit->osha_q14_answer === 1 && $oshaAudit->osha_q14_comment || $oshaAudit->osha_q14_answer === 3 && $oshaAudit->osha_q14_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the eye wash container water supply been changed out properly based on
                    manufacturer recommendations per solution used?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q14_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q14_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has the eye wash container water supply been changed out properly based on
                        manufacturer recommendations per solution used?</p>
                    <p>
                        @if($oshaAudit->osha_q14_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q14_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q14_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q14_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.151 - Dealership is to
                                        follow manufacturing guidelines for
                                        water exchange, i.e., change every
                                        90 days with new sanitizer packs
                                        also added. Initial/date sign off tag
                                        on side of unit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q14_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q14_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q14_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        15--}}
        @if($oshaAudit->osha_q15_answer === 1 && $oshaAudit->osha_q15_comment || $oshaAudit->osha_q15_answer === 3 && $oshaAudit->osha_q15_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">DOT certification - Is the person
                    responsible for Hazardous material
                    shipping current on his/her?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q15_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q15_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">DOT certification - Is the person
                        responsible for Hazardous material
                        shipping current on his/her?</p>
                    <p>
                        @if($oshaAudit->osha_q15_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q15_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q15_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q15_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>49 CFR § 172.704
                                        Recurrent training. A hazmat employee
                                        shall receive the training required
                                        by this subpart at least once every
                                        three years. (list employees certified or
                                        not certified)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q15_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q15_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q15_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        16--}}
        @if($oshaAudit->osha_q16_answer === 1 && $oshaAudit->osha_q16_comment || $oshaAudit->osha_q16_answer === 3 && $oshaAudit->osha_q16_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all the Fire Extinguishers easily accessible?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q16_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q16_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all the Fire Extinguishers easily accessible?</p>
                    <p>
                        @if($oshaAudit->osha_q16_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q16_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q16_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q16_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.157(d)(2)
                                        The employer shall distribute portable fire extinguishers for use by employees
                                        on
                                        Class A fires so that the travel distance for employees to any extinguisher is
                                        75
                                        ft.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q16_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q16_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q16_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        17--}}
        @if($oshaAudit->osha_q17_answer === 1 && $oshaAudit->osha_q17_comment || $oshaAudit->osha_q17_answer === 3 && $oshaAudit->osha_q17_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have the fire extinguishers had their annual inspection and are they properly
                    identified and fully charged?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q17_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q17_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Have the fire extinguishers had their annual inspection and are they properly
                        identified and fully charged?</p>
                    <p>
                        @if($oshaAudit->osha_q17_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q17_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q17_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q17_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.157(e)(3)
                                        The employer shall assure that portable fire extinguishers are subjected to an
                                        annual maintenance check. Stored pressure extinguishers do not require an
                                        internal
                                        examination. The employer shall record the annual maintenance date and retain
                                        this
                                        record for one year after the last entry or the life of the shell, whichever is
                                        less.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q17_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q17_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q17_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        18--}}
        @if($oshaAudit->osha_q18_answer === 1 && $oshaAudit->osha_q18_comment || $oshaAudit->osha_q18_answer === 3 && $oshaAudit->osha_q18_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are extinguishers mounted properly? (36”-60”)</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q18_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q18_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are extinguishers mounted properly? (36”-60”)</p>
                    <p>
                        @if($oshaAudit->osha_q18_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q18_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q18_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q18_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.157©(3)
                                        Mounting; Height is between 36” to 60”
                                        Accessibility is 20’” in front and sides
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q18_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q18_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q18_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        19--}}
        @if($oshaAudit->osha_q19_answer === 1 && $oshaAudit->osha_q19_comment || $oshaAudit->osha_q19_answer === 3 && $oshaAudit->osha_q19_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are fire extinguisher signs above the unit posted properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q19_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q19_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are fire extinguisher signs above the unit posted properly?</p>
                    <p>
                        @if($oshaAudit->osha_q19_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q19_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q19_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q19_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.157(d)(2) - The employer shall distribute portable fire extinguishers
                                        for
                                        use by employees on Class A fires so that the travel distance for employees to
                                        any
                                        extinguisher is 75 ft.
                                        29 CFR 1910.157©(1) - Fire extinguishers and shall mount, locate and identify
                                        them
                                        so that they are readily accessible to employees without subjecting the
                                        employees to
                                        possible injury.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q19_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q19_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q19_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        20--}}
        @if($oshaAudit->osha_q20_answer === 1 && $oshaAudit->osha_q20_comment || $oshaAudit->osha_q20_answer === 3 && $oshaAudit->osha_q20_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all hoses and cutting tips for the welder / cutting torches in good
                    condition
                    without any cracks or breaks?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q20_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q20_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all hoses and cutting tips for the welder / cutting torches in good
                        condition
                        without any cracks or breaks? </p>
                    <p>
                        @if($oshaAudit->osha_q20_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q20_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q20_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q20_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.252 / ANSI Z49.1 Safety in Welding, Cutting, and Allied
                                        Processes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q20_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q20_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q20_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        21--}}
        @if($oshaAudit->osha_q21_answer === 1 && $oshaAudit->osha_q21_comment || $oshaAudit->osha_q21_answer === 3 && $oshaAudit->osha_q21_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do you have any forklift(s)?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q21_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q21_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do you have any forklift(s)?</p>
                    <p>
                        @if($oshaAudit->osha_q21_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q21_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q21_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q21_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.178(l)
                                        Training Requirements – certified every 3 years
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q21_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q21_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q21_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        22--}}
        @if($oshaAudit->osha_q22_answer === 1 && $oshaAudit->osha_q22_comment || $oshaAudit->osha_q22_answer === 3 && $oshaAudit->osha_q22_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">If you have a forklift, has the person(s) responsible for operating it been
                    properly trained on safety and signed off as such?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q22_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q22_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If you have a forklift, has the person(s) responsible for operating it been
                        properly trained on safety and signed off as such?</p>
                    <p>
                        @if($oshaAudit->osha_q22_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q22_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q22_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q22_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Training Requirements - 29 CFR 1910.178(l)(3)
                                        29 CFR 1910.178(l)(4)(iii) – Every 3 years
                                        ANSI B56.1-1969 - Safety Standard for Powered Industrial Trucks.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q22_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q22_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q22_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        23--}}
        @if($oshaAudit->osha_q23_answer === 1 && $oshaAudit->osha_q23_comment || $oshaAudit->osha_q23_answer === 3 && $oshaAudit->osha_q23_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do you have forklift training certificates of completed training class(es)?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q23_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q23_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do you have forklift training certificates of completed training class(es)?</p>
                    <p>
                        @if($oshaAudit->osha_q23_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q23_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q23_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q23_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>29 CFR 1910.157(d)(2) - The--}}
                {{--                                    employer shall distribute portable--}}
                {{--                                    fire extinguishers for use by--}}
                {{--                                    employees on Class A fires so that--}}
                {{--                                    the travel distance for employees to--}}
                {{--                                    any extinguisher is 75 ft. 29 CFR 1910.157©(1) - Fire--}}
                {{--                                    extinguishers and shall mount,--}}
                {{--                                    locate and identify them so that--}}
                {{--                                    they are readily accessible to--}}
                {{--                                    employees without subjecting the--}}
                {{--                                    employees to possible injury.</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q23_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q23_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q23_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        24--}}
        @if($oshaAudit->osha_q24_answer === 1 && $oshaAudit->osha_q24_comment || $oshaAudit->osha_q24_answer === 3 && $oshaAudit->osha_q24_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do forklifts have a seat belt/safety harness?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q24_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q24_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do forklifts have a seat belt/safety harness?</p>
                    <p>
                        @if($oshaAudit->osha_q24_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q24_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q24_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q24_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.178(l)(3)(i)(M)
                                        Seat Belt Usage
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q24_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q24_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q24_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        25--}}
        @if($oshaAudit->osha_q25_answer === 1 && $oshaAudit->osha_q25_comment || $oshaAudit->osha_q25_answer === 3 && $oshaAudit->osha_q25_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Does the forklift have legible labels?
                    i.e., ANSI, serial #, maximum lift capacity</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q25_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q25_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Does the forklift have legible labels?
                        i.e., ANSI, serial #, maximum lift capacity
                    </p>
                    <p>
                        @if($oshaAudit->osha_q25_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q25_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q25_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q25_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.178
                                        ANSI B56.1
                                        Requires industrial lift truck users to keep labels and name plates readable,
                                        painters must not paint over these markings
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q25_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q25_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q25_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        26--}}
        @if($oshaAudit->osha_q26_answer === 1 && $oshaAudit->osha_q26_comment || $oshaAudit->osha_q26_answer === 3 && $oshaAudit->osha_q26_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all exits properly marked?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q26_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q26_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all exits properly marked?</p>
                    <p>
                        @if($oshaAudit->osha_q26_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q26_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q26_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q26_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>NFPA 101, Section 7.10.1.2</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q26_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q26_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q26_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        27--}}
        @if($oshaAudit->osha_q27_answer === 1 && $oshaAudit->osha_q27_comment || $oshaAudit->osha_q27_answer === 3 && $oshaAudit->osha_q27_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are pathways to exits clear of obstructions?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q27_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q27_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are pathways to exits clear of obstructions?</p>
                    <p>
                        @if($oshaAudit->osha_q27_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q27_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q27_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q27_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>NFPA 101 Life Safety Code 3.3.136
                                        Means of Egress. A continuous and unobstructed way of travel from any point in a
                                        building or structure to a public way consisting of three separate and distinct
                                        parts:
                                        (1) the exit access, (2) the exit, and (3) the exit discharge.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q27_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q27_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q27_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        28--}}
        @if($oshaAudit->osha_q28_answer === 1 && $oshaAudit->osha_q28_comment || $oshaAudit->osha_q28_answer === 3 && $oshaAudit->osha_q28_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all aisles/pathways, stairways and landings free from obstructions?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q28_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q28_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all aisles/pathways, stairways and landings free from obstructions?</p>
                    <p>
                        @if($oshaAudit->osha_q28_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q28_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q28_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q28_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Means of Egress - A continuous and unobstructed way of travel from any point in a
                                        building or structure to a public way</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q28_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q28_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q28_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        29--}}
        @if($oshaAudit->osha_q29_answer === 1 && $oshaAudit->osha_q29_comment || $oshaAudit->osha_q29_answer === 3 && $oshaAudit->osha_q29_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are any doorways that are nonfunctioning or blocked marked by a sign stating
                    “NO
                    EXIT”?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q29_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q29_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are any doorways that are nonfunctioning or blocked marked by a sign stating
                        “NO
                        EXIT”?</p>
                    <p>
                        @if($oshaAudit->osha_q29_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q29_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q29_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q29_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>NFPA 101, Section 7.10.8.3.1
                                        All doors, passages or stairways that are neither an exit nor a way of exit
                                        access—yet are likely to be mistaken for an exit—be identified with a “No Exit”
                                        sign.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q29_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q29_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q29_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        30--}}
        @if($oshaAudit->osha_q30_answer === 1 && $oshaAudit->osha_q30_comment || $oshaAudit->osha_q30_answer === 3 && $oshaAudit->osha_q30_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the shop areas kept clean and orderly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q30_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q30_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the shop areas kept clean and orderly? </p>
                    <p>
                        @if($oshaAudit->osha_q30_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q30_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q30_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q30_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>General Duty Clause 29 U.S.C. § 654, 5(a)1: Each employer shall furnish to each
                                        of
                                        his employees’ employment and a place of employment which are free from
                                        recognized
                                        hazards that are causing or are likely to cause death or serious physical harm
                                        to
                                        his employees."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q30_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q30_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q30_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        31--}}
        @if($oshaAudit->osha_q31_answer === 1 && $oshaAudit->osha_q31_comment || $oshaAudit->osha_q31_answer === 3 && $oshaAudit->osha_q31_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all flammable materials (oily shop rags) properly stored?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q31_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q31_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all flammable materials (oily shop rags) properly stored? </p>
                    <p>
                        @if($oshaAudit->osha_q31_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q31_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q31_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q31_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1926.252(e) - Storage of Oily Rags.
                                        All solvent waste, oily rags, and flammable liquids shall be kept in
                                        fire-resistant
                                        covered containers
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q31_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q31_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q31_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        32--}}
        @if($oshaAudit->osha_q32_answer === 1 && $oshaAudit->osha_q32_comment || $oshaAudit->osha_q32_answer === 3 && $oshaAudit->osha_q32_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are floors in good repair and free from obstruction and debris and slippery
                    conditions?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q32_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q32_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are floors in good repair and free from obstruction and debris and slippery
                        conditions?</p>
                    <p>
                        @if($oshaAudit->osha_q32_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q32_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q32_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q32_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 U.S.C. § 654, 5(a)1 - Each employer shall furnish to each of his employees’
                                        employment and a place of employment which are free from recognized hazards that
                                        are
                                        causing or are likely to cause death or serious physical harm to his
                                        employees."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q32_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q32_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q32_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        33--}}
        @if($oshaAudit->osha_q33_answer === 1 && $oshaAudit->osha_q33_comment || $oshaAudit->osha_q33_answer === 3 && $oshaAudit->osha_q33_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are floor openings in excess of 2.25” wide covered with hinged flaps?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q33_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q33_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are floor openings in excess of 2.25” wide covered with hinged flaps?</p>
                    <p>
                        @if($oshaAudit->osha_q33_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q33_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q33_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q33_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.23
                                        Every floor hole into which persons can accidentally walk must be guarded by
                                        either:
                                        • A standard railing with standard toe board on all exposed sides, or
                                        • A floor hole cover of standard strength and construction. (While the cover is
                                        not
                                        in place, the floor hole must be constantly attended by someone or must be
                                        protected
                                        by a removable standard railing.)
                                        A cover that leaves no openings more than 1 inch wide must protect every floor
                                        hole
                                        into which persons cannot accidentally walk (because fixed machinery, equipment
                                        or
                                        walls). The cover must be securely held in place to prevent tools or materials
                                        from
                                        falling through.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q33_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q33_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q33_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        34--}}
        @if($oshaAudit->osha_q34_answer === 1 && $oshaAudit->osha_q34_comment || $oshaAudit->osha_q34_answer === 3 && $oshaAudit->osha_q34_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are employees properly maintaining their hoist controls and not bypassing any
                    automatic safety features?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q34_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q34_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are employees properly maintaining their hoist controls and not bypassing any
                        automatic safety features? </p>
                    <p>
                        @if($oshaAudit->osha_q34_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q34_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q34_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q34_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>OSHA General Duty Clause
                                        29 U.S.C. § 654, 5(a)1
                                        ANSI/ALI ALCTV (current edition)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q34_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q34_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q34_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        35--}}
        @if($oshaAudit->osha_q35_answer === 1 && $oshaAudit->osha_q35_comment || $oshaAudit->osha_q35_answer === 3 && $oshaAudit->osha_q35_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are hoists maintained within mfg. specs, and inspected and serviced AND
                    documented under the mfg. suggested frequency? Usually annually.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q35_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q35_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are hoists maintained within mfg. specs, and inspected and serviced AND
                        documented under the mfg. suggested frequency? Usually annually.</p>
                    <p>
                        @if($oshaAudit->osha_q35_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q35_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q35_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q35_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>OSHA General Duty Clause
                                        29 U.S.C. § 654, 5(a)1
                                        ANSI/ALI ALCTV (current edition)
                                        Look for Service inspection sticker
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q35_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q35_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q35_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        36--}}
        @if($oshaAudit->osha_q36_answer === 1 && $oshaAudit->osha_q36_comment || $oshaAudit->osha_q36_answer === 3 && $oshaAudit->osha_q36_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are used batteries stored in acid resistance leak proof containers and or on
                    mat?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q36_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q36_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are used batteries stored in acid resistance leak proof containers and or on
                        mat?</p>
                    <p>
                        @if($oshaAudit->osha_q36_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q36_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q36_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q36_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.304(f) & 1910.305(j)(7)
                                        Store batteries on an acid resistant rack or tub.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q36_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q36_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q36_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        37--}}
        @if($oshaAudit->osha_q37_answer === 1 && $oshaAudit->osha_q37_comment || $oshaAudit->osha_q37_answer === 3 && $oshaAudit->osha_q37_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">If batteries are stored outside, are they in an enclosed or sheltered unit?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q37_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q37_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If batteries are stored outside, are they in an enclosed or sheltered unit?</p>
                    <p>
                        @if($oshaAudit->osha_q37_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q37_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q37_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q37_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Batteries stored outside should be stored on impermeable surfaces and should have
                                        secondary containment. Also, it is recommended that batteries be covered to
                                        prevent
                                        acid run off.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q37_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q37_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q37_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        38--}}
        @if($oshaAudit->osha_q38_answer === 1 && $oshaAudit->osha_q38_comment || $oshaAudit->osha_q38_answer === 3 && $oshaAudit->osha_q38_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do automatic sprinkler heads have a minimum clearance of 18” at all times?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q38_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q38_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do automatic sprinkler heads have a minimum clearance of 18” at all times?</p>
                    <p>
                        @if($oshaAudit->osha_q38_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q38_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q38_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q38_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.159(c)(10)
                                        The minimum vertical clearance between sprinklers and material below shall be 18
                                        inches (45.7 cm).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q38_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q38_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q38_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        39--}}
        @if($oshaAudit->osha_q39_answer === 1 && $oshaAudit->osha_q39_comment || $oshaAudit->osha_q39_answer === 3 && $oshaAudit->osha_q39_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all portable gas containers UL of FM approved?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q39_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q39_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all portable gas containers UL of FM approved?</p>
                    <p>
                        @if($oshaAudit->osha_q39_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q39_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q39_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q39_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1926.152(a)(1)
                                        Only approved containers and portable tanks shall be used for storage and
                                        handling
                                        of flammable and combustible liquids
                                        DOT 29CFR1926.155 (1)
                                        an approved, closed container, of not more than 5 gallons capacity, having a
                                        flash
                                        arresting screen, spring closing lid and spout cover and so designed that it
                                        will
                                        safely relieve internal pressure when subjected to fire exposure.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q39_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q39_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q39_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        40--}}
        @if($oshaAudit->osha_q40_answer === 1 && $oshaAudit->osha_q40_comment || $oshaAudit->osha_q40_answer === 3 && $oshaAudit->osha_q40_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                    working condition?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q40_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q40_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                        working condition?</p>
                    <p>
                        @if($oshaAudit->osha_q40_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q40_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q40_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q40_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.101
                                        29 CFR 1910.6 reference
                                        49 CFR parts 171-179 & 14 CFR part 103
                                        CGAP C-6-1968 & C-8-1962
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q40_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q40_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q40_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        41--}}
        @if($oshaAudit->osha_q41_answer === 1 && $oshaAudit->osha_q41_comment || $oshaAudit->osha_q41_answer === 3 && $oshaAudit->osha_q41_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all gas cylinders stored and tied off properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q41_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q41_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all gas cylinders stored and tied off properly?</p>
                    <p>
                        @if($oshaAudit->osha_q41_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q41_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q41_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q41_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.101
                                        29 CFR 1910.6 reference
                                        49 CFR parts 171-179 & 14 CFR part 103
                                        CGAP C-6-1968 & C-8-1962
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q41_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q41_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q41_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        42--}}
        @if($oshaAudit->osha_q42_answer === 1 && $oshaAudit->osha_q42_comment || $oshaAudit->osha_q42_answer === 3 && $oshaAudit->osha_q42_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are gas cylinders stored away from sources of heat or electricity and at least
                    20’ away from combustible materials?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q42_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q42_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are gas cylinders stored away from sources of heat or electricity and at least
                        20’ away from combustible materials?
                    </p>
                    <p>
                        @if($oshaAudit->osha_q42_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q42_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q42_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q42_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.159(c)(10)
                                        The minimum vertical clearance
                                        between sprinklers and material
                                        below shall be 18 inches (45.7 cm).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q42_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q42_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q42_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        43--}}
        @if($oshaAudit->osha_q43_answer === 1 && $oshaAudit->osha_q43_comment || $oshaAudit->osha_q43_answer === 3 && $oshaAudit->osha_q43_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are goggles or face shields always worn when grinding?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q43_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q43_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are goggles or face shields always worn when grinding?</p>
                    <p>
                        @if($oshaAudit->osha_q43_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q43_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q43_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q43_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910 133 (a) (1)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q43_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q43_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q43_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        44--}}
        @if($oshaAudit->osha_q44_answer === 1 && $oshaAudit->osha_q44_comment || $oshaAudit->osha_q44_answer === 3 && $oshaAudit->osha_q44_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there proper spacing on grinders;
                    Tool rest 1/8” from grinding wheel.
                    Tongue plate 1/4” from grinding wheel.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q44_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q44_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there proper spacing on grinders;
                        Tool rest 1/8” from grinding wheel.
                        Tongue plate 1/4” from grinding wheel.
                    </p>
                    <p>
                        @if($oshaAudit->osha_q44_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q44_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q44_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q44_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.215(a)(4) - Work rests. (Bottom Plate) On offhand grinding machines,
                                        Work
                                        rests shall be kept adjusted closely to the wheel with a maximum opening of
                                        one-eighth inch
                                        29 CFR 1910.215(b)(9) - Exposure adjustment. (Top Cover over Wheel) Safety
                                        guards.
                                        The distance between the wheel periphery and the adjustable tongue or the end of
                                        the
                                        peripheral member at the top shall never exceed one-fourth inch</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q44_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q44_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q44_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        45--}}
        @if($oshaAudit->osha_q45_answer === 1 && $oshaAudit->osha_q45_comment || $oshaAudit->osha_q45_answer === 3 && $oshaAudit->osha_q45_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there proper signage about not smoking in the appropriate areas?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q45_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q45_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there proper signage about not smoking in the appropriate areas?</p>
                    <p>
                        @if($oshaAudit->osha_q45_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q45_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q45_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q45_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.106
                                        "No Smoking" signs shall be conspicuously posted where hazard from flammable
                                        liquid
                                        vapors is normally present.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q45_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q45_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q45_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        46--}}
        @if($oshaAudit->osha_q46_answer === 1 && $oshaAudit->osha_q46_comment || $oshaAudit->osha_q46_answer === 3 && $oshaAudit->osha_q46_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the no smoking areas being enforced?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q46_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q46_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the no smoking areas being enforced?</p>
                    <p>
                        @if($oshaAudit->osha_q46_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q46_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q46_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q46_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>NFPA 99(12), Sec. 11.5.3.2.1
                                        NO SMOKING signs (and/or the international symbol for no smoking), readable from
                                        a
                                        distance of 5 ft, need to be posted wherever supplemental oxygen is in use and
                                        in
                                        aisles and walkways leading to such area(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q46_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q46_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q46_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        47--}}
        @if($oshaAudit->osha_q47_answer === 1 && $oshaAudit->osha_q47_comment || $oshaAudit->osha_q47_answer === 3 && $oshaAudit->osha_q47_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Air compressors marked with Automatic on/off signage?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q47_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q47_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Air compressors marked with Automatic on/off signage?</p>
                    <p>
                        @if($oshaAudit->osha_q47_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q47_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q47_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q47_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.169
                                        1910.145 - These specifications are intended to cover all safety signs </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q47_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q47_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q47_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        48--}}
        @if($oshaAudit->osha_q48_answer === 1 && $oshaAudit->osha_q48_comment || $oshaAudit->osha_q48_answer === 3 && $oshaAudit->osha_q48_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all tanks holding flammable material properly grounded?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q48_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q48_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all tanks holding flammable material properly grounded?</p>
                    <p>
                        @if($oshaAudit->osha_q48_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q48_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q48_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q48_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.106
                                        NFPA 30.4.5.3.4
                                        Static Electricity.
                                        All equipment such as tanks, machinery, and piping shall be designed and
                                        operated to
                                        prevent electrostatic ignitions. All metallic equipment where an ignitable
                                        mixture
                                        could be present shall be bonded or grounded. The bond or ground or both shall
                                        be
                                        physically applied or shall be inherently present by the nature of the
                                        installation.
                                        Any electrically isolated section of metallic piping or equipment shall be
                                        bonded or
                                        grounded to prevent hazardous accumulation of static electricity. All
                                        nonmetallic
                                        equipment and piping where an ignitable mixture could be present shall be given
                                        special consideration.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q48_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q48_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q48_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        49--}}
        @if($oshaAudit->osha_q49_answer === 1 && $oshaAudit->osha_q49_comment || $oshaAudit->osha_q49_answer === 3 && $oshaAudit->osha_q49_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there clear access of at least 36” to all electrical panels?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q49_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q49_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there clear access of at least 36” to all electrical panels?</p>
                    <p>
                        @if($oshaAudit->osha_q49_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q49_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q49_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q49_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>1910.303(g)(1) & 1910.303(g)(1)(i)(B)
                                        29 CFR 1921.303 (g)
                                        NFPA 70 110-26

                                        Regulations requires a minimum of three feet of clearance for all electrical
                                        equipment serving 600 volts or less.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q49_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q49_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q49_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        50--}}
        @if($oshaAudit->osha_q50_answer === 1 && $oshaAudit->osha_q50_comment || $oshaAudit->osha_q50_answer === 3 && $oshaAudit->osha_q50_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all the breakers properly labeled?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q50_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q50_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all the breakers properly labeled?</p>
                    <p>
                        @if($oshaAudit->osha_q50_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q50_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q50_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q50_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.303
                                        Suitability for installation and use in conformity with the provisions of this
                                        subpart;
                                        Note to paragraph (b)(1)(i) of this section: Suitability of equipment for an
                                        identified purpose may be evidenced by listing or labeling for that identified
                                        purpose. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q50_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q50_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q50_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        51--}}
        @if($oshaAudit->osha_q51_answer === 1 && $oshaAudit->osha_q51_comment || $oshaAudit->osha_q51_answer === 3 && $oshaAudit->osha_q51_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all vacant holes properly sealed off on electrical panel box?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q51_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q51_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all vacant holes properly sealed off on electrical panel box?</p>
                    <p>
                        @if($oshaAudit->osha_q51_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q51_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q51_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q51_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.303
                                        Suitability for installation and use in conformity with the provisions of this
                                        subpart;
                                        Note to paragraph (b)(1)(i) of this section: Suitability of equipment for an
                                        identified purpose may be evidenced by listing or labeling for that identified
                                        purpose. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q51_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q51_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q51_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        52--}}
        @if($oshaAudit->osha_q52_answer === 1 && $oshaAudit->osha_q52_comment || $oshaAudit->osha_q52_answer === 3 && $oshaAudit->osha_q52_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are commercial grade extension cords being used properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q52_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q52_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are commercial grade extension cords being used properly?</p>
                    <p>
                        @if($oshaAudit->osha_q52_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q52_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q52_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q52_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.334
                                        Electrical Use of Equipment
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q52_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q52_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q52_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        53--}}
        @if($oshaAudit->osha_q53_answer === 1 && $oshaAudit->osha_q53_comment || $oshaAudit->osha_q53_answer === 3 && $oshaAudit->osha_q53_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all electrical cords in good working order (none frayed, cracked, taped, or
                    spliced or ground missing on 3 prong plugs)?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q53_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q53_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all electrical cords in good working order (none frayed, cracked, taped, or
                        spliced or ground missing on 3 prong plugs)?</p>
                    <p>
                        @if($oshaAudit->osha_q53_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q53_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q53_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q53_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.334
                                        Electrical cords shall be visually inspected before use on any shift for
                                        external
                                        defects (such as loose parts, deformed and missing pins, or damage to outer
                                        jacket
                                        or insulation) and for evidence of possible internal damage (such as pinched or
                                        crushed outer jacket).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q53_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q53_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q53_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        54--}}
        @if($oshaAudit->osha_q54_answer === 1 && $oshaAudit->osha_q54_comment || $oshaAudit->osha_q54_answer === 3 && $oshaAudit->osha_q54_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the fluorescent tubes stored properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q54_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q54_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the fluorescent tubes stored properly? </p>
                    <p>
                        @if($oshaAudit->osha_q54_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q54_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q54_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q54_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>EPA 530-R-09-001
                                        Lamps should be handled and stored in a way that avoids breakage.
                                        Containers should be stable (i.e., they don’t tip over easily), and they should
                                        be
                                        stored in such a way that they won’t tip or fall. Containers should not be
                                        overfilled or under filled when shipped. Care should be used when stacking boxes
                                        that the additional weight doesn’t break the lamps. Do not tape or rubber band
                                        lamps
                                        together.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q54_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q54_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q54_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        55--}}
        @if($oshaAudit->osha_q55_answer === 1 && $oshaAudit->osha_q55_comment || $oshaAudit->osha_q55_answer === 3 && $oshaAudit->osha_q55_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">There are no other miscellaneous electrical issues to note? If “No” explain
                    further</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q55_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q55_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">There are no other miscellaneous electrical issues to note? If “No” explain
                        further</p>
                    <p>
                        @if($oshaAudit->osha_q55_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q55_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q55_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q55_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Electrical Use of Equipment
                                        Safety
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q55_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q55_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q55_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        56--}}
        @if($oshaAudit->osha_q56_answer === 1 && $oshaAudit->osha_q56_comment || $oshaAudit->osha_q56_answer === 3 && $oshaAudit->osha_q56_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Miscellaneous issues?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q56_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q56_comment)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Miscellaneous issues?</p>
                </div>
                <div>
                    <p>{{ $oshaAudit->osha_q56_comment }}</p>
                </div>
            </li>
        @endif
        {{--        57   --}}
        @if($oshaAudit->osha_q57_answer === 1 && $oshaAudit->osha_q57_comment || $oshaAudit->osha_q57_answer === 3 && $oshaAudit->osha_q57_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid - Vehicle Training
                    Certification upload</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q57_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q57_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid - Vehicle Training
                        Certification upload</p>
                    <p>
                        @if($oshaAudit->osha_q57_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q57_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q57_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q57_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q57_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q57_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q57_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        58--}}
        @if($oshaAudit->osha_q58_answer === 1 && $oshaAudit->osha_q58_comment || $oshaAudit->osha_q58_answer === 3 && $oshaAudit->osha_q58_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid safety gloves are Class O Heavy-Duty gloves rated to withstand 1,000
                    volts?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q58_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q58_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid safety gloves are Class O Heavy-Duty gloves rated to withstand 1,000
                        volts?</p>
                    <p>
                        @if($oshaAudit->osha_q58_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q58_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q58_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q58_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Safety
                                        Safety Equipment:
                                        Gloves
                                        Goggles
                                        Key Box
                                        Steering wheel Cover
                                        Sign for Vehicle
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q58_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q58_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q58_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        59--}}
        @if($oshaAudit->osha_q59_answer === 1 && $oshaAudit->osha_q59_comment || $oshaAudit->osha_q59_answer === 3 && $oshaAudit->osha_q59_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid safety gloves are in good working condition?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q59_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q59_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid safety gloves are in good working condition?</p>
                    <p>
                        @if($oshaAudit->osha_q59_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q59_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q59_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--                @if($oshaAudit->osha_q59_answer === 2)--}}
                {{--                    <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                        <div class="flex">--}}
                {{--                            <div class="flex-shrink-0">--}}
                {{--                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                     aria-hidden="true">--}}
                {{--                                    <path fill-rule="evenodd"--}}
                {{--                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                          clip-rule="evenodd"/>--}}
                {{--                                </svg>--}}
                {{--                            </div>--}}
                {{--                            <div class="ml-3">--}}
                {{--                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                                <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                    <p>EPA 530-R-09-001--}}
                {{--                                        Lamps should be handled and--}}
                {{--                                        stored in a way that avoids--}}
                {{--                                        breakage.--}}
                {{--                                        Containers should be stable (i.e.,--}}
                {{--                                        they don’t tip over easily), and they--}}
                {{--                                        should be stored in such a way that--}}
                {{--                                        they won’t tip or fall. Containers--}}
                {{--                                        should not be overfilled or under--}}
                {{--                                        filled when shipped. Care should be--}}
                {{--                                        used when stacking boxes that the--}}
                {{--                                        additional weight doesn’t break the--}}
                {{--                                        lamps. Do not tape or rubber band--}}
                {{--                                        lamps together.</p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                @endif--}}
                @if($oshaAudit->osha_q59_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q59_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q59_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        60--}}
        @if($oshaAudit->osha_q60_answer === 1 && $oshaAudit->osha_q60_comment || $oshaAudit->osha_q60_answer === 3 && $oshaAudit->osha_q60_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid safety glasses worn when working on hybrid vehicles?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q60_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q60_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid safety glasses worn when working on hybrid vehicles?</p>
                    <p>
                        @if($oshaAudit->osha_q60_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q60_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q60_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q60_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Safety</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q60_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q60_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q60_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        61--}}
        @if($oshaAudit->osha_q61_answer === 1 && $oshaAudit->osha_q61_comment || $oshaAudit->osha_q61_answer === 3 && $oshaAudit->osha_q61_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the first aid kit properly stocked given the dealership work
                    environment?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q61_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q61_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the first aid kit properly stocked given the dealership work
                        environment?</p>
                    <p>
                        @if($oshaAudit->osha_q61_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q61_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q61_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q61_answer === 2)
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>29 CFR 1910.151
                                        First aid kits
                                        First aid supplies are required to be readily available under paragraph §
                                        1910.151(b).
                                        An example of the minimal contents of a generic first aid kit is described in
                                        American National Standard (ANSI) Z308.1-1998. Appendix A "Minimum Requirements
                                        for
                                        Workplace First-aid Kits.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($oshaAudit->osha_q61_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q61_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q61_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        62--}}
        @if($oshaAudit->osha_q62_answer === 1 && $oshaAudit->osha_q62_comment || $oshaAudit->osha_q62_answer === 3 && $oshaAudit->osha_q62_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Does dealership have elevators?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q62_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q62_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Does dealership have elevators?</p>
                    <p>
                        @if($oshaAudit->osha_q62_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q62_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q62_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q62_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>Safety--}}
                {{--                                    Safety Equipment:--}}
                {{--                                    Gloves--}}
                {{--                                    Goggles--}}
                {{--                                    Key Box--}}
                {{--                                    Steering wheel Cover--}}
                {{--                                    Sign for Vehicle</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q62_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q62_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q62_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        63--}}
        @if($oshaAudit->osha_q63_answer === 1 && $oshaAudit->osha_q63_comment || $oshaAudit->osha_q63_answer === 3 && $oshaAudit->osha_q63_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has elevator been inspected?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q63_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q63_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has elevator been inspected?</p>
                    <p>
                        @if($oshaAudit->osha_q63_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q63_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q63_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q63_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>Safety--}}
                {{--                                    Safety Equipment:--}}
                {{--                                    Gloves--}}
                {{--                                    Goggles--}}
                {{--                                    Key Box--}}
                {{--                                    Steering wheel Cover--}}
                {{--                                    Sign for Vehicle</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q63_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q63_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q63_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        64--}}
        @if($oshaAudit->osha_q64_answer === 1 && $oshaAudit->osha_q64_comment || $oshaAudit->osha_q64_answer === 3 && $oshaAudit->osha_q64_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">When was the last inspection date?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q64_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q64_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">When was the last inspection date?</p>
                    @if($oshaAudit->osha_q64_date)
                        <p>{{ $oshaAudit->osha_q64_date->format('F d, Y') }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                    {{--                <p>--}}
                    {{--                    @if($oshaAudit->osha_q64_answer === 1)--}}
                    {{--                        Yes--}}
                    {{--                    @elseif($oshaAudit->osha_q64_answer === 2)--}}
                    {{--                        No--}}
                    {{--                    @else--}}
                    {{--                        N/A--}}
                    {{--                    @endif--}}
                    {{--                </p>--}}
                </div>
                @if($oshaAudit->osha_q64_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q64_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>Safety</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q64_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q64_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q64_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
        {{--        65--}}
        @if($oshaAudit->osha_q65_answer === 1 && $oshaAudit->osha_q65_comment || $oshaAudit->osha_q65_answer === 3 && $oshaAudit->osha_q65_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the first aid kit accessible to all employees 24/7?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $oshaAudit->osha_q65_comment }}</p>
                </div>
            </li>
        @endif
        @if($oshaAudit->osha_q65_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the first aid kit accessible to all employees 24/7?</p>
                    <p>
                        @if($oshaAudit->osha_q65_answer === 1)
                            Yes
                        @elseif($oshaAudit->osha_q65_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($oshaAudit->osha_q65_danger)
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Potential high risk violation!</h3>
                            </div>
                        </div>
                    </div>
                @endif
                {{--            @if($oshaAudit->osha_q65_answer === 2)--}}
                {{--                <div class="rounded-md bg-yellow-50 p-4">--}}
                {{--                    <div class="flex">--}}
                {{--                        <div class="flex-shrink-0">--}}
                {{--                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"--}}
                {{--                                 aria-hidden="true">--}}
                {{--                                <path fill-rule="evenodd"--}}
                {{--                                      d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"--}}
                {{--                                      clip-rule="evenodd"/>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="ml-3">--}}
                {{--                            <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>--}}
                {{--                            <div class="mt-2 text-sm text-yellow-700">--}}
                {{--                                <p>Safety--}}
                {{--                                    Safety Equipment:--}}
                {{--                                    Gloves--}}
                {{--                                    Goggles--}}
                {{--                                    Key Box--}}
                {{--                                    Steering wheel Cover--}}
                {{--                                    Sign for Vehicle</p>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}
                @if($oshaAudit->osha_q65_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $oshaAudit->osha_q65_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($oshaAudit->getMedia('osha_q65_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif
    </ul>
</div>
</body>
</html>
