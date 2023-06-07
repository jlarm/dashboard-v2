@props(['title'])
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GLBA Walkthrough Audit Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="max-w-4xl mx-auto">
    <div class="h-screen flex items-center justify-center">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto
        "/>
            @if($financeAudit->store->logo)
                <img
                    class="py-20 mx-auto"
                    src="{{ asset($financeAudit->store->logo) }}"
                    alt="">
            @endif
            @if(tenant('locations'))
                <h1 class="text-3xl font-bold text-arm-blue-600">GLBA Walkthrough Audit Review
                    for {{ $financeAudit->store->name }}</h1>
            @else
                <h1 class="text-3xl font-bold text-arm-blue-600">GLBA Walkthrough Audit Review
                    for {{ tenant('name') }}</h1>
            @endif
            <p class="text-arm-blue-400">{{ $financeAudit->audit_date->format('F d, Y') }}</p>
        </div>
    </div>
    <ul class="divide-y divide-gray-300">
        @if($financeAudit->finance_q1_answer === 1 && $financeAudit->finance_q1_comment || $financeAudit->finance_q1_answer === 3 && $financeAudit->finance_q1_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the Dealer
                    established a written
                    CMS?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q1_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q1_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has the Dealer
                        established a written
                        CMS?</p>
                    <p>
                        @if($financeAudit->finance_q1_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q1_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q1_danger)
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
                @if($financeAudit->finance_q1_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q1_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q1_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q1_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q2_answer === 1 && $financeAudit->finance_q2_comment || $financeAudit->finance_q2_answer === 3 && $financeAudit->finance_q2_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the written CMS been
                    approved by the
                    Board/Ownership?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q2_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q2_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has the written CMS been
                        approved by the
                        Board/Ownership?</p>
                    <p>
                        @if($financeAudit->finance_q2_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q2_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q2_danger)
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
                @if($financeAudit->finance_q2_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q2_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q2_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q2_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q3_answer === 1 && $financeAudit->finance_q3_comment || $financeAudit->finance_q3_answer === 3 && $financeAudit->finance_q3_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are shredding bins being utilized in
                    dealership?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q3_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q3_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are shredding bins being utilized in
                        dealership?</p>
                    <p>
                        @if($financeAudit->finance_q3_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q3_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q3_danger)
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
                @if($financeAudit->finance_q3_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q3_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q3_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q3_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q4_answer === 1 && $financeAudit->finance_q4_comment || $financeAudit->finance_q4_answer === 3 && $financeAudit->finance_q4_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are shredding bins being emptied properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q4_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q4_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are shredding bins being emptied properly?</p>
                    <p>
                        @if($financeAudit->finance_q4_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q4_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q4_danger)
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
                @if($financeAudit->finance_q4_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q4_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q4_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q4_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q5_answer === 1 && $financeAudit->finance_q5_comment || $financeAudit->finance_q5_answer === 3 && $financeAudit->finance_q5_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q5_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q5_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has complaint procedure
                        been established and
                        adopted by Board?</p>
                    <p>
                        @if($financeAudit->finance_q5_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q5_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q5_danger)
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
                @if($financeAudit->finance_q5_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q5_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q5_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q5_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q6_answer === 1 && $financeAudit->finance_q6_comment || $financeAudit->finance_q6_answer === 3 && $financeAudit->finance_q6_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is accounting department/office locked and secured
                    when employees not
                    present?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q6_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q6_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is accounting department/office locked and secured
                        when employees not
                        present?</p>
                    <p>
                        @if($financeAudit->finance_q6_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q6_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q6_danger)
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
                @if($financeAudit->finance_q6_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q6_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q6_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q6_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q7_answer === 1 && $financeAudit->finance_q7_comment || $financeAudit->finance_q7_answer === 3 && $financeAudit->finance_q7_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have CMS policies been distributed to management and relevant employees?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q7_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q7_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Have CMS policies been distributed to management and relevant employees?</p>
                    <p>
                        @if($financeAudit->finance_q7_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q7_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q7_danger)
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
                @if($financeAudit->finance_q7_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q7_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q7_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q7_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q8_answer === 1 && $financeAudit->finance_q8_comment || $financeAudit->finance_q8_answer === 3 && $financeAudit->finance_q8_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have employees and management acknowledged receipt of the above?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q8_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q8_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Have employees and management acknowledged receipt of the above?</p>
                    <p>
                        @if($financeAudit->finance_q8_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q8_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q8_danger)
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
                @if($financeAudit->finance_q8_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q8_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q8_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q8_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q9_answer === 1 && $financeAudit->finance_q9_comment || $financeAudit->finance_q9_answer === 3 && $financeAudit->finance_q9_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are employees and management completing training on a consistent basis?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q9_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q9_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are employees and management completing training on a consistent basis?</p>
                    <p>
                        @if($financeAudit->finance_q9_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q9_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q9_danger)
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
                @if($financeAudit->finance_q9_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q9_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q9_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q9_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q10_answer === 1 && $financeAudit->finance_q10_comment || $financeAudit->finance_q10_answer === 3 && $financeAudit->finance_q10_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are there policies and procedures in place to handle and respond to consumer
                    complaints?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q10_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q10_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are there policies and procedures in place to handle and respond to consumer
                        complaints?</p>
                    <p>
                        @if($financeAudit->finance_q10_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q10_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q10_danger)
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
                @if($financeAudit->finance_q10_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q10_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q10_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q10_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q11_answer === 1 && $financeAudit->finance_q11_comment || $financeAudit->finance_q11_answer === 3 && $financeAudit->finance_q11_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are NPI/customer records being destroyed/shredded
                    properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q11_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q11_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are NPI/customer records being destroyed/shredded
                        properly?</p>
                    <p>
                        @if($financeAudit->finance_q11_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q11_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q11_danger)
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
                @if($financeAudit->finance_q11_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q11_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q11_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q11_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q12_answer === 1 && $financeAudit->finance_q12_comment || $financeAudit->finance_q12_answer === 3 && $financeAudit->finance_q12_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the OFAC/SDN listings being completed on all
                    contracted deals?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q12_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q12_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the OFAC/SDN listings being completed on all
                        contracted deals?</p>
                    <p>
                        @if($financeAudit->finance_q12_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q12_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q12_danger)
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
                @if($financeAudit->finance_q12_answer === 2)
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
                                    <p>U.S. Department of the Treasury’s Office of Foreign Assets Control (OFAC)
                                        administers and enforces U.S. economic and trade sanctions programs against
                                        targeted foreign governments, individuals, groups, and entities in accordance
                                        with national security and foreign policy goals and objectives</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q12_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q12_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q12_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q13_answer === 1 && $financeAudit->finance_q13_comment || $financeAudit->finance_q13_answer === 3 && $financeAudit->finance_q13_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all new employees signing dealerships security
                    policy statement?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q13_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q13_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all new employees signing dealerships security
                        policy statement?</p>
                    <p>
                        @if($financeAudit->finance_q13_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q13_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q13_danger)
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
                @if($financeAudit->finance_q13_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q13_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q13_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q13_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q14_answer === 1 && $financeAudit->finance_q14_comment || $financeAudit->finance_q14_answer === 3 && $financeAudit->finance_q14_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are computer terminals being logged off to
                    activate screensaver password?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q14_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q14_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are computer terminals being logged off to
                        activate screensaver password?</p>
                    <p>
                        @if($financeAudit->finance_q14_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q14_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q14_danger)
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
                @if($financeAudit->finance_q14_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q14_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q14_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q14_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q15_answer === 1 && $financeAudit->finance_q15_comment || $financeAudit->finance_q15_answer === 3 && $financeAudit->finance_q15_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are repair orders (RO’s) being disposed/shredded
                    properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q15_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q15_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are repair orders (RO’s) being disposed/shredded
                        properly?</p>
                    <p>
                        @if($financeAudit->finance_q15_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q15_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q15_danger)
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
                @if($financeAudit->finance_q15_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q15_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q15_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q15_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q16_answer === 1 && $financeAudit->finance_q16_comment || $financeAudit->finance_q16_answer === 3 && $financeAudit->finance_q16_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the privacy notice clearly stated on
                    dealership's
                    website?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q16_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q16_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the privacy notice clearly stated on
                        dealership's
                        website?</p>
                    <p>
                        @if($financeAudit->finance_q16_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q16_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q16_danger)
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
                @if($financeAudit->finance_q16_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q16_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q16_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q16_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q17_answer === 1 && $financeAudit->finance_q17_comment || $financeAudit->finance_q17_answer === 3 && $financeAudit->finance_q17_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">"NPI Check-Out Log" being utilized in accounting.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q17_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q17_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">"NPI Check-Out Log" being utilized in accounting.</p>
                    <p>
                        @if($financeAudit->finance_q17_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q17_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q17_danger)
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
                @if($financeAudit->finance_q17_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q17_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q17_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q17_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q18_answer === 1 && $financeAudit->finance_q18_comment || $financeAudit->finance_q18_answer === 3 && $financeAudit->finance_q18_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all computer terminals automatically set to log
                    off after 5 minutes of non-activity?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q18_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q18_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all computer terminals automatically set to log
                        off after 5 minutes of non-activity?</p>
                    <p>
                        @if($financeAudit->finance_q18_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q18_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q18_danger)
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
                @if($financeAudit->finance_q18_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q18_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q18_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q18_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q19_answer === 1 && $financeAudit->finance_q19_comment || $financeAudit->finance_q19_answer === 3 && $financeAudit->finance_q19_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are network firewalls being monitored for intrusion.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q19_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q19_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are network firewalls being monitored for intrusion.</p>
                    <p>
                        @if($financeAudit->finance_q19_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q19_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q19_danger)
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
                @if($financeAudit->finance_q19_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q19_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q19_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q19_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q20_answer === 1 && $financeAudit->finance_q20_comment || $financeAudit->finance_q20_answer === 3 && $financeAudit->finance_q20_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Written IT policies regarding the use of flash drives, downloading software and
                    programs by employees, and spam email protocols?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q20_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q20_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Written IT policies regarding the use of flash drives, downloading software and
                        programs by employees, and spam email protocols?</p>
                    <p>
                        @if($financeAudit->finance_q20_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q20_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q20_danger)
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
                @if($financeAudit->finance_q20_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q20_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q20_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q20_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q21_answer === 1 && $financeAudit->finance_q21_comment || $financeAudit->finance_q21_answer === 3 && $financeAudit->finance_q21_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have there been any network intrusions or security breaches since last
                    quarterly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q21_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q21_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Have there been any network intrusions or security breaches since last
                        quarterly?</p>
                    <p>
                        @if($financeAudit->finance_q21_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q21_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q21_danger)
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
                @if($financeAudit->finance_q21_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q21_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q21_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q21_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q22_answer === 1 && $financeAudit->finance_q22_comment || $financeAudit->finance_q22_answer === 3 && $financeAudit->finance_q22_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">IT Technical requirements been implemented for Encryption, MFA and System
                    monitoring, penetration testing, and vulnerability assessments?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q22_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q22_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">IT Technical requirements been implemented for Encryption, MFA and System
                        monitoring, penetration testing, and vulnerability assessments?</p>
                    <p>
                        @if($financeAudit->finance_q22_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q22_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q22_danger)
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
                @if($financeAudit->finance_q22_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q22_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q22_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q22_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q23_answer === 1 && $financeAudit->finance_q23_comment || $financeAudit->finance_q23_answer === 3 && $financeAudit->finance_q23_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Cashiers area unsecured</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q23_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q23_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Cashiers area unsecured</p>
                    <p>
                        @if($financeAudit->finance_q23_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q23_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q23_danger)
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
                @if($financeAudit->finance_q23_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q23_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q23_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q23_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q24_answer === 1 && $financeAudit->finance_q24_comment || $financeAudit->finance_q24_answer === 3 && $financeAudit->finance_q24_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are there any new Third Party Service Provider
                    companies that need to be sent
                    acknowledgements and assessment report?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q24_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q24_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are there any new Third Party Service Provider
                        companies that need to be sent
                        acknowledgements and assessment report?</p>
                    <p>
                        @if($financeAudit->finance_q24_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q24_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q24_danger)
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
                @if($financeAudit->finance_q24_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q24_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q24_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q24_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q25_answer === 1 && $financeAudit->finance_q25_comment || $financeAudit->finance_q25_answer === 3 && $financeAudit->finance_q25_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have Third Party Providers been vetted for required compliance practices,
                    procedures and training?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q25_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q25_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Have Third Party Providers been vetted for required compliance practices,
                        procedures and training?</p>
                    <p>
                        @if($financeAudit->finance_q25_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q25_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q25_danger)
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
                @if($financeAudit->finance_q25_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q25_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q25_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q25_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q26_answer === 1 && $financeAudit->finance_q26_comment || $financeAudit->finance_q26_answer === 3 && $financeAudit->finance_q26_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are sales desk drawers/file cabinets locked and
                    secured?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q26_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q26_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are sales desk drawers/file cabinets locked and
                        secured?</p>
                    <p>
                        @if($financeAudit->finance_q26_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q26_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q26_danger)
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
                @if($financeAudit->finance_q26_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q26_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q26_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q26_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q27_answer === 1 && $financeAudit->finance_q27_comment || $financeAudit->finance_q27_answer === 3 && $financeAudit->finance_q27_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Any NPI/customer documents being left out on sales
                    desks?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q27_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q27_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Any NPI/customer documents being left out on sales
                        desks?</p>
                    <p>
                        @if($financeAudit->finance_q27_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q27_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q27_danger)
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
                @if($financeAudit->finance_q27_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q27_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q27_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q27_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q28_answer === 1 && $financeAudit->finance_q28_comment || $financeAudit->finance_q28_answer === 3 && $financeAudit->finance_q28_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is CAN SPAM process in place?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q28_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q28_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is CAN SPAM process in place?</p>
                    <p>
                        @if($financeAudit->finance_q28_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q28_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q28_danger)
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
                @if($financeAudit->finance_q28_answer === 2)
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
                                    <p>CAN-SPAM Act, a law that sets the rules for commercial email, establishes
                                        requirements for commercial messages, gives recipients the right to have you
                                        stop emailing them, and spells out tough penalties for violations.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q28_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q28_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q28_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q29_answer === 1 && $financeAudit->finance_q29_comment || $financeAudit->finance_q29_answer === 3 && $financeAudit->finance_q29_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the Telemarketing “Do Not Call” rule being
                    complied with?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q29_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q29_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the Telemarketing “Do Not Call” rule being
                        complied with?</p>
                    <p>
                        @if($financeAudit->finance_q29_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q29_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q29_danger)
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
                @if($financeAudit->finance_q29_answer === 2)
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
                                    <p>FTC – National “Do not Call Registry” guidelines</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q29_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q29_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q29_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q30_answer === 1 && $financeAudit->finance_q30_comment || $financeAudit->finance_q30_answer === 3 && $financeAudit->finance_q30_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Any other NPI documents publicly exposed, not
                    secured properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q30_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q30_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Any other NPI documents publicly exposed, not
                        secured properly?</p>
                    <p>
                        @if($financeAudit->finance_q30_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q30_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q30_danger)
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
                @if($financeAudit->finance_q30_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q30_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q30_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q30_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q31_answer === 1 && $financeAudit->finance_q31_comment || $financeAudit->finance_q31_answer === 3 && $financeAudit->finance_q31_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Breach in password sharing?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q31_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q31_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Breach in password sharing?</p>
                    <p>
                        @if($financeAudit->finance_q31_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q31_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q31_danger)
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
                @if($financeAudit->finance_q31_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q31_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q31_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q31_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q32_answer === 1 && $financeAudit->finance_q32_comment || $financeAudit->finance_q32_answer === 3 && $financeAudit->finance_q32_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Customers NPI in unsecured trash cans?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q32_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q32_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Customers NPI in unsecured trash cans?</p>
                    <p>
                        @if($financeAudit->finance_q32_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q32_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q32_danger)
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
                @if($financeAudit->finance_q32_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q32_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q32_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q32_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q33_answer === 1 && $financeAudit->finance_q33_comment || $financeAudit->finance_q33_answer === 3 && $financeAudit->finance_q33_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Deal jackets unsecured?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q33_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q33_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Deal jackets unsecured?</p>
                    <p>
                        @if($financeAudit->finance_q33_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q33_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q33_danger)
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
                @if($financeAudit->finance_q33_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q33_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q33_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q33_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q34_answer === 1 && $financeAudit->finance_q34_comment || $financeAudit->finance_q34_answer === 3 && $financeAudit->finance_q34_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Filing cabinets securing customers NPI locked and secured?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q34_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q34_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Filing cabinets securing customers NPI locked and secured?</p>
                    <p>
                        @if($financeAudit->finance_q34_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q34_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q34_danger)
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
                @if($financeAudit->finance_q34_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q34_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q34_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q34_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q35_answer === 1 && $financeAudit->finance_q35_comment || $financeAudit->finance_q35_answer === 3 && $financeAudit->finance_q35_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Sales Tower area has NPI exposure, unsecured customer documents</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q35_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q35_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Sales Tower area has NPI exposure, unsecured customer documents</p>
                    <p>
                        @if($financeAudit->finance_q35_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q35_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q35_danger)
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
                @if($financeAudit->finance_q35_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q35_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q35_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q35_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q36_answer === 1 && $financeAudit->finance_q36_comment || $financeAudit->finance_q36_answer === 3 && $financeAudit->finance_q36_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was Network Vulnerability \Assessment Report completed, denote possible
                    issues?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q36_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q36_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was Network Vulnerability \Assessment Report completed, denote possible
                        issues?</p>
                    <p>
                        @if($financeAudit->finance_q36_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q36_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q36_danger)
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
                @if($financeAudit->finance_q36_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q36_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q36_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q36_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q37_answer === 1 && $financeAudit->finance_q37_comment || $financeAudit->finance_q37_answer === 3 && $financeAudit->finance_q37_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are finance offices locked and secured when
                    employee not present?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q37_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q37_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are finance offices locked and secured when
                        employee not present?</p>
                    <p>
                        @if($financeAudit->finance_q37_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q37_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q37_danger)
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
                @if($financeAudit->finance_q37_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q37_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q37_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q37_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q38_answer === 1 && $financeAudit->finance_q38_comment || $financeAudit->finance_q38_answer === 3 && $financeAudit->finance_q38_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are credit applications secured?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q38_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q38_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are credit applications secured?</p>
                    <p>
                        @if($financeAudit->finance_q38_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q38_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q38_danger)
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
                @if($financeAudit->finance_q38_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q38_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q38_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q38_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q39_answer === 1 && $financeAudit->finance_q39_comment || $financeAudit->finance_q39_answer === 3 && $financeAudit->finance_q39_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Red Flag software being utilized to check for fraudulent applicants?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q39_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q39_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Red Flag software being utilized to check for fraudulent applicants?</p>
                    <p>
                        @if($financeAudit->finance_q39_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q39_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q39_danger)
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
                @if($financeAudit->finance_q39_answer === 2)
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
                                    <p>Red Flags Rule
                                        Sometimes it’s referred to as one of the Fair Credit Reporting Act’s Identity
                                        Theft Rules and it appears in the Code of Federal Regulations as “Detection,
                                        Prevention, and Mitigation of Identity Theft.” The Red Flags Rule requires many
                                        businesses and organizations to implement a written Identity Theft Prevention
                                        Program designed to detect the warning signs – or red flags – of identity theft
                                        in their day-to-day operations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q39_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q39_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q39_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q40_answer === 1 && $financeAudit->finance_q40_comment || $financeAudit->finance_q40_answer === 3 && $financeAudit->finance_q40_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are managers’ offices locked and secured when not
                    present?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q40_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q40_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are managers’ offices locked and secured when not
                        present?</p>
                    <p>
                        @if($financeAudit->finance_q40_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q40_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q40_danger)
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
                @if($financeAudit->finance_q40_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q40_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q40_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q40_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q41_answer === 1 && $financeAudit->finance_q41_comment || $financeAudit->finance_q41_answer === 3 && $financeAudit->finance_q41_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the sales Showroom doors secured prior to sales
                    staff reporting to work?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q41_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q41_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the sales Showroom doors secured prior to sales
                        staff reporting to work?</p>
                    <p>
                        @if($financeAudit->finance_q41_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q41_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q41_danger)
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
                @if($financeAudit->finance_q41_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q41_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q41_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q41_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q42_answer === 1 && $financeAudit->finance_q42_comment || $financeAudit->finance_q42_answer === 3 && $financeAudit->finance_q42_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are Buyers Guide properly displayed in a fully
                    visible on all used cars?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q42_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q42_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are Buyers Guide properly displayed in a fully
                        visible on all used cars?</p>
                    <p>
                        @if($financeAudit->finance_q42_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q42_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q42_danger)
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
                @if($financeAudit->finance_q42_answer === 2)
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
                                    <p>16 CFR Part 455
                                        Rule Summary
                                        The Used Car Rule, formally known as the Used Motor Vehicle Trade Regulation
                                        Rule, has been in effect since 1985. It requires car dealers to display a window
                                        sticker, known as a Buyer’s Guide, on the used cars they offer for sale.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q42_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q42_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q42_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q43_answer === 1 && $financeAudit->finance_q43_comment || $financeAudit->finance_q43_answer === 3 && $financeAudit->finance_q43_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are Buyers Guides filled out properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q43_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q43_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are Buyers Guides filled out properly?</p>
                    <p>
                        @if($financeAudit->finance_q43_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q43_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q43_danger)
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
                @if($financeAudit->finance_q43_answer === 2)
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
                                    <p>16 CFR Part 455
                                        Rule Summary
                                        The Used Car Rule, formally known as the Used Motor Vehicle Trade Regulation
                                        Rule, has been in effect since 1985. It requires car dealers to display a window
                                        sticker, known as a Buyer’s Guide, on the used cars they offer for sale.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q43_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q43_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q43_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q44_answer === 1 && $financeAudit->finance_q44_comment || $financeAudit->finance_q44_answer === 3 && $financeAudit->finance_q44_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">New car missing Monroney sticker placement.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q44_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q44_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">New car missing Monroney sticker placement.</p>
                    <p>
                        @if($financeAudit->finance_q44_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q44_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q44_danger)
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
                @if($financeAudit->finance_q44_answer === 2)
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
                                    <p>A Monroney Label is a reproduction of the original factory window sticker. U.S.
                                        law requires a window sticker, known as a Monroney label, to be displayed on all
                                        new cars. These stickers contain mandatory information about the car</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q44_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q44_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q44_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q45_answer === 1 && $financeAudit->finance_q45_comment || $financeAudit->finance_q45_answer === 3 && $financeAudit->finance_q45_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the finance terms properly displayed on vehicle
                    inventory?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q45_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q45_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the finance terms properly displayed on vehicle
                        inventory?</p>
                    <p>
                        @if($financeAudit->finance_q45_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q45_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q45_danger)
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
                @if($financeAudit->finance_q45_answer === 2)
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
                                    <p>CFBP - § 1026.24 Advertising
                                        (i)The amount or percentage of any downpayment.
                                        (ii)The number of payments or period of repayment.
                                        (iii)The amount of any payment.
                                        (iv)The amount of any finance charge.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q45_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q45_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q45_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q46_answer === 1 && $financeAudit->finance_q46_comment || $financeAudit->finance_q46_answer === 3 && $financeAudit->finance_q46_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the sales bull pin area (if present) secured
                    properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q46_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q46_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the sales bull pin area (if present) secured
                        properly?</p>
                    <p>
                        @if($financeAudit->finance_q46_answer === 1)
                            Yes
                        @elseif($financeAudit->finance_q46_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($financeAudit->finance_q46_danger)
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
                @if($financeAudit->finance_q46_answer === 2)
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
                                    <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($financeAudit->finance_q46_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $financeAudit->finance_q46_comment }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-10">
                    @foreach($financeAudit->getMedia('finance_q46_images') as $image)
                        <img src="{{ $image->getUrl() }}" alt="">
                    @endforeach
                </div>
            </li>
        @endif

        @if($financeAudit->finance_q47_answer === 1 && $financeAudit->finance_q47_comment || $financeAudit->finance_q47_answer === 3 && $financeAudit->finance_q47_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Please note any additional issue/violation found
                    during your sales &amp; finance walk-thru audit.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q47_comment }}</p>
                </div>
            </li>
        @endif
        @if($financeAudit->finance_q47_comment)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Please note any additional issue/violation found
                        during your sales &amp; finance walk-thru audit.</p>
                </div>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $financeAudit->finance_q47_comment }}</p>
                </div>
            </li>
        @endif
    </ul>
</div>
</body>
</html>
