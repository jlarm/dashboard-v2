<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finance Audit Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="max-w-4xl mx-auto">
    <div class="h-screen flex items-center justify-center">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto
        "/>
            <img
                class="py-20"
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSS-X3K2gpOP7706vLvwO2yBh9hChiJLPObEZUT0bgTpqr93jNQ7e5u78BNVIVuOCwh8A&usqp=CAU"
                alt="">
            <h1 class="text-3xl font-bold text-arm-blue-600">Finance Audit Review for {{ tenant('name') }}</h1>
            <p class="text-arm-blue-400">{{ $financeAudit->audit_date->format('F d, Y') }}</p>
        </div>
    </div>
    <ul class="divide-y divide-gray-300">
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
            @if($financeAudit->finance_q1_answer === 2 || $financeAudit->finance_q1_answer === 3)
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
            @if($financeAudit->finance_q2_answer === 2 || $financeAudit->finance_q2_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Shredding bins over-
                    flowing and need to be
                    cleaned out.</p>
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
            @if($financeAudit->finance_q3_answer === 2 || $financeAudit->finance_q3_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q4_answer === 2 || $financeAudit->finance_q4_answer === 3)
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
            @if($financeAudit->finance_q5_answer === 2 || $financeAudit->finance_q5_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q6_answer === 2 || $financeAudit->finance_q6_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q7_answer === 2 || $financeAudit->finance_q7_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q8_answer === 2 || $financeAudit->finance_q8_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q9_answer === 2 || $financeAudit->finance_q9_answer === 3)
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
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has complaint procedure
                    been established and
                    adopted by Board?</p>
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
            @if($financeAudit->finance_q10_answer === 2 || $financeAudit->finance_q10_answer === 3)
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
    </ul>
</div>
</body>
</html>
