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
    <ul class="divide-y divide-gray-300">
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Customer Number</p>
            <p>{{ $individualAudit->customer_number }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <p class="font-bold">Customer Name</p>
            <p>{{ $individualAudit->customer_name }}</p>
        </li>
        <li class="py-10 space-y-5 page-break">
            <div>
                <p class="font-bold">Cash or Finance?</p>
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
        @if($individualAudit->individual_q3_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Buyers Order & RISC a match?</p>
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
        @if($individualAudit->individual_q4_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Vehicle price exceeds MSRP?</p>
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
        @if($individualAudit->individual_q5_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is it clear what the customer purchased and did the deal reflect the norm in
                        the
                        Store?</p>
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
        @if($individualAudit->individual_q6_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the deal sent to more than one finance source?</p>
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
        @if($individualAudit->individual_q7_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all customers being treated the same regarding
                        markups on products offered on the menu system? If “No” explain.</p>
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
        @if($individualAudit->individual_q8_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Credit app signed by borrower?</p>
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
        @if($individualAudit->individual_q9_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Do the finance numbers, i.e. income, rent etc.,
                        match from the handwritten credit applications to the credit application submitted to banks?</p>
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
        @if($individualAudit->individual_q10_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Buyers Order & RISC set forth price of ancillary
                        products?</p>
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
        @if($individualAudit->individual_q11_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Single Document: All of the agreements of the
                        buyer and seller in one document (if required) with respect to the total cost and the terms of
                        payment for the motor vehicle, including any promissory notes or any other evidences of
                        indebtedness?</p>
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
        @if($individualAudit->individual_q12_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Signed by all Buyers and Seller - RISC & Retail
                        Order?</p>
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
        @if($individualAudit->individual_q13_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Date on RISC is accurate. NO BACKDATE</p>
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
        @if($individualAudit->individual_q14_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Language of copy of contract given to customer proper for negotiation language
                        if
                        required by state law?</p>
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
        @if($individualAudit->individual_q15_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Credit applications complete properly, signed by
                        customer and accurate? If “No” explain.</p>
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
        @if($individualAudit->individual_q16_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are all state specific disclosures included in the
                        deal?</p>
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
        @if($individualAudit->individual_q17_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Cosigner Notice? Only if a cosigner.</p>
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
        @if($individualAudit->individual_18_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Did the F&I deals have privacy
                        statement?</p>
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
                        <p>{{ $individualAudit->individual_q18_comment }}</p>
                    </div>
                @endif
            </li>
        @endif
        @if($individualAudit->individual_19_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is there a menu present and is it filled out
                        properly and signed by customer?</p>
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
        @if($individualAudit->individual_q20_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are the products purchased and or denied “Clearly”
                        displayed on the menu and or “Settlement Disclosure Document?</p>
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
        @if($individualAudit->individual_q21_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If there is a cashed deferred payment made, is it
                        properly disclosed?</p>
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
        @if($individualAudit->individual_q22_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">If a cash deferred down payment, is it paid before
                        the 2nd scheduled payment period?</p>
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
        @if($individualAudit->individual_q23_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Check price of products on buyers order and
                        RISC. Is amount charged for products similar to that charged other purchasers? If not, note
                        whether
                        higher.</p>
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
        @if($individualAudit->individual_q24_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Dealer recap or reconciliation document
                        reviewed and in file?</p>
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
        @if($individualAudit->individual_q25_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the dealership's markup rate within the
                        Dealerships Participation Program rate as noted in their CMS program?</p>
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
        @if($individualAudit->individual_q26_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is an “Exception Notice (DPP form) filled out if
                        the standard dealership rate not applied?</p>
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
        @if($individualAudit->individual_q27_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Are markups handled the same for similar customers,
                        i.e. is it higher for protected class: sex, national origin, race, age etc.?</p>
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
        @if($individualAudit->individual_q28_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">For used cars, was the buyer’s guide signed off
                        on?</p>
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
        @if($individualAudit->individual_q29_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was it clear what products the customer
                        purchased and did the deal reflect the norm?</p>
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
        @if($individualAudit->individual_q30_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was OFAC run and on file either physically or
                        electronically?</p>
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
        @if($individualAudit->individual_q31_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was a copy of the signed Privacy notice in the deal
                        jacket?</p>
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
        @if($individualAudit->individual_q32_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the RBPN or Exception notice presented to and
                        signed by the customer?</p>
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
        @if($individualAudit->individual_q33_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Was the Red Flag software run and a copy on file
                        either physically or electronically?</p>
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
        @if($individualAudit->individual_q34_answer === 2)
            <li class="py-10 space-y-5 page-break">
                <div>
                    <p class="font-bold">Is the deal jacket complete with all
                        information?</p>
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
