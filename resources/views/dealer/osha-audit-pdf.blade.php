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
<div class="w-full h-screen bg-gray-50 grid grid-cols-8 grid-rows-6">
    <div class="col-span-3 col-start-1 p-20">
        <x-application-logo class="h-auto w-full"/>
    </div>
    <div class="col-span-5 row-span-4 col-start-1 row-start-2 bg-arm-blue-500 z-10 py-10 pr-10">
        <div class="w-full h-full flex flex-row items-center border-t border-r border-b border-white ">
            <div class="flex flex-col ml-10">
                <h1 class="text-7xl text-white">OSHA Report<span
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
        @if($audit->osha_q1_comment || $audit->osha_q1_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if($audit->getFirstMedia('osha_q1_images') != null)
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q1_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q1_answer === 1 && $audit->osha_q1_comment || $audit->osha_q1_answer === 3 && $audit->osha_q1_comment)
                        <h4>Oil Manifest</h4>
                    @elseif($audit->osha_q1_answer === 2)
                        <h4>Oil Manifest not available</h4>
                    @endif
                    @if($audit->osha_q1_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q1_answer === 2)
                        <p>262.40 Recordkeeping.</p>
                    @endif
                    @if($audit->osha_q1_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q1_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q2_comment || $audit->osha_q2_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q2_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q2_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q2_answer === 1 && $audit->osha_q2_comment || $audit->osha_q2_answer === 3 && $audit->osha_q2_comment)
                        <h4>Battery Manifest</h4>
                    @elseif($audit->osha_q2_answer === 2)
                        <h4>Battery Manifest not available</h4>
                    @endif
                    @if($audit->osha_q2_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q2_answer === 2)
                        <p>Federal Code of Regulations 40 CFR part 273. Subpart G - Spent Lead-Acid
                            Batteries Being Reclaimed
                            § 266.80 Applicability and requirements.</p>
                    @endif
                    @if($audit->osha_q2_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q2_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q3_comment || $audit->osha_q3_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q3_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q3_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q3_answer === 1 && $audit->osha_q3_comment || $audit->osha_q3_answer === 3 && $audit->osha_q3_comment)
                        <h4>Tire Manifests</h4>
                    @elseif($audit->osha_q3_answer === 2)
                        <h4>Tire Manifests not available</h4>
                    @endif
                    @if($audit->osha_q3_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q3_answer === 2)
                        <p>Maintain copies of all tire manifest</p>
                    @endif
                    @if($audit->osha_q3_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q3_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q4_comment || $audit->osha_q4_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q4_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q4_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q4_answer === 1 && $audit->osha_q4_comment || $audit->osha_q4_answer === 3 && $audit->osha_q4_comment)
                        <h4>Forklift Operators Certifications</h4>
                    @elseif($audit->osha_q4_answer === 2)
                        <h4>Forklift Operators Certifications not available</h4>
                    @endif
                    @if($audit->osha_q4_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q4_answer === 2)
                        <p>CFR 1910.178(l)(2)(ii) – Training requirements</p>
                    @endif
                    @if($audit->osha_q4_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q4_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q5_comment || $audit->osha_q5_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q5_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q5_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q5_answer === 1 && $audit->osha_q5_comment || $audit->osha_q5_answer === 3 && $audit->osha_q5_comment)
                        <h4>Is the OSHA 300 & 300A being completed on an on-going basis and electronically filed?</h4>
                    @elseif($audit->osha_q5_answer === 2)
                        <h4>The OSHA 300 & 300A are not being completed on an on-going basis and electronically
                            filed.</h4>
                    @endif
                    @if($audit->osha_q5_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q5_answer === 2)
                        <p>1904.41 Electronic submission of
                            Employer Identification Number
                            (EIN) and injury and illness records
                            to OSHA.</p>
                    @endif
                    @if($audit->osha_q5_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q5_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q6_comment || $audit->osha_q6_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q6_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q6_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q6_answer === 1 && $audit->osha_q6_comment || $audit->osha_q6_answer === 3 && $audit->osha_q6_comment)
                        <h4>SPCC filing</h4>
                    @elseif($audit->osha_q6_answer === 2)
                        <h4>SPCC not filed</h4>
                    @endif
                    @if($audit->osha_q6_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q6_answer === 2)
                        <p>Federal Code of Regulations 40
                            CFR, 112. Self-certification is
                            allowed but a full SPCC plan is
                            required: an owner or operator may
                            self-certify a spill plan in
                            accordance with requirements of 40
                            CFR, 112.7, in lieu of a professional
                            engineer certified plan. If there are
                            10,000 gallons of liquid storage
                            capacity, your plan must be
                            prepared and certified by a
                            registered professional engineer
                            (PE).</p>
                    @endif
                    @if($audit->osha_q6_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q6_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q7_comment || $audit->osha_q7_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q7_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q7_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q7_answer === 1 && $audit->osha_q7_comment || $audit->osha_q7_answer === 3 && $audit->osha_q7_comment)
                        <h4>Are any other local and state EPA filings uploaded to the dealership dashboard?</h4>
                    @elseif($audit->osha_q7_answer === 2)
                        <h4>No other local and state EPA filings uploaded to the dealership dashboard.</h4>
                    @endif
                    @if($audit->osha_q7_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q7_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q7_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q8_comment || $audit->osha_q8_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q8_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q8_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q8_answer === 1 && $audit->osha_q8_comment || $audit->osha_q8_answer === 3 && $audit->osha_q8_comment)
                        <h4>Do all employees know how to access SDS’s?</h4>
                    @elseif($audit->osha_q8_answer === 2)
                        <h4>All employees do not know how to access SDS’s.</h4>
                    @endif
                    @if($audit->osha_q8_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q8_answer === 2)
                        <p>HCS 1910.1200 App E
                            Each employee who may be
                            &quot;exposed&quot; to hazardous chemicals
                            when working must be provided
                            information and trained prior to initial assignment to work with a
                            hazardous chemical, and whenever
                            the hazard changes.</p>
                    @endif
                    @if($audit->osha_q8_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q8_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q9_comment || $audit->osha_q9_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q9_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q9_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q9_answer === 1 && $audit->osha_q9_comment || $audit->osha_q9_answer === 3 && $audit->osha_q9_comment)
                        <h4>All employees have been exposure free from any chemicals in the dealership?</h4>
                    @elseif($audit->osha_q9_answer === 2)
                        <h4>All employees have not been exposure free from any chemicals in the dealership.</h4>
                    @endif
                    @if($audit->osha_q9_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q9_answer === 2)
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
                    @endif
                    @if($audit->osha_q9_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q9_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q10_comment || $audit->osha_q10_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q10_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q10_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q10_answer === 1 && $audit->osha_q10_comment || $audit->osha_q10_answer === 3 && $audit->osha_q10_comment)
                        <h4>Are all secondary containers filled with chemicals properly labeled?</h4>
                    @elseif($audit->osha_q10_answer === 2)
                        <h4>All secondary containers filled with chemicals are not properly labeled.</h4>
                    @endif
                    @if($audit->osha_q10_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q10_answer === 2)
                        <p>HCS – 29 CFR 1910.1200(f)(9) –
                            Transferring Chemicals in
                            containers - The employer shall
                            ensure that labels or other forms of
                            warning are legible, in English, and
                            prominently displayed on the
                            container, or readily available in the
                            work area throughout each work
                            shift.</p>
                    @endif
                    @if($audit->osha_q10_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q10_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q11_comment || $audit->osha_q11_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q11_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q11_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q11_answer === 1 && $audit->osha_q11_comment || $audit->osha_q11_answer === 3 && $audit->osha_q11_comment)
                        <h4>Is the dealership accident free since the last audit?</h4>
                    @elseif($audit->osha_q11_answer === 2)
                        <h4>The dealership is not accident free since the last audit.</h4>
                    @endif
                    @if($audit->osha_q11_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q11_answer === 2)
                        <p>Reference current OSHA 300
                            log for details if needed</p>
                    @endif
                    @if($audit->osha_q11_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q11_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q12_comment || $audit->osha_q12_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q12_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q12_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q12_answer === 1 && $audit->osha_q12_comment || $audit->osha_q12_answer === 3 && $audit->osha_q12_comment)
                        <h4>Is the eye wash equipment readily accessible?</h4>
                    @elseif($audit->osha_q12_answer === 2)
                        <h4>The eye wash equipment is not readily accessible.</h4>
                    @endif
                    @if($audit->osha_q12_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q12_answer === 2)
                        <p>ANSI Z358.1-2014 - The ANSI
                            standard states that all flushing
                            equipment must be located in areas that are accessible within 10
                            seconds (roughly 55 feet).
                            The Safety Showers and or Eyewash
                            Stations must be located on the
                            same level as the hazard and the
                            path of travel shall be free from
                            obstructions.</p>
                    @endif
                    @if($audit->osha_q12_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q12_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q13_comment || $audit->osha_q13_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q13_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q13_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q13_answer === 1 && $audit->osha_q13_comment || $audit->osha_q13_answer === 3 && $audit->osha_q13_comment)
                        <h4>Has the eye wash equipment been tested and cleaned and documented weekly?</h4>
                    @elseif($audit->osha_q13_answer === 2)
                        <h4>The eye wash equipment has not been tested and cleaned and documented weekly.</h4>
                    @endif
                    @if($audit->osha_q13_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q13_answer === 2)
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
                    @endif
                    @if($audit->osha_q13_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q13_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q14_comment || $audit->osha_q14_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q14_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q14_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q14_answer === 1 && $audit->osha_q14_comment || $audit->osha_q14_answer === 3 && $audit->osha_q14_comment)
                        <h4>Has the eye wash container water supply been changed out properly based on
                            manufacturer recommendations per solution used?</h4>
                    @elseif($audit->osha_q14_answer === 2)
                        <h4>The eye wash container water supply has not been changed out properly based on
                            manufacturer recommendations per solution used.</h4>
                    @endif
                    @if($audit->osha_q14_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q14_answer === 2)
                        <p>29 CFR 1910.151 - Dealership is to
                            follow manufacturing guidelines for
                            water exchange, i.e., change every
                            90 days with new sanitizer packs
                            also added. Initial/date sign off tag
                            on side of unit.</p>
                    @endif
                    @if($audit->osha_q14_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q14_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q15_comment || $audit->osha_q15_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q15_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q15_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q15_answer === 1 && $audit->osha_q15_comment || $audit->osha_q15_answer === 3 && $audit->osha_q15_comment)
                        <h4>DOT certification - Is the person
                            responsible for Hazardous material
                            shipping current on his/her?</h4>
                    @elseif($audit->osha_q15_answer === 2)
                        <h4>DOT certification - The person
                            responsible for Hazardous material
                            shipping is not current.</h4>
                    @endif
                    @if($audit->osha_q15_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q15_answer === 2)
                        <p>49 CFR § 172.704
                            Recurrent training. A hazmat employee
                            shall receive the training required
                            by this subpart at least once every
                            three years. (list employees certified or
                            not certified)</p>
                    @endif
                    @if($audit->osha_q15_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q15_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q16_comment || $audit->osha_q16_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q16_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q16_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q16_answer === 1 && $audit->osha_q16_comment || $audit->osha_q16_answer === 3 && $audit->osha_q16_comment)
                        <h4>Are all the Fire Extinguishers easily accessible?</h4>
                    @elseif($audit->osha_q16_answer === 2)
                        <h4>All the Fire Extinguishers are not easily accessible.</h4>
                    @endif
                    @if($audit->osha_q16_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q16_answer === 2)
                        <p>29 CFR 1910.157(d)(2)
                            The employer shall distribute portable fire extinguishers for use by employees
                            on Class A fires so that the travel distance for employees to any extinguisher is 75 ft.</p>
                    @endif
                    @if($audit->osha_q16_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q16_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q17_comment || $audit->osha_q17_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q17_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q17_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q17_answer === 1 && $audit->osha_q17_comment || $audit->osha_q17_answer === 3 && $audit->osha_q17_comment)
                        <h4>Have the fire extinguishers had their annual inspection and are they properly
                            identified and fully charged?</h4>
                    @elseif($audit->osha_q17_answer === 2)
                        <h4>The fire extinguishers have not had their annual inspection and are not properly
                            identified and fully charged.</h4>
                    @endif
                    @if($audit->osha_q17_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q17_answer === 2)
                        <p>29 CFR 1910.157(e)(3)
                            The employer shall assure that portable fire extinguishers are subjected to an
                            annual maintenance check. Stored pressure extinguishers do not require an
                            internal
                            examination. The employer shall record the annual maintenance date and retain
                            this
                            record for one year after the last entry or the life of the shell, whichever is
                            less.</p>
                    @endif
                    @if($audit->osha_q17_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q17_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q18_comment || $audit->osha_q18_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q18_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q18_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q18_answer === 1 && $audit->osha_q18_comment || $audit->osha_q18_answer === 3 && $audit->osha_q18_comment)
                        <h4>Are extinguishers mounted properly? (36”-60”)</h4>
                    @elseif($audit->osha_q18_answer === 2)
                        <h4>The extinguishers are not mounted properly. (36”-60”)</h4>
                    @endif
                    @if($audit->osha_q18_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q18_answer === 2)
                        <p>29 CFR 1910.157©(3)
                            Mounting; Height is between 36” to 60”
                            Accessibility is 20’” in front and sides
                        </p>
                    @endif
                    @if($audit->osha_q18_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q18_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q19_comment || $audit->osha_q19_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q19_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q19_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q19_answer === 1 && $audit->osha_q19_comment || $audit->osha_q19_answer === 3 && $audit->osha_q19_comment)
                        <h4>Are fire extinguisher signs above the unit posted properly?</h4>
                    @elseif($audit->osha_q19_answer === 2)
                        <h4>The fire extinguisher signs above the unit are not posted properly.</h4>
                    @endif
                    @if($audit->osha_q19_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q19_answer === 2)
                        <p>29 CFR 1910.157(d)(2) - The employer shall distribute portable fire extinguishers for
                            use by employees on Class A fires so that the travel distance for employees to
                            any extinguisher is 75 ft.
                            29 CFR 1910.157©(1) - Fire extinguishers and shall mount, locate and identify them
                            so that they are readily accessible to employees without subjecting the
                            employees to possible injury.</p>
                    @endif
                    @if($audit->osha_q19_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q19_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q20_comment || $audit->osha_q20_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q20_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q20_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q20_answer === 1 && $audit->osha_q20_comment || $audit->osha_q20_answer === 3 && $audit->osha_q20_comment)
                        <h4>Are all hoses and cutting tips for the welder / cutting torches in good
                            condition without any cracks or breaks?</h4>
                    @elseif($audit->osha_q20_answer === 2)
                        <h4>All hoses and cutting tips for the welder / cutting torches are not in good
                            condition without any cracks or breaks.</h4>
                    @endif
                    @if($audit->osha_q20_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q20_answer === 2)
                        <p>29 CFR 1910.252 / ANSI Z49.1 Safety in Welding, Cutting, and Allied
                            Processes.</p>
                    @endif
                    @if($audit->osha_q20_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q20_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q21_comment || $audit->osha_q21_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q21_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q21_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q21_answer === 1 && $audit->osha_q21_comment || $audit->osha_q21_answer === 3 && $audit->osha_q21_comment)
                        <h4>Do you have any forklift(s)?</h4>
                    @elseif($audit->osha_q21_answer === 2)
                        <h4>There are no forklifts.</h4>
                    @endif
                    @if($audit->osha_q21_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q21_answer === 2)
                        <p>29 CFR 1910.178(l)
                            Training Requirements – certified every 3 years
                        </p>
                    @endif
                    @if($audit->osha_q21_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q21_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q22_comment || $audit->osha_q22_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q22_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q22_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q22_answer === 1 && $audit->osha_q22_comment || $audit->osha_q22_answer === 3 && $audit->osha_q22_comment)
                        <h4>If you have a forklift, has the person(s) responsible for operating it been
                            properly trained on safety and signed off as such?</h4>
                    @elseif($audit->osha_q22_answer === 2)
                        <h4>The person(s) responsible for operating it have not been
                            properly trained on safety and signed off.</h4>
                    @endif
                    @if($audit->osha_q22_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q22_answer === 2)
                        <p>Training Requirements - 29 CFR 1910.178(l)(3)
                            29 CFR 1910.178(l)(4)(iii) – Every 3 years
                            ANSI B56.1-1969 - Safety Standard for Powered Industrial Trucks.</p>
                    @endif
                    @if($audit->osha_q22_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q22_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q23_comment || $audit->osha_q23_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q23_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q23_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q23_answer === 1 && $audit->osha_q23_comment || $audit->osha_q23_answer === 3 && $audit->osha_q23_comment)
                        <h4>Do you have forklift training certificates of completed training class(es)?</h4>
                    @elseif($audit->osha_q23_answer === 2)
                        <h4>Forklift training certificates of completed training class(es) are not available.</h4>
                    @endif
                    @if($audit->osha_q23_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q23_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q23_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q24_comment || $audit->osha_q24_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q24_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q24_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q24_answer === 1 && $audit->osha_q24_comment || $audit->osha_q24_answer === 3 && $audit->osha_q24_comment)
                        <h4>Do forklifts have a seat belt/safety harness?</h4>
                    @elseif($audit->osha_q24_answer === 2)
                        <h4>The forklifts do not have a seat belt/safety harness.</h4>
                    @endif
                    @if($audit->osha_q24_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q24_answer === 2)
                        <p>29 CFR 1910.178(l)(3)(i)(M)
                            Seat Belt Usage
                        </p>
                    @endif
                    @if($audit->osha_q24_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q24_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q25_comment || $audit->osha_q25_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q25_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q25_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q25_answer === 1 && $audit->osha_q25_comment || $audit->osha_q25_answer === 3 && $audit->osha_q25_comment)
                        <h4>Does the forklift have legible labels? i.e., ANSI, serial #, maximum lift capacity</h4>
                    @elseif($audit->osha_q25_answer === 2)
                        <h4>The forklift(s) does not have legible labels. i.e., ANSI, serial #, maximum lift
                            capacity</h4>
                    @endif
                    @if($audit->osha_q25_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q25_answer === 2)
                        <p>29 CFR 1910.178
                            ANSI B56.1
                            Requires industrial lift truck users to keep labels and name plates readable,
                            painters must not paint over these markings
                        </p>
                    @endif
                    @if($audit->osha_q25_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q25_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q26_comment || $audit->osha_q26_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q26_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q26_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q26_answer === 1 && $audit->osha_q26_comment || $audit->osha_q26_answer === 3 && $audit->osha_q26_comment)
                        <h4>Are all exits properly marked?</h4>
                    @elseif($audit->osha_q26_answer === 2)
                        <h4>All exits are not properly marked.</h4>
                    @endif
                    @if($audit->osha_q26_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q26_answer === 2)
                        <p>NFPA 101, Section 7.10.1.2</p>
                    @endif
                    @if($audit->osha_q26_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q26_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q27_comment || $audit->osha_q27_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q27_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q27_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q27_answer === 1 && $audit->osha_q27_comment || $audit->osha_q27_answer === 3 && $audit->osha_q27_comment)
                        <h4>Are pathways to exits clear of obstructions?</h4>
                    @elseif($audit->osha_q27_answer === 2)
                        <h4>The pathways to exits are not clear of obstructions.</h4>
                    @endif
                    @if($audit->osha_q27_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q27_answer === 2)
                        <p>NFPA 101 Life Safety Code 3.3.136
                            Means of Egress. A continuous and unobstructed way of travel from any point in a
                            building or structure to a public way consisting of three separate and distinct
                            parts:
                            (1) the exit access, (2) the exit, and (3) the exit discharge.
                        </p>
                    @endif
                    @if($audit->osha_q27_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q27_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q28_comment || $audit->osha_q28_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q28_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q28_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q28_answer === 1 && $audit->osha_q28_comment || $audit->osha_q28_answer === 3 && $audit->osha_q28_comment)
                        <h4>Are all aisles/pathways, stairways and landings free from obstructions?</h4>
                    @elseif($audit->osha_q28_answer === 2)
                        <h4>All aisles/pathways, stairways and landings are not free from obstructions.</h4>
                    @endif
                    @if($audit->osha_q28_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q28_answer === 2)
                        <p>Means of Egress - A continuous and unobstructed way of travel from any point in a
                            building or structure to a public way</p>
                    @endif
                    @if($audit->osha_q28_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q28_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q29_comment || $audit->osha_q29_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q29_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q29_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q29_answer === 1 && $audit->osha_q29_comment || $audit->osha_q29_answer === 3 && $audit->osha_q29_comment)
                        <h4>Are any doorways that are nonfunctioning or blocked marked by a sign stating “NO EXIT”?</h4>
                    @elseif($audit->osha_q29_answer === 2)
                        <h4>Doorways that are nonfunctioning or blocked are not marked by a sign stating “NO EXIT”.</h4>
                    @endif
                    @if($audit->osha_q29_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q29_answer === 2)
                        <p>NFPA 101, Section 7.10.8.3.1
                            All doors, passages or stairways that are neither an exit nor a way of exit
                            access—yet are likely to be mistaken for an exit—be identified with a “No Exit”
                            sign.
                        </p>
                    @endif
                    @if($audit->osha_q29_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q29_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q30_comment || $audit->osha_q30_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q30_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q30_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q30_answer === 1 && $audit->osha_q30_comment || $audit->osha_q30_answer === 3 && $audit->osha_q30_comment)
                        <h4>Are the shop areas kept clean and orderly?</h4>
                    @elseif($audit->osha_q30_answer === 2)
                        <h4>The shop areas are not kept clean and orderly.</h4>
                    @endif
                    @if($audit->osha_q30_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q30_answer === 2)
                        <p>General Duty Clause 29 U.S.C. § 654, 5(a)1: Each employer shall furnish to each of
                            his employees’ employment and a place of employment which are free from recognized
                            hazards that are causing or are likely to cause death or serious physical harm
                            to his employees."</p>
                    @endif
                    @if($audit->osha_q30_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q30_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q31_comment || $audit->osha_q31_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q31_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q31_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q31_answer === 1 && $audit->osha_q31_comment || $audit->osha_q31_answer === 3 && $audit->osha_q31_comment)
                        <h4>Are all flammable materials (oily shop rags) properly stored?</h4>
                    @elseif($audit->osha_q31_answer === 2)
                        <h4>All flammable materials (oily shop rags) are not properly stored.</h4>
                    @endif
                    @if($audit->osha_q31_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q31_answer === 2)
                        <p>29 CFR 1926.252(e) - Storage of Oily Rags.
                            All solvent waste, oily rags, and flammable liquids shall be kept in
                            fire-resistant
                            covered containers
                        </p>
                    @endif
                    @if($audit->osha_q31_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q31_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q32_comment || $audit->osha_q32_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q32_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q32_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q32_answer === 1 && $audit->osha_q32_comment || $audit->osha_q32_answer === 3 && $audit->osha_q32_comment)
                        <h4>Are floors in good repair and free from obstruction and debris and slippery conditions?</h4>
                    @elseif($audit->osha_q32_answer === 2)
                        <h4>The floors are not in good repair and free from obstruction and debris and slippery
                            conditions.</h4>
                    @endif
                    @if($audit->osha_q32_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q32_answer === 2)
                        <p>29 U.S.C. § 654, 5(a)1 - Each employer shall furnish to each of his employees’
                            employment and a place of employment which are free from recognized hazards that
                            are
                            causing or are likely to cause death or serious physical harm to his
                            employees."</p>
                    @endif
                    @if($audit->osha_q32_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q32_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q33_comment || $audit->osha_q33_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q33_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q33_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q33_answer === 1 && $audit->osha_q33_comment || $audit->osha_q33_answer === 3 && $audit->osha_q33_comment)
                        <h4>Are floor openings in excess of 2.25” wide covered with hinged flaps?</h4>
                    @elseif($audit->osha_q33_answer === 2)
                        <h4>The floor openings in excess of 2.25” wide are not covered with hinged flaps.</h4>
                    @endif
                    @if($audit->osha_q33_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q33_answer === 2)
                        <p>29 CFR 1910.23
                            Every floor hole into which persons can accidentally walk must be guarded by
                            either:
                            • A standard railing with standard toe board on all exposed sides, or
                            • A floor hole cover of standard strength and construction. (While the cover is
                            not in place, the floor hole must be constantly attended by someone or must be
                            protected by a removable standard railing.)
                            A cover that leaves no openings more than 1 inch wide must protect every floor
                            hole into which persons cannot accidentally walk (because fixed machinery, equipment
                            or walls). The cover must be securely held in place to prevent tools or materials
                            from falling through.
                        </p>
                    @endif
                    @if($audit->osha_q33_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q33_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q34_comment || $audit->osha_q34_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q34_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q34_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q34_answer === 1 && $audit->osha_q34_comment || $audit->osha_q34_answer === 3 && $audit->osha_q34_comment)
                        <h4>Are employees properly maintaining their hoist controls and not bypassing any
                            automatic safety features?</h4>
                    @elseif($audit->osha_q34_answer === 2)
                        <h4>Employees are not properly maintaining their hoist controls or bypassing any
                            automatic safety features.</h4>
                    @endif
                    @if($audit->osha_q34_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q34_answer === 2)
                        <p>OSHA General Duty Clause
                            29 U.S.C. § 654, 5(a)1
                            ANSI/ALI ALCTV (current edition)</p>
                    @endif
                    @if($audit->osha_q34_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q34_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q35_comment || $audit->osha_q35_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q35_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q35_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q35_answer === 1 && $audit->osha_q35_comment || $audit->osha_q35_answer === 3 && $audit->osha_q35_comment)
                        <h4>Are hoists maintained within mfg. specs, and inspected and serviced AND
                            documented under the mfg. suggested frequency? Usually annually.</h4>
                    @elseif($audit->osha_q35_answer === 2)
                        <h4>Hoists are not being maintained within mfg. specs, and inspected and serviced AND
                            documented under the mfg. suggested frequency. Usually annually.</h4>
                    @endif
                    @if($audit->osha_q35_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q35_answer === 2)
                        <p>OSHA General Duty Clause
                            29 U.S.C. § 654, 5(a)1
                            ANSI/ALI ALCTV (current edition)
                            Look for Service inspection sticker
                        </p>
                    @endif
                    @if($audit->osha_q35_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q35_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q36_comment || $audit->osha_q36_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q36_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q36_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q36_answer === 1 && $audit->osha_q36_comment || $audit->osha_q36_answer === 3 && $audit->osha_q36_comment)
                        <h4>Are used batteries stored in acid resistance leak proof containers and or on mat?</h4>
                    @elseif($audit->osha_q36_answer === 2)
                        <h4>Used batteries are not being stored in acid resistance leak proof containers and or on
                            mat.</h4>
                    @endif
                    @if($audit->osha_q36_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q36_answer === 2)
                        <p>29 CFR 1910.304(f) & 1910.305(j)(7)
                            Store batteries on an acid resistant rack or tub.
                        </p>
                    @endif
                    @if($audit->osha_q36_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q36_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q37_comment || $audit->osha_q37_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q37_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q37_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q37_answer === 1 && $audit->osha_q37_comment || $audit->osha_q37_answer === 3 && $audit->osha_q37_comment)
                        <h4>If batteries are stored outside, are they in an enclosed or sheltered unit?</h4>
                    @elseif($audit->osha_q37_answer === 2)
                        <h4>Batteries being stored outside are not in an enclosed or sheltered unit.</h4>
                    @endif
                    @if($audit->osha_q37_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q37_answer === 2)
                        <p>Batteries stored outside should be stored on impermeable surfaces and should have
                            secondary containment. Also, it is recommended that batteries be covered to
                            prevent
                            acid run off.</p>
                    @endif
                    @if($audit->osha_q37_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q37_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q38_comment || $audit->osha_q38_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q38_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q38_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q38_answer === 1 && $audit->osha_q38_comment || $audit->osha_q38_answer === 3 && $audit->osha_q38_comment)
                        <h4>Do automatic sprinkler heads have a minimum clearance of 18” at all times?</h4>
                    @elseif($audit->osha_q38_answer === 2)
                        <h4>Automatic sprinkler heads do not have a minimum clearance of 18” at all times.</h4>
                    @endif
                    @if($audit->osha_q38_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q38_answer === 2)
                        <p>29 CFR 1910.159(c)(10)
                            The minimum vertical clearance between sprinklers and material below shall be 18
                            inches (45.7 cm).
                        </p>
                    @endif
                    @if($audit->osha_q38_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q38_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q39_comment || $audit->osha_q39_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q39_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q39_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q39_answer === 1 && $audit->osha_q39_comment || $audit->osha_q39_answer === 3 && $audit->osha_q39_comment)
                        <h4>Are all portable gas containers UL of FM approved?</h4>
                    @elseif($audit->osha_q39_answer === 2)
                        <h4>All portable gas containers UL of FM are not approved.</h4>
                    @endif
                    @if($audit->osha_q39_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q39_answer === 2)
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
                    @endif
                    @if($audit->osha_q39_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q39_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q40_comment || $audit->osha_q40_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q40_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q40_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q40_answer === 1 && $audit->osha_q40_comment || $audit->osha_q40_answer === 3 && $audit->osha_q40_comment)
                        <h4>Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                            working condition?</h4>
                    @elseif($audit->osha_q40_answer === 2)
                        <h4>Compressed air hoses in are not in safe (no frays, cuts, tape or clamps for repair) working
                            condition.</h4>
                    @endif
                    @if($audit->osha_q40_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q40_answer === 2)
                        <p>29 CFR 1910.101
                            29 CFR 1910.6 reference
                            49 CFR parts 171-179 & 14 CFR part 103
                            CGAP C-6-1968 & C-8-1962
                        </p>
                    @endif
                    @if($audit->osha_q40_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q40_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q41_comment || $audit->osha_q41_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q41_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q41_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q41_answer === 1 && $audit->osha_q41_comment || $audit->osha_q41_answer === 3 && $audit->osha_q41_comment)
                        <h4>Are all gas cylinders stored and tied off properly?</h4>
                    @elseif($audit->osha_q41_answer === 2)
                        <h4>All gas cylinders are not stored and tied off properly.</h4>
                    @endif
                    @if($audit->osha_q41_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q41_answer === 2)
                        <p>29 CFR 1910.101
                            29 CFR 1910.6 reference
                            49 CFR parts 171-179 & 14 CFR part 103
                            CGAP C-6-1968 & C-8-1962
                        </p>
                    @endif
                    @if($audit->osha_q41_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q41_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q42_comment || $audit->osha_q42_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q42_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q42_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q42_answer === 1 && $audit->osha_q42_comment || $audit->osha_q42_answer === 3 && $audit->osha_q42_comment)
                        <h4>Are gas cylinders stored away from sources of heat or electricity and at least 20’ away from
                            combustible materials?</h4>
                    @elseif($audit->osha_q42_answer === 2)
                        <h4>Gas cylinders are not stored away from sources of heat or electricity and not at least
                            20’ away from combustible materials.</h4>
                    @endif
                    @if($audit->osha_q42_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q42_answer === 2)
                        <p>29 CFR 1910.159(c)(10)
                            The minimum vertical clearance
                            between sprinklers and material
                            below shall be 18 inches (45.7 cm).</p>
                    @endif
                    @if($audit->osha_q42_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q42_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q43_comment || $audit->osha_q43_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q43_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q43_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q43_answer === 1 && $audit->osha_q43_comment || $audit->osha_q43_answer === 3 && $audit->osha_q43_comment)
                        <h4>Are goggles or face shields always worn when grinding?</h4>
                    @elseif($audit->osha_q43_answer === 2)
                        <h4>Goggles or face shields are not always worn when grinding.</h4>
                    @endif
                    @if($audit->osha_q43_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q43_answer === 2)
                        <p>29 CFR 1910 133 (a) (1)</p>
                    @endif
                    @if($audit->osha_q43_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q43_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q44_comment || $audit->osha_q44_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q44_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q44_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q44_answer === 1 && $audit->osha_q44_comment || $audit->osha_q44_answer === 3 && $audit->osha_q44_comment)
                        <h4>Is there proper spacing on grinders; Tool rest 1/8” from grinding wheel. Tongue plate 1/4”
                            from grinding wheel.</h4>
                    @elseif($audit->osha_q44_answer === 2)
                        <h4>There is no proper spacing on grinders;
                            Tool rest 1/8” from grinding wheel.
                            Tongue plate 1/4” from grinding wheel.</h4>
                    @endif
                    @if($audit->osha_q44_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q44_answer === 2)
                        <p>29 CFR 1910.215(a)(4) - Work rests. (Bottom Plate) On offhand grinding machines,
                            Work
                            rests shall be kept adjusted closely to the wheel with a maximum opening of
                            one-eighth inch
                            29 CFR 1910.215(b)(9) - Exposure adjustment. (Top Cover over Wheel) Safety
                            guards.
                            The distance between the wheel periphery and the adjustable tongue or the end of
                            the
                            peripheral member at the top shall never exceed one-fourth inch</p>
                    @endif
                    @if($audit->osha_q44_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q44_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q45_comment || $audit->osha_q45_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q45_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q45_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q45_answer === 1 && $audit->osha_q45_comment || $audit->osha_q45_answer === 3 && $audit->osha_q45_comment)
                        <h4>Is there proper signage about not smoking in the appropriate areas?</h4>
                    @elseif($audit->osha_q45_answer === 2)
                        <h4>There is no proper signage about not smoking in the appropriate areas.</h4>
                    @endif
                    @if($audit->osha_q45_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q45_answer === 2)
                        <p>29 CFR 1910.106
                            "No Smoking" signs shall be conspicuously posted where hazard from flammable
                            liquid
                            vapors is normally present.
                        </p>
                    @endif
                    @if($audit->osha_q45_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q45_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q46_comment || $audit->osha_q46_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q46_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q46_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q46_answer === 1 && $audit->osha_q46_comment || $audit->osha_q46_answer === 3 && $audit->osha_q46_comment)
                        <h4>Are the no smoking areas being enforced?</h4>
                    @elseif($audit->osha_q46_answer === 2)
                        <h4>The no smoking areas are not being enforced.</h4>
                    @endif
                    @if($audit->osha_q46_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q46_answer === 2)
                        <p>NFPA 99(12), Sec. 11.5.3.2.1
                            NO SMOKING signs (and/or the international symbol for no smoking), readable from
                            a distance of 5 ft, need to be posted wherever supplemental oxygen is in use and
                            in aisles and walkways leading to such area(s)</p>
                    @endif
                    @if($audit->osha_q46_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q46_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q47_comment || $audit->osha_q47_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q47_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q47_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q47_answer === 1 && $audit->osha_q47_comment || $audit->osha_q47_answer === 3 && $audit->osha_q47_comment)
                        <h4>Air compressors marked with Automatic on/off signage?</h4>
                    @elseif($audit->osha_q47_answer === 2)
                        <h4>Air compressors are not marked with Automatic on/off signage.</h4>
                    @endif
                    @if($audit->osha_q47_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q47_answer === 2)
                        <p>29 CFR 1910.169
                            1910.145 - These specifications are intended to cover all safety signs </p>
                    @endif
                    @if($audit->osha_q47_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q47_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q48_comment || $audit->osha_q48_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q48_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q48_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q48_answer === 1 && $audit->osha_q48_comment || $audit->osha_q48_answer === 3 && $audit->osha_q48_comment)
                        <h4>Are all tanks holding flammable material properly grounded?</h4>
                    @elseif($audit->osha_q48_answer === 2)
                        <h4>All tanks holding flammable material are not properly grounded.</h4>
                    @endif
                    @if($audit->osha_q48_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q48_answer === 2)
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
                    @endif
                    @if($audit->osha_q48_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q48_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q49_comment || $audit->osha_q49_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q49_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q49_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q49_answer === 1 && $audit->osha_q49_comment || $audit->osha_q49_answer === 3 && $audit->osha_q49_comment)
                        <h4>Is there clear access of at least 36” to all electrical panels?</h4>
                    @elseif($audit->osha_q49_answer === 2)
                        <h4>There is not clear access of at least 36” to all electrical panels.</h4>
                    @endif
                    @if($audit->osha_q49_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q49_answer === 2)
                        <p>1910.303(g)(1) & 1910.303(g)(1)(i)(B)
                            29 CFR 1921.303 (g)
                            NFPA 70 110-26

                            Regulations requires a minimum of three feet of clearance for all electrical
                            equipment serving 600 volts or less.
                        </p>
                    @endif
                    @if($audit->osha_q49_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q49_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q50_comment || $audit->osha_q50_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q50_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q50_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q50_answer === 1 && $audit->osha_q50_comment || $audit->osha_q50_answer === 3 && $audit->osha_q50_comment)
                        <h4>Are all the breakers properly labeled?</h4>
                    @elseif($audit->osha_q50_answer === 2)
                        <h4>All the breakers are not properly labeled.</h4>
                    @endif
                    @if($audit->osha_q50_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q50_answer === 2)
                        <p>29 CFR 1910.303
                            Suitability for installation and use in conformity with the provisions of this
                            subpart;
                            Note to paragraph (b)(1)(i) of this section: Suitability of equipment for an
                            identified purpose may be evidenced by listing or labeling for that identified
                            purpose. </p>
                    @endif
                    @if($audit->osha_q50_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q50_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q51_comment || $audit->osha_q51_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q51_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q51_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q51_answer === 1 && $audit->osha_q51_comment || $audit->osha_q51_answer === 3 && $audit->osha_q51_comment)
                        <h4>Are all vacant holes properly sealed off on electrical panel box?</h4>
                    @elseif($audit->osha_q51_answer === 2)
                        <h4>All vacant holes are not properly sealed off on electrical panel box.</h4>
                    @endif
                    @if($audit->osha_q51_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q51_answer === 2)
                        <p>29 CFR 1910.303
                            Suitability for installation and use in conformity with the provisions of this
                            subpart;
                            Note to paragraph (b)(1)(i) of this section: Suitability of equipment for an
                            identified purpose may be evidenced by listing or labeling for that identified
                            purpose. </p>
                    @endif
                    @if($audit->osha_q51_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q51_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q52_comment || $audit->osha_q52_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q52_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q52_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q52_answer === 1 && $audit->osha_q52_comment || $audit->osha_q52_answer === 3 && $audit->osha_q52_comment)
                        <h4>Are commercial grade extension cords being used properly?</h4>
                    @elseif($audit->osha_q52_answer === 2)
                        <h4>Commercial grade extension cords are not being used properly.</h4>
                    @endif
                    @if($audit->osha_q52_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q52_answer === 2)
                        <p>29 CFR 1910.334
                            Electrical Use of Equipment
                        </p>
                    @endif
                    @if($audit->osha_q52_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q52_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q53_comment || $audit->osha_q53_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q53_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q53_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q53_answer === 1 && $audit->osha_q53_comment || $audit->osha_q53_answer === 3 && $audit->osha_q53_comment)
                        <h4>Are all electrical cords in good working order (none frayed, cracked, taped, or
                            spliced or ground missing on 3 prong plugs)?</h4>
                    @elseif($audit->osha_q53_answer === 2)
                        <h4>All electrical cords are not in good working order (none frayed, cracked, taped, or
                            spliced or ground missing on 3 prong plugs).</h4>
                    @endif
                    @if($audit->osha_q53_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q53_answer === 2)
                        <p>29 CFR 1910.334
                            Electrical cords shall be visually inspected before use on any shift for
                            external
                            defects (such as loose parts, deformed and missing pins, or damage to outer
                            jacket
                            or insulation) and for evidence of possible internal damage (such as pinched or
                            crushed outer jacket).
                        </p>
                    @endif
                    @if($audit->osha_q53_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q53_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q54_comment || $audit->osha_q54_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q54_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q54_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q54_answer === 1 && $audit->osha_q54_comment || $audit->osha_q54_answer === 3 && $audit->osha_q54_comment)
                        <h4>Are the fluorescent tubes stored properly?</h4>
                    @elseif($audit->osha_q54_answer === 2)
                        <h4>The fluorescent tubes are not stored properly.</h4>
                    @endif
                    @if($audit->osha_q54_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q54_answer === 2)
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
                    @endif
                    @if($audit->osha_q54_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q54_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q55_comment || $audit->osha_q55_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q55_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q55_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q55_answer === 1 && $audit->osha_q55_comment || $audit->osha_q55_answer === 3 && $audit->osha_q55_comment)
                        <h4>There are no other miscellaneous electrical issues to note? If “No” explain further</h4>
                    @elseif($audit->osha_q55_answer === 2)
                        <h4>There are other miscellaneous electrical issues to note.</h4>
                    @endif
                    @if($audit->osha_q55_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q55_answer === 2)
                        <p>Electrical Use of Equipment
                            Safety
                        </p>
                    @endif
                    @if($audit->osha_q55_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q55_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q56_comment || $audit->osha_q56_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q56_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q56_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q56_answer === 1 && $audit->osha_q56_comment || $audit->osha_q56_answer === 3 && $audit->osha_q56_comment)
                        <h4>Miscellaneous issues.</h4>
                    @elseif($audit->osha_q56_answer === 2)
                        <h4>Miscellaneous issues.</h4>
                    @endif
                    @if($audit->osha_q56_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q56_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q56_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q57_comment || $audit->osha_q57_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q57_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q57_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q57_answer === 1 && $audit->osha_q57_comment || $audit->osha_q57_answer === 3 && $audit->osha_q57_comment)
                        <h4>Hybrid - Vehicle Training Certification upload</h4>
                    @elseif($audit->osha_q57_answer === 2)
                        <h4>No Hybrid - Vehicle Training Certification upload</h4>
                    @endif
                    @if($audit->osha_q57_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q57_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q57_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q58_comment || $audit->osha_q58_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q58_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q58_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q58_answer === 1 && $audit->osha_q58_comment || $audit->osha_q58_answer === 3 && $audit->osha_q58_comment)
                        <h4>Hybrid safety gloves are Class O Heavy-Duty gloves rated to withstand 1,000
                            volts?</h4>
                    @elseif($audit->osha_q58_answer === 2)
                        <h4>Hybrid safety gloves are not Class O Heavy-Duty gloves rated to withstand 1,000
                            volts.</h4>
                    @endif
                    @if($audit->osha_q58_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q58_answer === 2)
                        <p>Safety
                            Safety Equipment:
                            Gloves
                            Goggles
                            Key Box
                            Steering wheel Cover
                            Sign for Vehicle
                        </p>
                    @endif
                    @if($audit->osha_q58_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q58_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q59_comment || $audit->osha_q59_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q59_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q59_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q59_answer === 1 && $audit->osha_q59_comment || $audit->osha_q59_answer === 3 && $audit->osha_q59_comment)
                        <h4>Hybrid safety gloves are in good working condition?</h4>
                    @elseif($audit->osha_q59_answer === 2)
                        <h4>Hybrid safety gloves are not in good working condition.</h4>
                    @endif
                    @if($audit->osha_q59_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q59_answer === 2)
                        <p>Safety
                            Safety Equipment:
                            Gloves
                            Goggles
                            Key Box
                            Steering wheel Cover
                            Sign for Vehicle
                        </p>
                    @endif
                    @if($audit->osha_q59_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q59_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q60_comment || $audit->osha_q60_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q60_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q60_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q60_answer === 1 && $audit->osha_q60_comment || $audit->osha_q60_answer === 3 && $audit->osha_q60_comment)
                        <h4>Hybrid safety glasses worn when working on hybrid vehicles?</h4>
                    @elseif($audit->osha_q60_answer === 2)
                        <h4>Hybrid safety glasses are not being worn when working on hybrid vehicles.</h4>
                    @endif
                    @if($audit->osha_q60_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q60_answer === 2)
                        <p>Safety</p>
                    @endif
                    @if($audit->osha_q60_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q60_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q61_comment || $audit->osha_q61_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q61_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q61_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q61_answer === 1 && $audit->osha_q61_comment || $audit->osha_q61_answer === 3 && $audit->osha_q61_comment)
                        <h4>Is the first aid kit properly stocked given the dealership work
                            environment?</h4>
                    @elseif($audit->osha_q61_answer === 2)
                        <h4>The first aid kit is not properly stocked given the dealership work environment.</h4>
                    @endif
                    @if($audit->osha_q61_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q61_answer === 2)
                        <p>29 CFR 1910.151
                            First aid kits
                            First aid supplies are required to be readily available under paragraph §
                            1910.151(b).
                            An example of the minimal contents of a generic first aid kit is described in
                            American National Standard (ANSI) Z308.1-1998. Appendix A "Minimum Requirements
                            for
                            Workplace First-aid Kits.
                        </p>
                    @endif
                    @if($audit->osha_q61_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q61_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q62_comment || $audit->osha_q62_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q62_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q62_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q62_answer === 1 && $audit->osha_q62_comment || $audit->osha_q62_answer === 3 && $audit->osha_q62_comment)
                        <h4>Does dealership have elevators?</h4>
                    @elseif($audit->osha_q62_answer === 2)
                        <h4>The dealership does not have elevators.</h4>
                    @endif
                    @if($audit->osha_q62_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q62_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q62_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q63_comment || $audit->osha_q63_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q63_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q63_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q63_answer === 1 && $audit->osha_q63_comment || $audit->osha_q63_answer === 3 && $audit->osha_q63_comment)
                        <h4>Has elevator been inspected?</h4>
                    @elseif($audit->osha_q63_answer === 2)
                        <h4>The elevator has not been inspected.</h4>
                    @endif
                    @if($audit->osha_q63_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q63_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q63_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q64_comment || $audit->osha_q64_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q64_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q64_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    <h4>When was the last inspection date?</h4>
                    @if($audit->osha_q64_date)
                        <p>{{ $audit->osha_q64_date->format('F d, Y') }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                    @if($audit->osha_q64_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q64_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q64_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->osha_q65_comment || $audit->osha_q65_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('osha_q65_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('osha_q65_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->osha_q65_answer === 1 && $audit->osha_q65_comment || $audit->osha_q65_answer === 3 && $audit->osha_q65_comment)
                        <h4>Is the first aid kit accessible to all employees 24/7?</h4>
                    @elseif($audit->osha_q65_answer === 2)
                        <h4>The first aid kit accessible is not to all employees 24/7.</h4>
                    @endif
                    @if($audit->osha_q65_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->osha_q65_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->osha_q65_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
