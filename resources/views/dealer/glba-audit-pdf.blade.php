<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<div class="w-full h-screen bg-gray-50 grid grid-cols-8 grid-rows-6">
    <div class="col-span-3 col-start-1 p-20">
        <x-application-logo class="h-auto w-full"/>
    </div>
    <div class="col-span-5 row-span-4 col-start-1 row-start-2 bg-arm-blue-500 z-10 py-10 pr-10">
        <div class="w-full h-full flex flex-row items-center border-t border-r border-b border-white ">
            <div class="flex flex-col ml-10">
                <h1 class="text-5xl text-white">GLBA Report<span
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
<div class="w-full h-screen p-10">
    <div class="prose min-w-full divide-y divide-gray-200">
        @if($audit->finance_q1_comment || $audit->finance_q1_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if($audit->getFirstMedia('finance_q1_images') != null)
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q1_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q1_answer === 1 && $audit->finance_q1_comment || $audit->finance_q1_answer === 3 && $audit->finance_q1_comment)
                        <h4>Has the Dealer established a written CMS?</h4>
                    @elseif($audit->finance_q1_answer === 2)
                        <h4>The Dealer has not established a written CMS.</h4>
                    @endif
                    @if($audit->finance_q1_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q1_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q1_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q1_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q2_comment || $audit->finance_q2_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q2_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q2_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q2_answer === 1 && $audit->finance_q2_comment || $audit->finance_q2_answer === 3 && $audit->finance_q2_comment)
                        <h4>Has the written CMS been approved by the Board/Ownership?</h4>
                    @elseif($audit->finance_q2_answer === 2)
                        <h4>The written CMS has not been approved by the Board/Ownership.</h4>
                    @endif
                    @if($audit->finance_q2_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q2_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q2_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q2_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q3_comment || $audit->finance_q3_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q3_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q3_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q3_answer === 1 && $audit->finance_q3_comment || $audit->finance_q3_answer === 3 && $audit->finance_q3_comment)
                        <h4>Are shredding bins being utilized in dealership?</h4>
                    @elseif($audit->finance_q3_answer === 2)
                        <h4>Shredding bins re not being utilized in dealership.</h4>
                    @endif
                    @if($audit->finance_q3_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q3_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q3_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q3_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q4_comment || $audit->finance_q4_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q4_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q4_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q4_answer === 1 && $audit->finance_q4_comment || $audit->finance_q4_answer === 3 && $audit->finance_q4_comment)
                        <h4>Are shredding bins being emptied properly?</h4>
                    @elseif($audit->finance_q4_answer === 2)
                        <h4>Shredding bins are not being emptied properly.</h4>
                    @endif
                    @if($audit->finance_q4_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q4_answer === 2)
                        <p>CFR 1910.178(l)(2)(ii) – Training requirements</p>
                    @endif
                    @if($audit->finance_q4_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q4_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q5_comment || $audit->finance_q5_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q5_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q5_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q5_answer === 1 && $audit->finance_q5_comment || $audit->finance_q5_answer === 3 && $audit->finance_q5_comment)
                        <h4>Has complaint procedure been established and adopted by Board?</h4>
                    @elseif($audit->finance_q5_answer === 2)
                        <h4>The complaint procedure has not been established and adopted by Board.</h4>
                    @endif
                    @if($audit->finance_q5_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q5_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q5_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q5_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q6_comment || $audit->finance_q6_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q6_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q6_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q6_answer === 1 && $audit->finance_q6_comment || $audit->finance_q6_answer === 3 && $audit->finance_q6_comment)
                        <h4>Is accounting department/office locked and secured when employees not present?</h4>
                    @elseif($audit->finance_q6_answer === 2)
                        <h4>Accounting department/office is not locked and secured when employees not present.</h4>
                    @endif
                    @if($audit->finance_q6_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q6_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q6_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q6_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q7_comment || $audit->finance_q7_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q7_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q7_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q7_answer === 1 && $audit->finance_q7_comment || $audit->finance_q7_answer === 3 && $audit->finance_q7_comment)
                        <h4>Have CMS policies been distributed to management and relevant employees?</h4>
                    @elseif($audit->finance_q7_answer === 2)
                        <h4>The CMS policies have not been distributed to management and relevant employees.</h4>
                    @endif
                    @if($audit->finance_q7_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q6_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q7_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q7_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q8_comment || $audit->finance_q8_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q8_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q8_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q8_answer === 1 && $audit->finance_q8_comment || $audit->finance_q8_answer === 3 && $audit->finance_q8_comment)
                        <h4>Have employees and management acknowledged receipt of the above?</h4>
                    @elseif($audit->finance_q8_answer === 2)
                        <h4>The employees and management have not acknowledged receipt of the above.</h4>
                    @endif
                    @if($audit->finance_q8_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q8_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q8_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q8_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q9_comment || $audit->finance_q9_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q9_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q9_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q9_answer === 1 && $audit->finance_q9_comment || $audit->finance_q9_answer === 3 && $audit->finance_q9_comment)
                        <h4>Are employees and management completing training on a consistent basis?</h4>
                    @elseif($audit->finance_q9_answer === 2)
                        <h4>The employees and management are not completing training on a consistent basis.</h4>
                    @endif
                    @if($audit->finance_q9_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q9_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q9_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q9_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q10_comment || $audit->finance_q10_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q10_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q10_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q10_answer === 1 && $audit->finance_q10_comment || $audit->finance_q10_answer === 3 && $audit->finance_q10_comment)
                        <h4>Are there policies and procedures in place to handle and respond to consumer
                            complaints?</h4>
                    @elseif($audit->finance_q10_answer === 2)
                        <h4>There are no policies and procedures in place to handle and respond to consumer
                            complaints.</h4>
                    @endif
                    @if($audit->finance_q10_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q10_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q10_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q10_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q11_comment || $audit->finance_q11_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q11_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q11_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q11_answer === 1 && $audit->finance_q11_comment || $audit->finance_q11_answer === 3 && $audit->finance_q11_comment)
                        <h4>Are NPI/customer records being destroyed/shredded properly?</h4>
                    @elseif($audit->finance_q11_answer === 2)
                        <h4>NPI/customer records are not being destroyed/shredded properly.</h4>
                    @endif
                    @if($audit->finance_q11_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q11_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q11_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q11_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q12_comment || $audit->finance_q12_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q12_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q12_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q12_answer === 1 && $audit->finance_q12_comment || $audit->finance_q12_answer === 3 && $audit->finance_q12_comment)
                        <h4>Is the OFAC/SDN listings being completed on all contracted deals?</h4>
                    @elseif($audit->finance_q12_answer === 2)
                        <h4>The OFAC/SDN listings not being completed on all contracted deals.</h4>
                    @endif
                    @if($audit->finance_q12_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q12_answer === 2)
                        <p>U.S. Department of the Treasury’s Office of Foreign Assets Control (OFAC)
                            administers and enforces U.S. economic and trade sanctions programs against
                            targeted foreign governments, individuals, groups, and entities in accordance
                            with national security and foreign policy goals and objectives</p>
                    @endif
                    @if($audit->finance_q12_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q12_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q13_comment || $audit->finance_q13_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q13_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q13_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q13_answer === 1 && $audit->finance_q13_comment || $audit->finance_q13_answer === 3 && $audit->finance_q13_comment)
                        <h4>Are all new employees signing dealerships security policy statement?</h4>
                    @elseif($audit->finance_q13_answer === 2)
                        <h4>All new employees are not signing the dealerships security policy statement.</h4>
                    @endif
                    @if($audit->finance_q13_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q13_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q13_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q13_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q14_comment || $audit->finance_q14_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q14_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q14_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q14_answer === 1 && $audit->finance_q14_comment || $audit->finance_q14_answer === 3 && $audit->finance_q14_comment)
                        <h4>Are computer terminals being logged off to activate screensaver password?</h4>
                    @elseif($audit->finance_q14_answer === 2)
                        <h4>The computer terminals are not being logged off to activate screensaver password.</h4>
                    @endif
                    @if($audit->finance_q14_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q14_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q14_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q14_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q15_comment || $audit->finance_q15_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q15_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q15_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q15_answer === 1 && $audit->finance_q15_comment || $audit->finance_q15_answer === 3 && $audit->finance_q15_comment)
                        <h4>Are repair orders (RO’s) being disposed/shredded properly?</h4>
                    @elseif($audit->finance_q15_answer === 2)
                        <h4>The repair orders (RO’s) are not being disposed/shredded properly.</h4>
                    @endif
                    @if($audit->finance_q15_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q15_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q15_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q15_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q16_comment || $audit->finance_q16_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q16_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q16_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q16_answer === 1 && $audit->finance_q16_comment || $audit->finance_q16_answer === 3 && $audit->finance_q16_comment)
                        <h4>Is the privacy notice clearly stated on dealership's website?</h4>
                    @elseif($audit->finance_q16_answer === 2)
                        <h4>The privacy notice is not clearly stated on dealership's website.</h4>
                    @endif
                    @if($audit->finance_q16_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q16_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q16_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q16_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q17_comment || $audit->finance_q17_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q17_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q17_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q17_answer === 1 && $audit->finance_q17_comment || $audit->finance_q17_answer === 3 && $audit->finance_q17_comment)
                        <h4>"NPI Check-Out Log" being utilized in accounting.</h4>
                    @elseif($audit->finance_q17_answer === 2)
                        <h4>"NPI Check-Out Log" is not being utilized in accounting.</h4>
                    @endif
                    @if($audit->finance_q17_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q17_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q17_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q17_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q18_comment || $audit->finance_q18_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q18_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q18_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q18_answer === 1 && $audit->finance_q18_comment || $audit->finance_q18_answer === 3 && $audit->finance_q18_comment)
                        <h4>Are all computer terminals automatically set to log off after 5 minutes of
                            non-activity?</h4>
                    @elseif($audit->finance_q18_answer === 2)
                        <h4>All computer terminals are not automatically set to log off after 5 minutes of
                            non-activity.</h4>
                    @endif
                    @if($audit->finance_q18_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q18_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q18_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q18_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q19_comment || $audit->finance_q19_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q19_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q19_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q19_answer === 1 && $audit->finance_q19_comment || $audit->finance_q19_answer === 3 && $audit->finance_q19_comment)
                        <h4>Are network firewalls being monitored for intrusion?</h4>
                    @elseif($audit->finance_q19_answer === 2)
                        <h4>The network firewalls are not being monitored for intrusion.</h4>
                    @endif
                    @if($audit->finance_q19_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q19_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q19_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q19_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q20_comment || $audit->finance_q20_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q20_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q20_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q20_answer === 1 && $audit->finance_q20_comment || $audit->finance_q20_answer === 3 && $audit->finance_q20_comment)
                        <h4>Written IT policies regarding the use of flash drives, downloading software and
                            programs by employees, and spam email protocols?</h4>
                    @elseif($audit->finance_q20_answer === 2)
                        <h4>No written IT policies regarding the use of flash drives, downloading software and
                            programs by employees, and spam email protocols.</h4>
                    @endif
                    @if($audit->finance_q20_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q20_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q20_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q20_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q21_comment || $audit->finance_q21_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q21_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q21_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q21_answer === 1 && $audit->finance_q21_comment || $audit->finance_q21_answer === 3 && $audit->finance_q21_comment)
                        <h4>Have there been any network intrusions or security breaches since last quarterly?</h4>
                    @elseif($audit->finance_q21_answer === 2)
                        <h4>There have been network intrusions or security breaches since last quarterly.</h4>
                    @endif
                    @if($audit->finance_q21_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q21_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q21_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q21_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q22_comment || $audit->finance_q22_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q22_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q22_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q22_answer === 1 && $audit->finance_q22_comment || $audit->finance_q22_answer === 3 && $audit->finance_q22_comment)
                        <h4>IT Technical requirements been implemented for Encryption, MFA and System
                            monitoring, penetration testing, and vulnerability assessments?</h4>
                    @elseif($audit->finance_q22_answer === 2)
                        <h4>No IT Technical requirements have been implemented for Encryption, MFA and System
                            monitoring, penetration testing, and vulnerability assessments.</h4>
                    @endif
                    @if($audit->finance_q22_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q22_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q22_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q22_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q23_comment || $audit->finance_q23_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q23_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q23_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q23_answer === 1 && $audit->finance_q23_comment || $audit->finance_q23_answer === 3 && $audit->finance_q23_comment)
                        <h4>Cashiers area unsecured?</h4>
                    @elseif($audit->finance_q23_answer === 2)
                        <h4>Cashiers area unsecured.</h4>
                    @endif
                    @if($audit->finance_q23_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q22_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q23_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q23_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q24_comment || $audit->finance_q24_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q24_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q24_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q24_answer === 1 && $audit->finance_q24_comment || $audit->finance_q24_answer === 3 && $audit->finance_q24_comment)
                        <h4>Are there any new Third Party Service Provider companies that need to be sent
                            acknowledgements and assessment report?</h4>
                    @elseif($audit->finance_q24_answer === 2)
                        <h4>There are new Third Party Service Provider companies that need to be sent acknowledgements
                            and assessment report.</h4>
                    @endif
                    @if($audit->finance_q24_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q24_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q24_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q24_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q25_comment || $audit->finance_q25_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q25_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q25_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q25_answer === 1 && $audit->finance_q25_comment || $audit->finance_q25_answer === 3 && $audit->finance_q25_comment)
                        <h4>Have Third Party Providers been vetted for required compliance practices,
                            procedures and training?</h4>
                    @elseif($audit->finance_q25_answer === 2)
                        <h4>Third Party Providers have not been vetted for required compliance practices,
                            procedures and training.</h4>
                    @endif
                    @if($audit->finance_q25_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q25_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q25_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q25_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q26_comment || $audit->finance_q26_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q26_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q26_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q26_answer === 1 && $audit->finance_q26_comment || $audit->finance_q26_answer === 3 && $audit->finance_q26_comment)
                        <h4>Are sales desk drawers/file cabinets locked and secured?</h4>
                    @elseif($audit->finance_q26_answer === 2)
                        <h4>Sales desk drawers/file cabinets are not locked and secured.</h4>
                    @endif
                    @if($audit->finance_q26_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q26_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q26_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q26_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q27_comment || $audit->finance_q27_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q27_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q27_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q27_answer === 1 && $audit->finance_q27_comment || $audit->finance_q27_answer === 3 && $audit->finance_q27_comment)
                        <h4>Any NPI/customer documents being left out on sales desks?</h4>
                    @elseif($audit->finance_q27_answer === 2)
                        <h4>NPI/customer documents are being left out on sales desks.</h4>
                    @endif
                    @if($audit->finance_q27_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q27_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q27_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q27_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q28_comment || $audit->finance_q28_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q28_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q28_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q28_answer === 1 && $audit->finance_q28_comment || $audit->finance_q28_answer === 3 && $audit->finance_q28_comment)
                        <h4>Is CAN SPAM process in place?</h4>
                    @elseif($audit->finance_q28_answer === 2)
                        <h4>CAN SPAM process in not place.</h4>
                    @endif
                    @if($audit->finance_q28_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q28_answer === 2)
                        <p>CAN-SPAM Act, a law that sets the rules for commercial email, establishes
                            requirements for commercial messages, gives recipients the right to have you
                            stop emailing them, and spells out tough penalties for violations.
                        </p>
                    @endif
                    @if($audit->finance_q28_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q28_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q29_comment || $audit->finance_q29_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q29_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q29_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q29_answer === 1 && $audit->finance_q29_comment || $audit->finance_q29_answer === 3 && $audit->finance_q29_comment)
                        <h4>Is the Telemarketing “Do Not Call” rule being complied with?</h4>
                    @elseif($audit->finance_q29_answer === 2)
                        <h4>The Telemarketing “Do Not Call” rule is not being complied with.</h4>
                    @endif
                    @if($audit->finance_q29_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q29_answer === 2)
                        <p>FTC – National “Do not Call Registry” guidelines</p>
                    @endif
                    @if($audit->finance_q29_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q29_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q30_comment || $audit->finance_q30_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q30_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q30_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q30_answer === 1 && $audit->finance_q30_comment || $audit->finance_q30_answer === 3 && $audit->finance_q30_comment)
                        <h4>Any other NPI documents publicly exposed, not secured properly?</h4>
                    @elseif($audit->finance_q30_answer === 2)
                        <h4>Other NPI documents are publicly exposed, and not secured properly.</h4>
                    @endif
                    @if($audit->finance_q30_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q30_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q30_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q30_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q31_comment || $audit->finance_q31_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q31_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q31_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q31_answer === 1 && $audit->finance_q31_comment || $audit->finance_q31_answer === 3 && $audit->finance_q31_comment)
                        <h4>Breach in password sharing?</h4>
                    @elseif($audit->finance_q31_answer === 2)
                        <h4>There is a breach in password sharing.</h4>
                    @endif
                    @if($audit->finance_q31_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q31_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q31_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q31_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q32_comment || $audit->finance_q32_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q32_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q32_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q32_answer === 1 && $audit->finance_q32_comment || $audit->finance_q32_answer === 3 && $audit->finance_q32_comment)
                        <h4>Customers NPI in unsecured trash cans?</h4>
                    @elseif($audit->finance_q32_answer === 2)
                        <h4>Customers NPI are in unsecured trash cans.</h4>
                    @endif
                    @if($audit->finance_q32_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q32_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q32_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q32_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q33_comment || $audit->finance_q33_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q33_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q33_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q33_answer === 1 && $audit->finance_q33_comment || $audit->finance_q33_answer === 3 && $audit->finance_q33_comment)
                        <h4>Deal jackets unsecured?</h4>
                    @elseif($audit->finance_q33_answer === 2)
                        <h4>Deal jackets are unsecured.</h4>
                    @endif
                    @if($audit->finance_q33_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q33_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q33_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q33_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q34_comment || $audit->finance_q34_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q34_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q34_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q34_answer === 1 && $audit->finance_q34_comment || $audit->finance_q34_answer === 3 && $audit->finance_q34_comment)
                        <h4>Filing cabinets securing customers NPI locked and secured?</h4>
                    @elseif($audit->finance_q34_answer === 2)
                        <h4>Filing cabinets securing customers NPI are not locked and secured.</h4>
                    @endif
                    @if($audit->finance_q34_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q34_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q34_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q34_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q35_comment || $audit->finance_q35_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q35_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q35_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q35_answer === 1 && $audit->finance_q35_comment || $audit->finance_q35_answer === 3 && $audit->finance_q35_comment)
                        <h4>Sales Tower area has NPI exposure, unsecured customer documents?</h4>
                    @elseif($audit->finance_q35_answer === 2)
                        <h4>Sales Tower area has NPI exposure, unsecured customer documents.</h4>
                    @endif
                    @if($audit->finance_q35_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q35_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q35_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q35_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q36_comment || $audit->finance_q36_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q36_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q36_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q36_answer === 1 && $audit->finance_q36_comment || $audit->finance_q36_answer === 3 && $audit->finance_q36_comment)
                        <h4>Was Network Vulnerability Assessment Report completed, denote possible issues?</h4>
                    @elseif($audit->finance_q36_answer === 2)
                        <h4>The Network Vulnerability Assessment Report has not been completed, denote possible
                            issues.</h4>
                    @endif
                    @if($audit->finance_q36_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q36_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q36_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q36_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q37_comment || $audit->finance_q37_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q37_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q37_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q37_answer === 1 && $audit->finance_q37_comment || $audit->finance_q37_answer === 3 && $audit->finance_q37_comment)
                        <h4>Are finance offices locked and secured when employee not present?</h4>
                    @elseif($audit->finance_q37_answer === 2)
                        <h4>The finance offices are not locked and secured when employee not present.</h4>
                    @endif
                    @if($audit->finance_q37_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q37_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q37_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q37_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q38_comment || $audit->finance_q38_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q38_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q38_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q38_answer === 1 && $audit->finance_q38_comment || $audit->finance_q38_answer === 3 && $audit->finance_q38_comment)
                        <h4>Are credit applications secured?</h4>
                    @elseif($audit->finance_q38_answer === 2)
                        <h4>Credit applications are not secured.</h4>
                    @endif
                    @if($audit->finance_q38_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q38_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q38_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q38_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q39_comment || $audit->finance_q39_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q39_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q39_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q39_answer === 1 && $audit->finance_q39_comment || $audit->finance_q39_answer === 3 && $audit->finance_q39_comment)
                        <h4>Red Flag software being utilized to check for fraudulent applicants?</h4>
                    @elseif($audit->finance_q39_answer === 2)
                        <h4>Red Flag software is not being utilized to check for fraudulent applicants.</h4>
                    @endif
                    @if($audit->finance_q39_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q39_answer === 2)
                        <p>Red Flags Rule
                            Sometimes it’s referred to as one of the Fair Credit Reporting Act’s Identity
                            Theft Rules and it appears in the Code of Federal Regulations as “Detection,
                            Prevention, and Mitigation of Identity Theft.” The Red Flags Rule requires many
                            businesses and organizations to implement a written Identity Theft Prevention
                            Program designed to detect the warning signs – or red flags – of identity theft
                            in their day-to-day operations.</p>
                    @endif
                    @if($audit->finance_q39_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q39_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q40_comment || $audit->finance_q40_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q40_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q40_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q40_answer === 1 && $audit->finance_q40_comment || $audit->finance_q40_answer === 3 && $audit->finance_q40_comment)
                        <h4>Are managers’ offices locked and secured when not present?</h4>
                    @elseif($audit->finance_q40_answer === 2)
                        <h4>The managers’ offices are not locked and secured when not present.</h4>
                    @endif
                    @if($audit->finance_q40_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q40_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q40_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q40_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q41_comment || $audit->finance_q41_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q41_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q41_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q41_answer === 1 && $audit->finance_q41_comment || $audit->finance_q41_answer === 3 && $audit->finance_q41_comment)
                        <h4>Are the sales Showroom doors secured prior to sales staff reporting to work?</h4>
                    @elseif($audit->finance_q41_answer === 2)
                        <h4>The sales Showroom doors are not secured prior to sales staff reporting to work.</h4>
                    @endif
                    @if($audit->finance_q41_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q41_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q41_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q41_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q42_comment || $audit->finance_q42_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q42_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q42_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q42_answer === 1 && $audit->finance_q42_comment || $audit->finance_q42_answer === 3 && $audit->finance_q42_comment)
                        <h4>Are Buyers Guide properly displayed in a fully visible on all used cars?</h4>
                    @elseif($audit->finance_q42_answer === 2)
                        <h4>The Buyers Guide is not properly displayed in a fully visible on all used cars.</h4>
                    @endif
                    @if($audit->finance_q42_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q42_answer === 2)
                        <p>16 CFR Part 455
                            Rule Summary
                            The Used Car Rule, formally known as the Used Motor Vehicle Trade Regulation
                            Rule, has been in effect since 1985. It requires car dealers to display a window
                            sticker, known as a Buyer’s Guide, on the used cars they offer for sale.
                        </p>
                    @endif
                    @if($audit->finance_q42_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q42_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q43_comment || $audit->finance_q43_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q43_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q43_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q43_answer === 1 && $audit->finance_q43_comment || $audit->finance_q43_answer === 3 && $audit->finance_q43_comment)
                        <h4>Are Buyers Guides filled out properly?</h4>
                    @elseif($audit->finance_q43_answer === 2)
                        <h4>The Buyers Guides are not filled out properly.</h4>
                    @endif
                    @if($audit->finance_q43_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q43_answer === 2)
                        <p>16 CFR Part 455
                            Rule Summary
                            The Used Car Rule, formally known as the Used Motor Vehicle Trade Regulation
                            Rule, has been in effect since 1985. It requires car dealers to display a window
                            sticker, known as a Buyer’s Guide, on the used cars they offer for sale.</p>
                    @endif
                    @if($audit->finance_q43_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q43_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q44_comment || $audit->finance_q44_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q44_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q44_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q44_answer === 1 && $audit->finance_q44_comment || $audit->finance_q44_answer === 3 && $audit->finance_q44_comment)
                        <h4>New car missing Monroney sticker placement?</h4>
                    @elseif($audit->finance_q44_answer === 2)
                        <h4>New car is missing the Monroney sticker placement.</h4>
                    @endif
                    @if($audit->finance_q44_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q44_answer === 2)
                        <p>A Monroney Label is a reproduction of the original factory window sticker. U.S.
                            law requires a window sticker, known as a Monroney label, to be displayed on all
                            new cars. These stickers contain mandatory information about the car</p>
                    @endif
                    @if($audit->finance_q44_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q44_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q45_comment || $audit->finance_q45_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q45_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q45_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q45_answer === 1 && $audit->finance_q45_comment || $audit->finance_q45_answer === 3 && $audit->finance_q45_comment)
                        <h4>Are the finance terms properly displayed on vehicle inventory?</h4>
                    @elseif($audit->finance_q45_answer === 2)
                        <h4>The finance terms are not properly displayed on vehicle inventory.</h4>
                    @endif
                    @if($audit->finance_q45_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q45_answer === 2)
                        <p>CFBP - § 1026.24 Advertising
                            (i)The amount or percentage of any downpayment.
                            (ii)The number of payments or period of repayment.
                            (iii)The amount of any payment.
                            (iv)The amount of any finance charge.</p>
                    @endif
                    @if($audit->finance_q45_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q45_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q46_comment || $audit->finance_q46_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('finance_q46_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('finance_q46_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->finance_q46_answer === 1 && $audit->finance_q46_comment || $audit->finance_q46_answer === 3 && $audit->finance_q46_comment)
                        <h4>Is the sales bull pin area (if present) secured properly?</h4>
                    @elseif($audit->finance_q46_answer === 2)
                        <h4>The sales bull pin area (if present) is not secured properly?</h4>
                    @endif
                    @if($audit->finance_q46_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->finance_q46_answer === 2)
                        <p>GLBA Standard FTC Standard Safeguards Rule under section 501 (b)</p>
                    @endif
                    @if($audit->finance_q46_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->finance_q46_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->finance_q47_comment)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                </div>
                <div class="col-span-5">
                    <h4>Additional issue/violation found during the sales &amp; finance walk-thru audit.</h4>
                    <p>{{ $audit->finance_q47_comment }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
