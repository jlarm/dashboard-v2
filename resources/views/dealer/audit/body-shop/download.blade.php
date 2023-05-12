@props(['title'])
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Body Shop Audit Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="max-w-4xl mx-auto">
    <div class="h-screen flex items-center justify-center">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto
        "/>
            @if($bodyShopAudit->store->logo)
                <img
                    class="py-20 mx-auto"
                    src="{{ asset($bodyShopAudit->store->logo) }}"
                    alt="">
            @endif
            @if(tenant('locations'))
                <h1 class="text-3xl font-bold text-arm-blue-600">Body Shop Audit Review
                    for {{ $bodyShopAudit->store->name }}</h1>
            @else
                <h1 class="text-3xl font-bold text-arm-blue-600">Body Shop Audit Review
                    for {{ tenant('name') }}</h1>
            @endif
            <p class="text-arm-blue-400">{{ $bodyShopAudit->audit_date->format('F d, Y') }}</p>
        </div>
    </div>
    <ul class="divide-y divide-gray-300">
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is a Filtration Log being completed?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q1_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q1_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q1_danger)
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
            @if($bodyShopAudit->body_shop_q1_answer === 2 || $bodyShopAudit->body_shop_q1_answer === 3)
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
            @if($bodyShopAudit->body_shop_q1_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q1_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q1_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Do all employees know how to access SDS’s?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q2_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q2_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q2_danger)
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
            @if($bodyShopAudit->body_shop_q2_answer === 2 || $bodyShopAudit->body_shop_q2_answer === 3)
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
            @if($bodyShopAudit->body_shop_q2_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q2_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q2_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has annual fit test for all employees been performed?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q3_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q3_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q3_danger)
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
            @if($bodyShopAudit->body_shop_q3_answer === 2 || $bodyShopAudit->body_shop_q3_answer === 3)
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
            @if($bodyShopAudit->body_shop_q3_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q3_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q3_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Medical Questionnaire issued to employees utilizing respirators?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q4_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q4_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q4_danger)
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
            @if($bodyShopAudit->body_shop_q4_answer === 2 || $bodyShopAudit->body_shop_q4_answer === 3)
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
            @if($bodyShopAudit->body_shop_q4_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q4_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q4_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are respirators stored properly?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q5_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q5_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q5_danger)
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
            @if($bodyShopAudit->body_shop_q5_answer === 2 || $bodyShopAudit->body_shop_q5_answer === 3)
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
            @if($bodyShopAudit->body_shop_q5_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q5_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q5_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Do respirators have NIOSH certification?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q6_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q6_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q6_danger)
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
            @if($bodyShopAudit->body_shop_q6_answer === 2 || $bodyShopAudit->body_shop_q6_answer === 3)
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
            @if($bodyShopAudit->body_shop_q6_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q6_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q6_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is PPE equipment available and is it in good condition?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q7_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q7_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q7_danger)
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
            @if($bodyShopAudit->body_shop_q7_answer === 2 || $bodyShopAudit->body_shop_q7_answer === 3)
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
            @if($bodyShopAudit->body_shop_q7_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q7_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q7_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are paint booths free from any flammable material?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q8_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q8_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q8_danger)
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
            @if($bodyShopAudit->body_shop_q8_answer === 2 || $bodyShopAudit->body_shop_q8_answer === 3)
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
            @if($bodyShopAudit->body_shop_q8_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q8_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q8_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all the flammable materials stored properly?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q9_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q9_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q9_danger)
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
            @if($bodyShopAudit->body_shop_q9_answer === 2 || $bodyShopAudit->body_shop_q9_answer === 3)
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
            @if($bodyShopAudit->body_shop_q9_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q9_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q9_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all products that are in containers other than the original properly labeled
                    with product NAME, MFG, and appropriate hazard warning?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q10_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q10_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q10_danger)
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
            @if($bodyShopAudit->body_shop_q10_answer === 2 || $bodyShopAudit->body_shop_q10_answer === 3)
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
            @if($bodyShopAudit->body_shop_q10_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q10_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q10_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Has the eye wash equipment been tested, cleaned and documented weekly?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q11_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q11_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q11_danger)
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
            @if($bodyShopAudit->body_shop_q11_answer === 2 || $bodyShopAudit->body_shop_q11_answer === 3)
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
            @if($bodyShopAudit->body_shop_q11_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q11_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q11_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is the eye wash equipment readily accessible?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q12_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q12_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q12_danger)
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
            @if($bodyShopAudit->body_shop_q12_answer === 2 || $bodyShopAudit->body_shop_q12_answer === 3)
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
            @if($bodyShopAudit->body_shop_q12_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q12_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q12_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">How often is the water/solution changed in the eye wash equipment?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q13_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q13_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q13_danger)
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
            @if($bodyShopAudit->body_shop_q13_answer === 2 || $bodyShopAudit->body_shop_q13_answer === 3)
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
            @if($bodyShopAudit->body_shop_q13_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q13_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q13_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Do you have documentation on water/solution change out?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q14_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q14_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q14_danger)
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
            @if($bodyShopAudit->body_shop_q14_answer === 2 || $bodyShopAudit->body_shop_q14_answer === 3)
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
            @if($bodyShopAudit->body_shop_q14_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q14_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q14_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are you following the mfg. specs?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q15_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q15_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q15_danger)
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
            @if($bodyShopAudit->body_shop_q15_answer === 2 || $bodyShopAudit->body_shop_q15_answer === 3)
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
            @if($bodyShopAudit->body_shop_q15_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q15_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q15_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Have the fire extinguishers had their annual inspection and are they properly
                    identified and fully charged?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q16_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q16_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q16_danger)
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
            <div>
                <p class="font-bold">Last Annual Inspection Date</p>
                @if($bodyShopAudit->body_shop_q16_inspection_date)
                    <p>
                        {{ $bodyShopAudit->body_shop_q16_inspection_date->format('F d, Y') }}
                    </p>
                @endif
            </div>
            @if($bodyShopAudit->body_shop_q16_answer === 2 || $bodyShopAudit->body_shop_q16_answer === 3)
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
            @if($bodyShopAudit->body_shop_q16_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q16_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q16_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are the fire extinguishers easily accessible?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q17_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q17_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q17_danger)
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
            @if($bodyShopAudit->body_shop_q17_answer === 2 || $bodyShopAudit->body_shop_q17_answer === 3)
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
            @if($bodyShopAudit->body_shop_q17_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q17_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q17_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all hoses and cutting tips for the welder/cutting torches in good condition
                    without any cracks or breaks?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q18_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q18_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q18_danger)
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
            @if($bodyShopAudit->body_shop_q18_answer === 2 || $bodyShopAudit->body_shop_q18_answer === 3)
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
            @if($bodyShopAudit->body_shop_q18_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q18_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q18_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all exits properly marked?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q19_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q19_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q19_danger)
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
            @if($bodyShopAudit->body_shop_q19_answer === 2 || $bodyShopAudit->body_shop_q19_answer === 3)
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
            @if($bodyShopAudit->body_shop_q19_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q19_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q19_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are pathways to exits clear of obstructions?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q20_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q20_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q20_danger)
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
            @if($bodyShopAudit->body_shop_q20_answer === 2 || $bodyShopAudit->body_shop_q20_answer === 3)
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
            @if($bodyShopAudit->body_shop_q20_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q20_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q20_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all aisles/pathways, stairways and landings free from obstructions and are the
                    shop areas kept clean and orderly?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q21_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q21_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q21_danger)
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
            @if($bodyShopAudit->body_shop_q21_answer === 2 || $bodyShopAudit->body_shop_q21_answer === 3)
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
            @if($bodyShopAudit->body_shop_q21_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q21_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q21_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are any doorways that are nonfunctioning or blocked marked by a sign stating “NOT
                    AN EXIT”? Are any doorways that are nonfunctioning or blocked marked by a sign stating “NOT AN
                    EXIT”?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q22_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q22_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q22_danger)
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
            @if($bodyShopAudit->body_shop_q22_answer === 2 || $bodyShopAudit->body_shop_q22_answer === 3)
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
            @if($bodyShopAudit->body_shop_q22_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q22_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q22_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are floors in good repair and free from obstruction and debris and slippery
                    conditions?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q23_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q23_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q23_danger)
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
            @if($bodyShopAudit->body_shop_q23_answer === 2 || $bodyShopAudit->body_shop_q23_answer === 3)
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
            @if($bodyShopAudit->body_shop_q23_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_sho_q23_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q23_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are floor openings in excess of 2.25” wide covered with hinged flaps?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q24_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q24_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q24_danger)
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
            @if($bodyShopAudit->body_shop_q24_answer === 2 || $bodyShopAudit->body_shop_q24_answer === 3)
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
            @if($bodyShopAudit->body_shop_q24_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q24_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q24_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                    working condition?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q25_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q25_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q25_danger)
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
            @if($bodyShopAudit->body_shop_q25_answer === 2 || $bodyShopAudit->body_shop_q25_answer === 3)
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
            @if($bodyShopAudit->body_shop_q25_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q25_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q25_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all portable gas containers UL of FM approved? Yes, dealership only uses UL
                    approved containers. Did not find any of these containers in the body shop during this audit.</p>
                <p>
                    @if($bodyShopAudit->body_shop_q26_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q26_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q26_danger)
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
            @if($bodyShopAudit->body_shop_q26_answer === 2 || $bodyShopAudit->body_sho_q26_answer === 3)
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
            @if($bodyShopAudit->body_shop_q26_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q26_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q26_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">All gas cylinders stored properly i.e. tied down etc.?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q27_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q27_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q27_danger)
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
            @if($bodyShopAudit->body_shop_q27_answer === 2 || $bodyShopAudit->body_shop_q27_answer === 3)
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
            @if($bodyShopAudit->body_shop_q27_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q27_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q27_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are gas cylinders stored away from sources of heat or electricity and at least 20’
                    away from combustible materials?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q28_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q28_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q28_danger)
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
            @if($bodyShopAudit->body_shop_q28_answer === 2 || $bodyShopAudit->body_shop_q28_answer === 3)
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
            @if($bodyShopAudit->body_shop_q28_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q28_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q28_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">When dispensing are all tanks holding flammable material properly grounded?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q29_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_sho_q29_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q29_danger)
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
            @if($bodyShopAudit->body_shop_q29_answer === 2 || $bodyShopAudit->body_shop_q29_answer === 3)
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
            @if($bodyShopAudit->body_shop_q29_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q29_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q29_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is there proper signage about not smoking in the appropriate areas?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q30_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q30_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q30_danger)
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
            @if($bodyShopAudit->body_shop_q30_answer === 2 || $bodyShopAudit->body_shop_q30_answer === 3)
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
            @if($bodyShopAudit->body_shop_q30_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q30_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q30_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are no smoking signs being enforced?</p>
                <p>
                    @if($bodyShopAudit->body_sho_q31_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_sho_q31_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q31_danger)
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
            @if($bodyShopAudit->body_shop_q31_answer === 2 || $bodyShopAudit->body_shop_q31_answer === 3)
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
            @if($bodyShopAudit->body_shop_q31_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q31_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q31_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are goggles or face shields always worn when grinding?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q32_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_sho_q32_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q32_danger)
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
            @if($bodyShopAudit->body_shop_q32_answer === 2 || $bodyShopAudit->body_shop_q32_answer === 3)
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
            @if($bodyShopAudit->body_shop_q32_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q32_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q32_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is there proper spacing on grinders; Tool rest 1/8” from grinding wheel Tongue
                    plate 1/4” from grinding wheel</p>
                <p>
                    @if($bodyShopAudit->body_shop_q33_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q33_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q33_danger)
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
            @if($bodyShopAudit->body_shop_q33_answer === 2 || $bodyShopAudit->body_shop_q33_answer === 3)
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
            @if($bodyShopAudit->body_shop_q33_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q33_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q33_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are Signs posted warning of automatic starting feature of the compressors?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q34_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q34_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q34_danger)
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
            @if($bodyShopAudit->body_shop_q34_answer === 2 || $bodyShopAudit->body_shop_q34_answer === 3)
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
            @if($bodyShopAudit->body_shop_q34_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q34_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q34_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is there clear access of at least 36” to all electrical panels?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q35_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q35_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q35_danger)
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
            @if($bodyShopAudit->body_shop_q35_answer === 2 || $bodyShopAudit->body_shop_q35_answer === 3)
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
            @if($bodyShopAudit->body_shop_q35_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q35_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q35_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are all the breakers properly labeled?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q36_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q36_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q36_danger)
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
            @if($bodyShopAudit->body_shop_q36_answer === 2 || $bodyShopAudit->body_shop_q36_answer === 3)
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
            @if($bodyShopAudit->body_shop_q36_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q36_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q36_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Are there any extension cords being used improperly?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q37_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q37_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q37_danger)
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
            @if($bodyShopAudit->body_shop_q37_answer === 2 || $bodyShopAudit->body_shop_q37_answer === 3)
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
            @if($bodyShopAudit->body_shop_q37_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q37_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q37_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold"> Are any electrical cords frayed, cracked, taped, or spliced?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q38_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q38_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q38_danger)
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
            @if($bodyShopAudit->body_shop_q38_answer === 2 || $bodyShopAudit->body_shop_q38_answer === 3)
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
            @if($bodyShopAudit->body_shop_q38_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q38_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_sho_q38_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Check the plug end to be sure the ground is still intact.</p>
                <p>
                    @if($bodyShopAudit->body_shop_q39_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q39_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q39_danger)
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
            @if($bodyShopAudit->body_shop_q39_answer === 2 || $bodyShopAudit->body_shop_q39_answer === 3)
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
            @if($bodyShopAudit->body_shop_q39_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q39_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q39_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Any electrical issues:</p>
                <p>
                    @if($bodyShopAudit->body_shop_q40_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q40_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q40_danger)
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
            @if($bodyShopAudit->body_shop_q40_answer === 2 || $bodyShopAudit->body_shop_q40_answer === 3)
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
            @if($bodyShopAudit->body_shop_q40_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q40_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q40_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Miscellaneous issues?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q41_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q41_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q41_danger)
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
            @if($bodyShopAudit->body_shop_q41_answer === 2 || $bodyShopAudit->body_shop_q41_answer === 3)
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
            @if($bodyShopAudit->body_shop_q41_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q41_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q41_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Hybrid Vehicle Safety: Are batteries removed before work is started? Safety Gloves
                    –“Class O heavy-duty gloves” rated to withstand 1,000 volts.</p>
                <p>
                    @if($bodyShopAudit->body_shop_q42_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q42_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q42_danger)
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
            @if($bodyShopAudit->body_shop_q42_answer === 2 || $bodyShopAudit->body_shop_q42_answer === 3)
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
            @if($bodyShopAudit->body_shop_q42_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q42_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q42_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Safety glasses not being worn when working on hybrid vehicle?</p>
                <p>
                    @if($bodyShopAudit->body_shop_q43_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q43_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q43_danger)
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
            @if($bodyShopAudit->body_shop_q43_answer === 2 || $bodyShopAudit->body_shop_q43_answer === 3)
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
            @if($bodyShopAudit->body_shop_q43_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q43_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q43_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Is the First Aid Kit identified and is it stocked with appropriate supplies? i.e.
                    absorbent compress, adhesive bandages, adhesive tape, antiseptic, burn treatment, medical exam
                    gloves, sterile pads, triangular bandages.</p>
                <p>
                    @if($bodyShopAudit->body_shop_q44_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q44_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q44_danger)
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
            @if($bodyShopAudit->body_shop_q44_answer === 2 || $bodyShopAudit->body_shop_q44_answer === 3)
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
            @if($bodyShopAudit->body_shop_q44_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q44_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q44_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Electrical panels: (clear access of at least 36")</p>
                <p>
                    @if($bodyShopAudit->body_shop_q45_answer === 1)
                        Yes
                    @elseif($bodyShopAudit->body_shop_q45_answer === 2)
                        No
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @if($bodyShopAudit->body_shop_q45_danger)
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
            @if($bodyShopAudit->body_shop_q45_answer === 2 || $bodyShopAudit->body_shop_q45_answer === 3)
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
            @if($bodyShopAudit->body_shop_q45_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q45_comment }}</p>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-10">
                @foreach($bodyShopAudit->getMedia('body_shop_q45_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
    </ul>
</div>
</body>
</html>
