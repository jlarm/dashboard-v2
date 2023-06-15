@props(['title'])
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deal Jacket Audit Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="max-w-4xl mx-auto">
    @if($count === 0)
        <div class="h-screen flex items-center justify-center">
            <div class="space-y-5 text-center">
                <x-application-logo class=" h-12 w-auto mx-auto"/>
                @if($individualAudit->store->logo)
                    <img
                        class="py-20 mx-auto"
                        src="{{ asset($individualAudit->store->logo) }}"
                        alt="">
                @endif
                @if(tenant('locations'))
                    <h1 class="text-3xl font-bold text-arm-blue-600">Deal Jacket Audit Review
                        for {{ $individualAudit->store->name }}</h1>
                @else
                    <h1 class="text-3xl font-bold text-arm-blue-600">Deal Jacket Audit Review
                        for {{ tenant('name') }}</h1>
                @endif
                <p class="text-arm-blue-400">{{ $individualAudit->audit_date->format('F d, Y') }}</p>
            </div>
        </div>
    @endif
    <ul class="divide-y divide-gray-300">
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Date of Deal Jacket</p>
            <p>{{ $individualAudit->deal_jacket_date->format('F d, Y') }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Customer Number</p>
            <p>{{ $individualAudit->customer_number }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Customer Name</p>
            <p>{{ $individualAudit->customer_name }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Finance Manager</p>
            <p>{{ $managerName ?? '' }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Cash, Finance or Lease?</p>
                <p>
                    @if($individualAudit->individual_q1_answer === 1)
                        Cash
                    @elseif($individualAudit->individual_q1_answer === 2)
                        Finance
                    @endif
                </p>
            </div>
            @if($individualAudit->individual_q1_danger)
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
            @if($individualAudit->individual_q1_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q1_comment }}</p>
                </div>
            @endif
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">New or Used?</p>
                <p>
                    @if($individualAudit->individual_q2_answer === 1)
                        New
                    @elseif($individualAudit->individual_q2_answer === 2)
                        Used
                    @endif
                </p>
            </div>
            @if($individualAudit->individual_q2_danger)
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
            @if($individualAudit->individual_q2_comment)
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q2_comment }}</p>
                </div>
            @endif
        </li>
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Mileage</p>
            <p>{{ $individualAudit->mileage }}</p>
        </li>
        @if($individualAudit->individual_q3_answer === 1 && $individualAudit->individual_q3_comment || $individualAudit->individual_q3_answer === 3 && $individualAudit->individual_q3_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there an Odometer Statement in deal?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q3_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q3_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there an Odometer Statement in deal?</p>
                    <p>
                        @if($individualAudit->individual_q3_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q3_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q3_danger)
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
                @if($individualAudit->individual_q3_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q3_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q4_answer === 1 && $individualAudit->individual_q4_comment || $individualAudit->individual_q4_answer === 3 && $individualAudit->individual_q4_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Did deal have two page model Privacy Notice statement and was it signed?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q4_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q4_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Did deal have two page model Privacy Notice statement and was it signed?</p>
                    <p>
                        @if($individualAudit->individual_q4_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q4_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q4_danger)
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
                @if($individualAudit->individual_q4_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q4_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q5_answer === 1 && $individualAudit->individual_q5_comment || $individualAudit->individual_q5_answer === 3 && $individualAudit->individual_q5_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Menu Present?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q5_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q5_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Menu Present?</p>
                    <p>
                        @if($individualAudit->individual_q5_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q5_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q5_danger)
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
                @if($individualAudit->individual_q5_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q5_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q6_answer === 1 && $individualAudit->individual_q6_comment || $individualAudit->individual_q6_answer === 3 && $individualAudit->individual_q6_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the Menu filled out properly?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q6_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q6_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the Menu filled out properly?</p>
                    <p>
                        @if($individualAudit->individual_q6_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q6_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q6_danger)
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
                @if($individualAudit->individual_q6_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q6_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q7_answer === 1 && $individualAudit->individual_q7_comment || $individualAudit->individual_q7_answer === 3 && $individualAudit->individual_q7_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there a separate signed contract for each product sold on menu?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q7_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q7_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there a separate signed contract for each product sold on menu?</p>
                    <p>
                        @if($individualAudit->individual_q7_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q7_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q7_danger)
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
                @if($individualAudit->individual_q7_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q7_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q8_answer === 1 && $individualAudit->individual_q8_comment || $individualAudit->individual_q8_answer === 3 && $individualAudit->individual_q8_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all customers being treated the same regarding product markups on menu system?
                    If no explain</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q8_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q8_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all customers being treated the same regarding product markups on menu
                        system? If no explain</p>
                    <p>
                        @if($individualAudit->individual_q8_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q8_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q8_danger)
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
                @if($individualAudit->individual_q8_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q8_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q9_answer === 1 && $individualAudit->individual_q9_comment || $individualAudit->individual_q9_answer === 3 && $individualAudit->individual_q9_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was OFAC run and on file either physically or electronically?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q9_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q9_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was OFAC run and on file either physically or electronically?</p>
                    <p>
                        @if($individualAudit->individual_q9_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q9_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q9_danger)
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
                @if($individualAudit->individual_q9_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q9_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q10_answer === 1 && $individualAudit->individual_q10_comment || $individualAudit->individual_q10_answer === 3 && $individualAudit->individual_q10_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was the Red Flag software run and on file either physically or electronically?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q10_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q10_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the Red Flag software run and on file either physically or
                        electronically?</p>
                    <p>
                        @if($individualAudit->individual_q10_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q10_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q10_danger)
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
                @if($individualAudit->individual_q10_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q10_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q11_answer === 1 && $individualAudit->individual_q11_comment || $individualAudit->individual_q11_answer === 3 && $individualAudit->individual_q11_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there a copy of the Buyer's Guide in deal jacket? (if used car sold)</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q11_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q11_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there a copy of the Buyer's Guide in deal jacket? (if used car sold)</p>
                    <p>
                        @if($individualAudit->individual_q11_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q11_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q11_danger)
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
                @if($individualAudit->individual_q11_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q11_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q12_answer === 1 && $individualAudit->individual_q12_comment || $individualAudit->individual_q12_answer === 3 && $individualAudit->individual_q12_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">If Buyer's Guide present is it filled out properly and signed by customer?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q12_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q12_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If Buyer's Guide present is it filled out properly and signed by customer?</p>
                    <p>
                        @if($individualAudit->individual_q12_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q12_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q12_danger)
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
                @if($individualAudit->individual_q12_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q12_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q13_answer === 1 && $individualAudit->individual_q13_comment || $individualAudit->individual_q13_answer === 3 && $individualAudit->individual_q13_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was RBPN or Exception notice presented and signed by customer?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q13_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q13_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was RBPN or Exception notice presented and signed by customer?</p>
                    <p>
                        @if($individualAudit->individual_q13_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q13_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q13_danger)
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
                @if($individualAudit->individual_q13_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q13_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q14_answer === 1 && $individualAudit->individual_q14_comment || $individualAudit->individual_q14_answer === 3 && $individualAudit->individual_q14_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Does the Buyers Order & the RISC match up regarding final purchase price? </p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q14_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q14_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Does the Buyers Order & the RISC match up regarding final purchase price? </p>
                    <p>
                        @if($individualAudit->individual_q14_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q14_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q14_danger)
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
                @if($individualAudit->individual_q14_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q14_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q15_answer === 1 && $individualAudit->individual_q15_comment || $individualAudit->individual_q15_answer === 3 && $individualAudit->individual_q15_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Does the Menu, Buyers Order & the RISC match up regarding ancillary products
                    purchased?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q15_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q15_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Does the Menu, Buyers Order & the RISC match up regarding ancillary products
                        purchased?</p>
                    <p>
                        @if($individualAudit->individual_q15_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q15_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q15_danger)
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
                @if($individualAudit->individual_q15_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q15_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q16_answer === 1 && $individualAudit->individual_q16_comment || $individualAudit->individual_q16_answer === 3 && $individualAudit->individual_q16_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Products purchased or denied are "CLEARLY" displayed on the menu and or "Settlement
                    Disclosure Document"?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q16_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q16_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Products purchased or denied are "CLEARLY" displayed on the menu and or
                        "Settlement Disclosure Document"?</p>
                    <p>
                        @if($individualAudit->individual_q16_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q16_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q16_danger)
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
                @if($individualAudit->individual_q16_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q16_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q17_answer === 1 && $individualAudit->individual_q17_comment || $individualAudit->individual_q17_answer === 3 && $individualAudit->individual_q17_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Check price of products on buyers order and RISC, Is the amount charged similar to
                    that charged for other purchasers? If not explain.</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q17_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q17_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Check price of products on buyers order and RISC, Is the amount charged similar
                        to that charged for other purchasers? If not explain.</p>
                    <p>
                        @if($individualAudit->individual_q17_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q17_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q17_danger)
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
                @if($individualAudit->individual_q17_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q17_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q18_answer === 1 && $individualAudit->individual_q18_comment || $individualAudit->individual_q18_answer === 3 && $individualAudit->individual_q18_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">MSRP of Vehicle did not exceed price?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q18_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q18_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">MSRP of Vehicle did not exceed price?</p>
                    <p>
                        @if($individualAudit->individual_q18_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q18_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q18_danger)
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
                @if($individualAudit->individual_q18_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q17_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q19_answer === 1 && $individualAudit->individual_q19_comment || $individualAudit->individual_q19_answer === 3 && $individualAudit->individual_q19_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was deal sent to more than one finance source?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q19_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q19_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was deal sent to more than one finance source?</p>
                    <p>
                        @if($individualAudit->individual_q19_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q19_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q19_danger)
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
                @if($individualAudit->individual_q19_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q19_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q20_answer === 1 && $individualAudit->individual_q20_comment || $individualAudit->individual_q20_answer === 3 && $individualAudit->individual_q20_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was credit application completed properly, accurate and signed by customer?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q20_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q20_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was credit application completed properly, accurate and signed by customer?</p>
                    <p>
                        @if($individualAudit->individual_q20_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q20_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q20_danger)
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
                @if($individualAudit->individual_q20_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q20_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q21_answer === 1 && $individualAudit->individual_q21_comment || $individualAudit->individual_q21_answer === 3 && $individualAudit->individual_q21_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">If a handwritten credit application was present, it's signed and matches the bank
                    copy regarding income, rent etc?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q21_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q21_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If a handwritten credit application was present, it's signed and matches the
                        bank copy regarding income, rent etc?</p>
                    <p>
                        @if($individualAudit->individual_q21_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q21_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q21_danger)
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
                @if($individualAudit->individual_q21_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q21_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q22_answer === 1 && $individualAudit->individual_q22_comment || $individualAudit->individual_q22_answer === 3 && $individualAudit->individual_q22_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was an Adverse Action filled out if warranted?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q22_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q22_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was an Adverse Action filled out if warranted?</p>
                    <p>
                        @if($individualAudit->individual_q22_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q22_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q22_danger)
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
                @if($individualAudit->individual_q22_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q22_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q23_answer === 1 && $individualAudit->individual_q23_comment || $individualAudit->individual_q23_answer === 3 && $individualAudit->individual_q23_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the DPP form filled out properly stating dealership CMS policy mark up rate and
                    actual rate spread to cutomer?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q23_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q23_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the DPP form filled out properly stating dealership CMS policy mark up rate
                        and actual rate spread to cutomer?</p>
                    <p>
                        @if($individualAudit->individual_q23_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q23_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q23_danger)
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
                @if($individualAudit->individual_q23_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q23_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q24_answer === 1 && $individualAudit->individual_q24_comment || $individualAudit->individual_q24_answer === 3 && $individualAudit->individual_q24_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are markups handled the same for similar customers, i.e. is it higher for protected
                    class: sex, national origin, race, age, etc?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q24_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q24_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are markups handled the same for similar customers, i.e. is it higher for
                        protected class: sex, national origin, race, age, etc?</p>
                    <p>
                        @if($individualAudit->individual_q24_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q24_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q24_danger)
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
                @if($individualAudit->individual_q24_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q24_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q25_answer === 1 && $individualAudit->individual_q25_comment || $individualAudit->individual_q25_answer === 3 && $individualAudit->individual_q25_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the date on RISC accurate with no backdating?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q25_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q25_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the date on RISC accurate with no backdating?</p>
                    <p>
                        @if($individualAudit->individual_q25_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q25_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q25_danger)
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
                @if($individualAudit->individual_q25_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q25_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q26_answer === 1 && $individualAudit->individual_q26_comment || $individualAudit->individual_q26_answer === 3 && $individualAudit->individual_q26_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all contracts signed by customer(s)?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q26_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q26_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all contracts signed by customer(s)?</p>
                    <p>
                        @if($individualAudit->individual_q26_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q26_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q26_danger)
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
                @if($individualAudit->individual_q26_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q26_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q27_answer === 1 && $individualAudit->individual_q27_comment || $individualAudit->individual_q27_answer === 3 && $individualAudit->individual_q27_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">All signature match up between menu, buyers order, RISC and all other product
                    contracts?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q27_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q27_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">All signature match up between menu, buyers order, RISC and all other product
                        contracts?</p>
                    <p>
                        @if($individualAudit->individual_q27_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q27_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q27_danger)
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
                @if($individualAudit->individual_q27_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q27_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q28_answer === 1 && $individualAudit->individual_q28_comment || $individualAudit->individual_q28_answer === 3 && $individualAudit->individual_q28_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is there a copy of customers Driver's License in deal?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q28_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q28_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there a copy of customers Driver's License in deal?</p>
                    <p>
                        @if($individualAudit->individual_q28_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q28_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q28_danger)
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
                @if($individualAudit->individual_q28_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q28_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q29_answer === 1 && $individualAudit->individual_q29_comment || $individualAudit->individual_q29_answer === 3 && $individualAudit->individual_q29_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Language of contracts given to customers proper for negotiaition if required by
                    state law?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q29_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q29_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Language of contracts given to customers proper for negotiaition if required by
                        state law?</p>
                    <p>
                        @if($individualAudit->individual_q29_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q29_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q29_danger)
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
                @if($individualAudit->individual_q29_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q29_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q30_answer === 1 && $individualAudit->individual_q30_comment || $individualAudit->individual_q30_answer === 3 && $individualAudit->individual_q30_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Are all state specific disclosures included in deal?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q30_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q30_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all state specific disclosures included in deal?</p>
                    <p>
                        @if($individualAudit->individual_q30_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q30_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q30_danger)
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
                @if($individualAudit->individual_q30_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q30_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q31_answer === 1 && $individualAudit->individual_q31_comment || $individualAudit->individual_q31_answer === 3 && $individualAudit->individual_q31_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is Cosigner Notice sign? (if applicable)</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q31_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q31_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is Cosigner Notice sign? (if applicable)</p>
                    <p>
                        @if($individualAudit->individual_q31_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q31_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q31_danger)
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
                @if($individualAudit->individual_q31_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q31_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q32_answer === 1 && $individualAudit->individual_q32_comment || $individualAudit->individual_q32_answer === 3 && $individualAudit->individual_q32_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">If there is a cashed deferred payment "Promissory Note from Customer" made, is it
                    properly disclosed?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q32_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q32_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If there is a cashed deferred payment "Promissory Note from Customer" made, is
                        it properly disclosed?</p>
                    <p>
                        @if($individualAudit->individual_q32_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q32_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q32_danger)
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
                @if($individualAudit->individual_q32_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q32_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q33_answer === 1 && $individualAudit->individual_q33_comment || $individualAudit->individual_q33_answer === 3 && $individualAudit->individual_q33_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was the "Cashed Deferred" down payment paid off before the 2nd scheduled payment
                    period?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q33_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q33_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the "Cashed Deferred" down payment paid off before the 2nd scheduled
                        payment period?</p>
                    <p>
                        @if($individualAudit->individual_q33_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q33_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q33_danger)
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
                @if($individualAudit->individual_q33_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q33_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q34_answer === 1 && $individualAudit->individual_q34_comment || $individualAudit->individual_q34_answer === 3 && $individualAudit->individual_q34_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the Deal Recap or reconcillation documents reviewed and in file?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q34_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q34_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the Deal Recap or reconcillation documents reviewed and in file?</p>
                    <p>
                        @if($individualAudit->individual_q34_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q34_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q34_danger)
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
                @if($individualAudit->individual_q34_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q34_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q35_answer === 1 && $individualAudit->individual_q35_comment || $individualAudit->individual_q35_answer === 3 && $individualAudit->individual_q35_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was the 8300 procedures followed for transactions defined as "CASH"?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q35_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q35_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the 8300 procedures followed for transactions defined as "CASH"?</p>
                    <p>
                        @if($individualAudit->individual_q35_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q35_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q35_danger)
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
                @if($individualAudit->individual_q35_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q35_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q36_answer === 1 && $individualAudit->individual_q36_comment || $individualAudit->individual_q36_answer === 3 && $individualAudit->individual_q36_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was there a receipt for any cash down payments in deal?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q36_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q36_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was there a receipt for any cash down payments in deal?</p>
                    <p>
                        @if($individualAudit->individual_q36_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q36_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q36_danger)
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
                @if($individualAudit->individual_q36_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q36_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q37_answer === 1 && $individualAudit->individual_q37_comment || $individualAudit->individual_q37_answer === 3 && $individualAudit->individual_q37_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Was the trade in vehicle properly disclosed (line itemed) on the buyers order and
                    RISC?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q37_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q37_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the trade in vehicle properly disclosed (line itemed) on the buyers order
                        and RISC?</p>
                    <p>
                        @if($individualAudit->individual_q37_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q37_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q37_danger)
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
                @if($individualAudit->individual_q37_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q37_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q38_answer === 1 && $individualAudit->individual_q38_comment || $individualAudit->individual_q38_answer === 3 && $individualAudit->individual_q38_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Lease deal contract properly displaying all products purchased?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q38_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q38_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Lease deal contract properly displaying all products purchased?</p>
                    <p>
                        @if($individualAudit->individual_q38_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q38_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q38_danger)
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
                @if($individualAudit->individual_q38_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q38_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q39_answer === 1 && $individualAudit->individual_q39_comment || $individualAudit->individual_q39_answer === 3 && $individualAudit->individual_q39_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is it clear what the customer purchased and did the deal reflect the norm in the
                    dealership?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q39_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q39_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is it clear what the customer purchased and did the deal reflect the norm in
                        the dealership?</p>
                    <p>
                        @if($individualAudit->individual_q39_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q39_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q39_danger)
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
                @if($individualAudit->individual_q39_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q39_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_q40_answer === 1 && $individualAudit->individual_q40_comment || $individualAudit->individual_q40_answer === 3 && $individualAudit->individual_q40_comment)
            <li class="py-10 space-y-5 page-break">
                <p class="font-bold">Is the deal jacket complete with all information required based on the customer
                    needs and wants?</p>
                <div>
                    <p class="font-bold">Comments:</p>
                    <p>{{ $individualAudit->individual_q40_comment }}</p>
                </div>
            </li>
        @endif
        @if($individualAudit->individual_q40_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the deal jacket complete with all information required based on the customer
                        needs and wants?</p>
                    <p>
                        @if($individualAudit->individual_q40_answer === 1)
                            Yes
                        @elseif($individualAudit->individual_q40_answer === 2)
                            No
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                @if($individualAudit->individual_q40_danger)
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
                @if($individualAudit->individual_q40_comment)
                    <div>
                        <p class="font-bold">Comments:</p>
                        <p>{{ $individualAudit->individual_q40_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Images:</p>
            <div class="grid grid-cols-2 gap-10">
                @foreach($individualAudit->getMedia('individual_audit_images') as $image)
                    <img src="{{ $image->getUrl() }}" alt="">
                @endforeach
            </div>
        </li>
    </ul>
</div>
</body>
</html>
