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
            <x-application-logo class=" h-12 w-auto mx-auto"/>
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
        @if($bodyShopAudit->body_shop_q1_answer === 1 && $bodyShopAudit->body_shop_q1_comment || $bodyShopAudit->body_shop_q1_answer === 3 && $bodyShopAudit->body_shop_q1_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is a Filtration Log being completed?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q1_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q1_answer === 2)
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
                @if($bodyShopAudit->body_shop_q1_answer === 2)
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
                                    <p>Filters shall be checked and changed
                                        as needed based on volume of spray
                                        booth activity. Filter log will be kept up-to-date on filter change outs.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q2_answer === 1 && $bodyShopAudit->body_shop_q2_comment || $bodyShopAudit->body_shop_q2_answer === 3 && $bodyShopAudit->body_shop_q2_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do all employees know how to access SDS’s?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q2_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q2_answer === 2)
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
                @if($bodyShopAudit->body_shop_q2_answer === 2)
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
                                        “exposed” to hazardous chemicals
                                        when working must be provided
                                        information and trained prior to initial
                                        assignment to work with a hazardous
                                        chemical, and whenever the hazard
                                        changes.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q3_answer === 1 && $bodyShopAudit->body_shop_q3_comment || $bodyShopAudit->body_shop_q3_answer === 3 && $bodyShopAudit->body_shop_q3_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has annual fit test for all employees been performed?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q3_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q3_answer === 2)
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
                @if($bodyShopAudit->body_shop_q3_answer === 2)
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
                                    <p>1910.134
                                        Fit testing must be performed initially
                                        (before the employee is required to
                                        wear the respirator in the workplace)
                                        and must be repeated at least
                                        annually. Fit testing must also be
                                        conducted whenever respirator design
                                        or facial changes occur that could
                                        affect the proper fit of the respirator.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q4_answer === 1 && $bodyShopAudit->body_shop_q4_comment || $bodyShopAudit->body_shop_q4_answer === 3 && $bodyShopAudit->body_shop_q4_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Medical Questionnaire issued to employees utilizing respirators?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q4_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q4_answer === 2)
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
                @if($bodyShopAudit->body_shop_q4_answer === 2)
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
                                    <p>29 CFR 1910.134 €(1)
                                        Medical evaluation
                                        (1) General. The employer shall
                                        provide a medical evaluation to
                                        determine the employee’s ability to
                                        use a respirator, before the employee
                                        is fit tested or required to use the
                                        respirator in the workplace. The
                                        employer may discontinue an employee’s medical evaluations when
                                        the employee is no longer required to
                                        use a respirator.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q5_answer === 1 && $bodyShopAudit->body_shop_q5_comment || $bodyShopAudit->body_shop_q5_answer === 3 && $bodyShopAudit->body_shop_q5_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are respirators stored properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q5_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q5_answer === 2)
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
                @if($bodyShopAudit->body_shop_q5_answer === 2)
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
                                    <p>29 CFR 1910.134(h)(2)(i)
                                        All respirators shall be stored to
                                        protect them from damage,
                                        contamination, dust, sunlight,
                                        extreme temperatures, excessive
                                        moisture, and damaging chemicals,
                                        and they shall be packed or stored to
                                        prevent deformation of the facepiece
                                        and exhalation valve.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q6_answer === 1 && $bodyShopAudit->body_shop_q6_comment || $bodyShopAudit->body_shop_q6_answer === 3 && $bodyShopAudit->body_shop_q6_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do respirators have NIOSH certification?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q6_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q6_answer === 2)
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
                @if($bodyShopAudit->body_shop_q6_answer === 2)
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
                                    <p>29 CFR 1910.134(i)
                                        Identification of filters, cartridges, and
                                        canisters. The employer shall ensure
                                        that all filters, cartridges and
                                        canisters used in the workplace are
                                        labeled and color coded with the
                                        NIOSH approval label and that the
                                        label is not removed and remains
                                        legible.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q7_answer === 1 && $bodyShopAudit->body_shop_q7_comment || $bodyShopAudit->body_shop_q7_answer === 3 && $bodyShopAudit->body_shop_q7_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is PPE equipment available and is it in good condition?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q7_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q7_answer === 2)
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
                @if($bodyShopAudit->body_shop_q7_answer === 2)
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
                                    <p>29 CFR 1910.132(a)
                                        Application. Protective equipment,
                                        including personnel protective
                                        equipment for eyes, face, head, and
                                        extremities, protective clothing,
                                        respiratory devices, and protective
                                        shields and barriers, shall be provided,
                                        used, and maintained in a sanitary
                                        and reliable condition wherever it is necessary by reason of hazards of
                                        processes or environment, chemical
                                        hazards, radiological hazards, or
                                        mechanical irritants encountered in a
                                        manner capable of causing injury or
                                        impairment in the function of any part
                                        of the body through absorption,
                                        inhalation or physical contact.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q8_answer === 1 && $bodyShopAudit->body_shop_q8_comment || $bodyShopAudit->body_shop_q8_answer === 3 && $bodyShopAudit->body_shop_q8_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are paint booths free from any flammable material?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q8_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q8_answer === 2)
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
                @if($bodyShopAudit->body_shop_q8_answer === 2)
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
                                    <p>29 CFR 1910.107(e)(i)
                                        Flammable and combustible liquids —
                                        storage and handling.
                                        (1) Conformance. The storage of
                                        flammable or combustible liquids in
                                        connection with spraying operations
                                        shall conform to the requirements of
                                        §1910.106, where applicable.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q9_answer === 1 && $bodyShopAudit->body_shop_q9_comment || $bodyShopAudit->body_shop_q9_answer === 3 && $bodyShopAudit->body_shop_q9_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all the flammable materials stored properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q9_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q9_answer === 2)
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
                @if($bodyShopAudit->body_shop_q9_answer === 2)
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
                                    <p>29 CFR 1910.106(a)(32)
                                        Storage: Flammable or combustible
                                        liquids shall be stored in a tank or in a
                                        container that complies with
                                        §1910.106(d)(2)(i) of this section</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q10_answer === 1 && $bodyShopAudit->body_shop_q10_comment || $bodyShopAudit->body_shop_q10_answer === 3 && $bodyShopAudit->body_shop_q10_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all secondary containers filled with chemicals
                    properly labeled?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q10_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q10_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all secondary containers filled with chemicals
                        properly labeled?</p>
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
                @if($bodyShopAudit->body_shop_q10_answer === 2)
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
                                        Transferring Chemicals in containers
                                        The employer shall ensure that labels
                                        or other forms of warning are legible,
                                        in English, and prominently displayed
                                        on the container, or readily available
                                        in the work area throughout each
                                        work shift. Employers having
                                        employees who speak other
                                        languages may add the information in
                                        their language to the material presented, as long as the information
                                        is presented in English as well.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q11_answer === 1 && $bodyShopAudit->body_shop_q11_comment || $bodyShopAudit->body_shop_q11_answer === 3 && $bodyShopAudit->body_shop_q11_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the eye wash equipment been tested, cleaned and documented weekly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q11_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q11_answer === 2)
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
                @if($bodyShopAudit->body_shop_q11_answer === 2)
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
                                    <p>29 CFR 1910.151(c), ANSI Z358.1-
                                        2009
                                        ANSI standard states that plumbed
                                        flushing equipment, “shall be
                                        activated weekly for a period long
                                        enough to verify operation and ensure
                                        that flushing fluid is available”.
                                        Furthermore, also requires Portable
                                        and Self Contained equipment “be
                                        visually checked to determine if
                                        flushing fluid needs to be changed or
                                        supplemented”.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q12_answer === 1 && $bodyShopAudit->body_shop_q12_comment || $bodyShopAudit->body_shop_q12_answer === 3 && $bodyShopAudit->body_shop_q12_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the eye wash equipment readily accessible?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q12_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q12_answer === 2)
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
                @if($bodyShopAudit->body_shop_q12_answer === 2)
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
                                    <p>The ANSI standard states that all
                                        flushing equipment must be located in
                                        areas that are accessible within 10
                                        seconds (roughly 55 feet).
                                         The Safety Showers and or
                                        Eyewash Stations must be
                                        located on the same level as
                                        the hazard and the path of
                                        travel shall be free from
                                        obstructions
                                         2014 update to Z358.1 added
                                        two important criteria. The
                                        first is that the requirement
                                        for tepid water is now defined
                                        as having a temperature of
                                        between 60 and 100 degrees
                                        Fahrenheit (15 to 37 degrees Celsius). The second change
                                        addresses simultaneous
                                        operation for combination
                                        units. This means that if you
                                        have a drench shower
                                        combined with an eyewash
                                        station, both devices must
                                        provide adequate flows and
                                        be fully operable at the same
                                        time.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q13_answer === 1 && $bodyShopAudit->body_shop_q13_comment || $bodyShopAudit->body_shop_q13_answer === 3 && $bodyShopAudit->body_shop_q13_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Has the eye wash container water supply been changed out properly based on
                    manufacturer recommendations per solution used?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q13_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q13_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Has the eye wash container water supply been changed out properly based on
                        manufacturer recommendations per solution used?</p>
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
                @if($bodyShopAudit->body_shop_q13_answer === 2)
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
                                    <p>Dealership is to follow manufacturing
                                        guidelines for water exchange, i.e.
                                        change every 90 days with new
                                        sanitizer packs also added.
                                        Initial/date sign off tag on side of
                                        unit.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q14_answer === 1 && $bodyShopAudit->body_shop_q14_comment || $bodyShopAudit->body_shop_q14_answer === 3 && $bodyShopAudit->body_shop_q14_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Do you have documentation on water/solution change out?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q14_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q14_answer === 2)
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
                {{--            @if($bodyShopAudit->body_shop_q14_answer === 2)--}}
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
        @endif
        @if($bodyShopAudit->body_shop_q15_answer === 1 && $bodyShopAudit->body_shop_q15_comment || $bodyShopAudit->body_shop_q15_answer === 3 && $bodyShopAudit->body_shop_q15_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are you following the mfg. specs?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q15_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q15_answer === 2)
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
                {{--            @if($bodyShopAudit->body_shop_q15_answer === 2)--}}
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
        @endif
        @if($bodyShopAudit->body_shop_q16_answer === 1 && $bodyShopAudit->body_shop_q16_comment || $bodyShopAudit->body_shop_q16_answer === 3 && $bodyShopAudit->body_shop_q16_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Have the fire extinguishers had their annual inspection and are they properly
                    identified and fully charged?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q16_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q16_answer === 2)
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
                @if($bodyShopAudit->body_shop_q16_answer === 2)
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
                                    <p>29 CFR 1910.157(d)(2) - The
                                        employer shall distribute portable fire
                                        extinguishers for use by employees on
                                        Class A fires so that the travel
                                        distance for employees to any
                                        extinguisher is 75 ft</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q17_answer === 1 && $bodyShopAudit->body_shop_q17_comment || $bodyShopAudit->body_shop_q17_answer === 3 && $bodyShopAudit->body_shop_q17_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are the fire extinguishers easily accessible?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q17_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q17_answer === 2)
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
                @if($bodyShopAudit->body_shop_q17_answer === 2)
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
                                    <p>29 CFR 1910.157(c)(1) - Fire
                                        extinguishers and shall mount, locate and identify them so that they are
                                        readily accessible to employees
                                        without subjecting the employees to
                                        possible injury. Mounting; Height is
                                        between 36” to 60”
                                        Accessibility is 20’” in front and sides</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q18_answer === 1 && $bodyShopAudit->body_shop_q18_comment || $bodyShopAudit->body_shop_q18_answer === 3 && $bodyShopAudit->body_shop_q18_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all hoses and cutting tips for the welder/cutting torches in good condition
                    without any cracks or breaks?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q18_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q18_answer === 2)
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
                @if($bodyShopAudit->body_shop_q18_answer === 2)
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
                                    <p>29 CFR 1910.252 / ANSI Z49.1
                                        Safety in Welding, Cutting, and Allied
                                        Processes.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q19_answer === 1 && $bodyShopAudit->body_shop_q19_comment || $bodyShopAudit->body_shop_q19_answer === 3 && $bodyShopAudit->body_shop_q19_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all exits properly marked?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q19_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q19_answer === 2)
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
                @if($bodyShopAudit->body_shop_q19_answer === 2)
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
                                    <p>NFPA 101, Section 7.10.1.2
                                        NFPA 101 Life Safety Code 3.3.136
                                        Means of Egress.
                                        A continuous and unobstructed way
                                        of travel from any point in a building
                                        or structure to a public way consisting
                                        of three separate and distinct parts:
                                        (1) the exit access, (2) the exit, and (3)
                                        the exit discharge.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q20_answer === 1 && $bodyShopAudit->body_shop_q20_comment || $bodyShopAudit->body_shop_q20_answer === 3 && $bodyShopAudit->body_shop_q20_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are pathways to exits clear of obstructions?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q20_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q20_answer === 2)
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
                @if($bodyShopAudit->body_shop_q20_answer === 2)
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
                                    <p>Ensure that exit routes are
                                        unobstructed such as by materials,
                                        equipment, locked doors, or dead-end
                                        corridors.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q21_answer === 1 && $bodyShopAudit->body_shop_q21_comment || $bodyShopAudit->body_shop_q21_answer === 3 && $bodyShopAudit->body_shop_q21_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all aisles/pathways, stairways and landings free from obstructions and are the
                    shop areas kept clean and orderly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q21_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q21_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all aisles/pathways, stairways and landings free from obstructions and are
                        the
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
                @if($bodyShopAudit->body_shop_q21_answer === 2)
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
                                    <p>General Duty Clause 29 U.S.C. §
                                        654, 5(a)1: - Each employer shall
                                        furnish to each of his employees’
                                        employment and a place of
                                        employment which are free from recognized hazards that are causing
                                        or are likely to cause death or serious
                                        physical harm to his employees.&quot;</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q22_answer === 1 && $bodyShopAudit->body_shop_q22_comment || $bodyShopAudit->body_shop_q22_answer === 3 && $bodyShopAudit->body_shop_q22_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are any doorways that are nonfunctioning or
                    blocked
                    marked by a sign stating “NOT AN EXIT”? Are any doorways that are nonfunctioning or blocked
                    marked
                    by a sign stating “NOT AN EXIT”?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q22_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q22_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are any doorways that are nonfunctioning or
                        blocked
                        marked by a sign stating “NOT AN EXIT”? Are any doorways that are nonfunctioning or blocked
                        marked
                        by a sign stating “NOT AN EXIT”?</p>
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
                @if($bodyShopAudit->body_shop_q22_answer === 2)
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
                                    <p>OSHA also requires that &quot;each exit
                                        must be clearly visible and marked by
                                        a sign reading &quot;EXIT&quot;. 1910.37(b)
                                        (2).
                                        &quot;Each exit route door must be free of
                                        decorations or signs that obscure the
                                        visibility of the exit route door.&quot;
                                        1910.37(b) (3) - &quot;Each doorway or
                                        passage along an exit access that
                                        could be mistaken for an exit must be
                                        marked &quot;NOT AN EXIT&quot; or similar
                                        designation, or be identified by a sign
                                        indicating its actual use (e.g., closet).&quot;
                                        1910.37(b) (5).</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q23_answer === 1 && $bodyShopAudit->body_shop_q23_comment || $bodyShopAudit->body_shop_q23_answer === 3 && $bodyShopAudit->body_shop_q23_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are floors in good repair and free from obstruction and debris and slippery
                    conditions?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q23_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q23_answer === 2)
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
                @if($bodyShopAudit->body_shop_q23_answer === 2)
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
                                    <p>General Duty Clause 29 U.S.C. §
                                        654, 5(a)1:</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q24_answer === 1 && $bodyShopAudit->body_shop_q24_comment || $bodyShopAudit->body_shop_q24_answer === 3 && $bodyShopAudit->body_shop_q24_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are floor openings in excess of 2.25” wide covered with hinged flaps?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q24_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q24_answer === 2)
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
                @if($bodyShopAudit->body_shop_q24_answer === 2)
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
                                    <p>29 CFR 1910.23 - Every floor hole
                                        into which persons can accidentally
                                        walk must be guarded by either:
                                        • a standard railing with standard
                                        toe board on all exposed
                                        sides, or
                                        • a floor hole cover of standard
                                        strength and construction.
                                        (While the cover is not in place, the floor hole must be
                                        constantly attended by
                                        someone or must be
                                        protected by a removable
                                        standard railing.)
                                        A cover that leaves no openings more
                                        than 1 inch wide must protect every
                                        floor hole into which persons cannot
                                        accidentally walk (because fixed
                                        machinery, equipment or walls). The
                                        cover must be securely held in place</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q25_answer === 1 && $bodyShopAudit->body_shop_q25_comment || $bodyShopAudit->body_shop_q25_answer === 3 && $bodyShopAudit->body_shop_q25_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                    working condition?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q25_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q25_answer === 2)
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
                @if($bodyShopAudit->body_shop_q25_answer === 2)
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
                                    <p>29 CFR 1910.242 - Never use frayed,
                                        damaged or deteriorated hoses.
                                        Always store hoses properly and away
                                        from heat sources or direct sunlight. A
                                        hose failure can cause serious injury.
                                        Hose Reels can decrease your chances
                                        of injury, as well as help hoses last
                                        longer.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q26_answer === 1 && $bodyShopAudit->body_shop_q26_comment || $bodyShopAudit->body_shop_q26_answer === 3 && $bodyShopAudit->body_shop_q26_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">All gas cylinders stored properly i.e. tied down etc.?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q26_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q26_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">All gas cylinders stored properly i.e. tied
                        down
                        etc.?</p>
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
                @if($bodyShopAudit->body_shop_q26_answer === 2)
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
                                        29 CFR 1926.350(a)(7); securing compressed gas cylinders.
                                    </p>
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
        @endif
        @if($bodyShopAudit->body_shop_q27_answer === 1 && $bodyShopAudit->body_shop_q27_comment || $bodyShopAudit->body_shop_q27_answer === 3 && $bodyShopAudit->body_shop_q27_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are gas cylinders stored away from sources of
                    heat or electricity and at least 20’ away from combustible materials?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q27_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q27_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are gas cylinders stored away from sources of
                        heat
                        or electricity and at least 20’ away from combustible materials?</p>
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
                @if($bodyShopAudit->body_shop_q27_answer === 2)
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
                                        CGAP C-6-1968 & C-8-1962</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q28_answer === 1 && $bodyShopAudit->body_shop_q28_comment || $bodyShopAudit->body_shop_q28_answer === 3 && $bodyShopAudit->body_shop_q28_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">When dispensing are all tanks holding flammable
                    material properly grounded?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q28_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q28_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">When dispensing are all tanks holding flammable
                        material properly grounded?</p>
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
                @if($bodyShopAudit->body_shop_q28_answer === 2)
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
                                        operated to prevent electrostatic ignitions. All metallic equipment where an
                                        ignitable mixture could be present shall be bonded or grounded. The bond or
                                        ground or both shall be physically applied or shall be inherently present by the
                                        nature of the installation. Any electrically isolated section of metallic piping
                                        or equipment shall be bonded or grounded to prevent hazardous accumulation of
                                        static electricity. All nonmetallic equipment and piping where an ignitable
                                        mixture could be present shall be given special consideration.
                                    </p>
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
        @endif
        @if($bodyShopAudit->body_shop_q29_answer === 1 && $bodyShopAudit->body_shop_q29_comment || $bodyShopAudit->body_shop_q29_answer === 3 && $bodyShopAudit->body_shop_q29_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there proper signage about not smoking in
                    the appropriate areas?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q29_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q29_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there proper signage about not smoking in
                        the
                        appropriate areas?</p>
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
                @if($bodyShopAudit->body_shop_q29_answer === 2)
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
                                        All equipment such as tanks,
                                        machinery, and piping shall be
                                        designed and operated to prevent
                                        electrostatic ignitions. All metallic
                                        equipment where an ignitable mixture
                                        could be present shall be bonded or
                                        grounded. The bond or ground or
                                        both shall be physically applied or
                                        shall be inherently present by the
                                        nature of the installation. Any
                                        electrically isolated section of metallic
                                        piping or equipment shall be bonded
                                        or grounded to prevent hazardous
                                        accumulation of static electricity. All
                                        nonmetallic equipment and piping
                                        where an ignitable mixture could be
                                        present shall be given special
                                        consideration.</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q30_answer === 1 && $bodyShopAudit->body_shop_q30_comment || $bodyShopAudit->body_shop_q30_answer === 3 && $bodyShopAudit->body_shop_q30_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are no smoking signs being enforced?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q30_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q30_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are no smoking signs being enforced?</p>
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
                {{--                @if($bodyShopAudit->body_shop_q30_answer === 2)--}}
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
                {{--                                    <p>29 CFR 1910.106--}}
                {{--                                        &quot;No Smoking&quot; signs shall be--}}
                {{--                                        conspicuously posted where hazard--}}
                {{--                                        from flammable liquid vapors is--}}
                {{--                                        normally present.</p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                @endif--}}
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
        @endif
        @if($bodyShopAudit->body_shop_q31_answer === 1 && $bodyShopAudit->body_shop_q31_comment || $bodyShopAudit->body_shop_q31_answer === 3 && $bodyShopAudit->body_shop_q31_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are goggles or face shields always worn when
                    grinding?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q31_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q31_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are goggles or face shields always worn when
                        grinding?</p>
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
                @if($bodyShopAudit->body_shop_q31_answer === 2)
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
                                    <p>29 CFR 1910 133 (a) (1) - (a) General requirements. (1) The employer shall ensure
                                        that each affected employee uses appropriate eye or face protection when exposed
                                        to eye or face hazards from flying particles, molten metal, liquid chemicals,
                                        acids or caustic liquids, chemical gases or vapors, or potentially injurious
                                        light radiation.
                                    </p>
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
        @endif
        @if($bodyShopAudit->body_shop_q32_answer === 1 && $bodyShopAudit->body_shop_q32_comment || $bodyShopAudit->body_shop_q32_answer === 3 && $bodyShopAudit->body_shop_q32_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there proper spacing on grinders; Tool rest
                    1/8”
                    from grinding wheel Tongue plate 1/4” from grinding wheel?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q32_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q32_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there proper spacing on grinders; Tool rest
                        1/8”
                        from grinding wheel Tongue plate 1/4” from grinding wheel?</p>
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
                @if($bodyShopAudit->body_shop_q32_answer === 2)
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
                                        Work rests shall be kept adjusted closely to the wheel with a maximum opening of
                                        one-eighth inch

                                        29 CFR 1910.215(b)(9) - exposure adjustment. (Top Cover over Wheel) Safety
                                        guards. The distance between the wheel periphery and the adjustable tongue or
                                        the end of the peripheral member at the top shall never exceed one-fourth
                                        inch</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q33_answer === 1 && $bodyShopAudit->body_shop_q33_comment || $bodyShopAudit->body_shop_q33_answer === 3 && $bodyShopAudit->body_shop_q33_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are Signs posted warning of automatic starting
                    feature of the compressors?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q33_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q33_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are Signs posted warning of automatic starting
                        feature of the compressors?</p>
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
                @if($bodyShopAudit->body_shop_q33_answer === 2)
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
                                    <p>Industry Standards Apply
                                        Safety</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q34_answer === 1 && $bodyShopAudit->body_shop_q34_comment || $bodyShopAudit->body_shop_q34_answer === 3 && $bodyShopAudit->body_shop_q34_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there clear access of at least 36” to all
                    electrical panels?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q34_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q34_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there clear access of at least 36” to all
                        electrical panels?</p>
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
                @if($bodyShopAudit->body_shop_q34_answer === 2)
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
                                        equipment serving 600 volts or less</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q35_answer === 1 && $bodyShopAudit->body_shop_q35_comment || $bodyShopAudit->body_shop_q35_answer === 3 && $bodyShopAudit->body_shop_q35_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all the breakers properly labeled?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q35_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q35_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all the breakers properly labeled?</p>
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
                @if($bodyShopAudit->body_shop_q35_answer === 2)
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
                                        Note to paragraph (b) (1) (i) of this section: Suitability of equipment for an
                                        identified purpose may be evidenced by listing or labeling for that identified
                                        purpose. </p>
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
        @endif
        @if($bodyShopAudit->body_shop_q36_answer === 1 && $bodyShopAudit->body_shop_q36_comment || $bodyShopAudit->body_shop_q36_answer === 3 && $bodyShopAudit->body_shop_q36_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are commercial grade extension cords being used
                    properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q36_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q36_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are commercial grade extension cords being used
                        properly?</p>
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
                @if($bodyShopAudit->body_shop_q36_answer === 2)
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
        @endif
        @if($bodyShopAudit->body_shop_q37_answer === 1 && $bodyShopAudit->body_shop_q37_comment || $bodyShopAudit->body_shop_q37_answer === 3 && $bodyShopAudit->body_shop_q37_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all electrical cords in good working order
                    (none frayed, cracked, taped, or spliced or ground missing on 3 prong plugs)?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q37_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q37_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all electrical cords in good working order
                        (none frayed, cracked, taped, or spliced or ground missing on 3 prong plugs)?</p>
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
                @if($bodyShopAudit->body_shop_q37_answer === 2)
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
                                        external defects (such as loose parts, deformed and missing pins, or damage to
                                        outer jacket or insulation) and for evidence of possible internal damage (such
                                        as pinched or crushed outer jacket).</p>
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
        @endif
        @if($bodyShopAudit->body_shop_q38_answer === 1 && $bodyShopAudit->body_shop_q38_comment || $bodyShopAudit->body_shop_q38_answer === 3 && $bodyShopAudit->body_shop_q38_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all electrical plug ends still have ground
                    prong attached?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q38_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q38_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all electrical plug ends still have ground
                        prong attached?</p>
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
                {{--                @if($bodyShopAudit->body_shop_q38_answer === 2)--}}
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
                {{--                                    <p>29 CFR 1910.334--}}
                {{--                                        Electrical cords shall be visually--}}
                {{--                                        inspected before use on any shift for--}}
                {{--                                        external defects (such as loose parts,--}}
                {{--                                        deformed and missing pins, or--}}
                {{--                                        damage to outer jacket or insulation)--}}
                {{--                                        and for evidence of possible internal--}}
                {{--                                        damage (such as pinched or crushed--}}
                {{--                                        outer jacket).</p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                @endif--}}
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
        @endif
        @if($bodyShopAudit->body_shop_q39_answer === 1 && $bodyShopAudit->body_shop_q39_comment || $bodyShopAudit->body_shop_q39_answer === 3 && $bodyShopAudit->body_shop_q39_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all other additional electrical issues correct?
                    If “No” explain.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q39_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q39_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all other additional electrical issues correct?
                        If “No” explain.</p>
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
                @if($bodyShopAudit->body_shop_q39_answer === 2)
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
        @endif
        @if($bodyShopAudit->body_shop_q40_answer === 1 && $bodyShopAudit->body_shop_q40_comment || $bodyShopAudit->body_shop_q40_answer === 3 && $bodyShopAudit->body_shop_q40_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">There are no other miscellaneous electrical issues
                    to note? If “No” explain further.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q40_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q40_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">There are no other miscellaneous electrical issues
                        to note? If “No” explain further.</p>
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
                @if($bodyShopAudit->body_shop_q40_answer === 2)
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
        @endif
        @if($bodyShopAudit->body_shop_q41_answer === 1 && $bodyShopAudit->body_shop_q41_comment || $bodyShopAudit->body_shop_q41_answer === 3 && $bodyShopAudit->body_shop_q41_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid safety gloves are “Class O Heavy-Duty gloves
                    rated to withstand 1,000 volts?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q41_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q41_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid safety gloves are “Class O Heavy-Duty gloves
                        rated to withstand 1,000 volts?</p>
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
                @if($bodyShopAudit->body_shop_q41_answer === 2)
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
        @endif
        @if($bodyShopAudit->body_shop_q42_answer === 1 && $bodyShopAudit->body_shop_q42_comment || $bodyShopAudit->body_shop_q42_answer === 3 && $bodyShopAudit->body_shop_q42_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Hybrid safety glasses worn when working on hybrid
                    vehicles?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q42_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q42_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Hybrid safety glasses worn when working on hybrid
                        vehicles?</p>
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
                {{--                @if($bodyShopAudit->body_shop_q42_answer === 2)--}}
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
                {{--                                    <p>Safety--}}
                {{--                                        Safety Equipment:--}}
                {{--                                        Gloves--}}
                {{--                                        Goggles--}}
                {{--                                        Key Box--}}
                {{--                                        Steering wheel Cover--}}
                {{--                                        Sign for Vehicle</p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                @endif--}}
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
        @endif
        @if($bodyShopAudit->body_shop_q43_answer === 1 && $bodyShopAudit->body_shop_q43_comment || $bodyShopAudit->body_shop_q43_answer === 3 && $bodyShopAudit->body_shop_q43_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the first aid kit properly stocked given the
                    dealership work environment?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $bodyShopAudit->body_shop_q43_comment }}</p>
                </div>
            </li>
        @endif
        @if($bodyShopAudit->body_shop_q43_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the first aid kit properly stocked given the
                        dealership work environment?</p>
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
                @if($bodyShopAudit->body_shop_q43_answer === 2)
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
                                        American National Standard (ANSI) Z308.1-1998. Appendix A

                                        "Minimum Requirements for Workplace First-aid Kits."
                                    </p>
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
        @endif
        @if($bodyShopAudit->body_shop_q44_comment)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Additional Notes:</p>
                </div>
                <div>
                    <p>{{ $bodyShopAudit->body_shop_q44_comment }}</p>
                </div>
            </li>
        @endif
    </ul>
</div>
</body>
</html>
