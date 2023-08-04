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
                <h1 class="text-7xl text-white">Body Shop Report<span
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
        @if($audit->body_shop_q1_comment || $audit->body_shop_q1_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if($audit->getFirstMedia('body_shop_q1_images') != null)
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q1_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q1_answer === 1 && $audit->body_shop_q1_comment || $audit->body_shop_q1_answer === 3 && $audit->body_shop_q1_comment)
                        <h4>Is a Filtration Log being completed?</h4>
                    @elseif($audit->body_shop_q1_answer === 2)
                        <h4>The Filtration Log is not being completed.</h4>
                    @endif
                    @if($audit->body_shop_q1_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q1_answer === 2)
                        <p>Filters shall be checked and changed
                            as needed based on volume of spray
                            booth activity. Filter log will be kept up-to-date on filter change outs.</p>
                    @endif
                    @if($audit->body_shop_q1_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q1_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q2_comment || $audit->body_shop_q2_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q2_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q2_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q2_answer === 1 && $audit->body_shop_q2_comment || $audit->body_shop_q2_answer === 3 && $audit->body_shop_q2_comment)
                        <h4>Do all employees know how to access SDS’s?</h4>
                    @elseif($audit->body_shop_q2_answer === 2)
                        <h4>All employees do not know how to access SDS’s.</h4>
                    @endif
                    @if($audit->body_shop_q2_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q2_answer === 2)
                        <p>HCS 1910.1200 App E
                            Each employee who may be
                            “exposed” to hazardous chemicals
                            when working must be provided
                            information and trained prior to initial
                            assignment to work with a hazardous
                            chemical, and whenever the hazard
                            changes.</p>
                    @endif
                    @if($audit->body_shop_q2_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q2_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q3_comment || $audit->body_shop_q3_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q3_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q3_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q3_answer === 1 && $audit->body_shop_q3_comment || $audit->body_shop_q3_answer === 3 && $audit->body_shop_q3_comment)
                        <h4>Has annual fit test for all employees been performed?</h4>
                    @elseif($audit->body_shop_q3_answer === 2)
                        <h4>The annual fit test for all employees has not been performed.</h4>
                    @endif
                    @if($audit->body_shop_q3_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q3_answer === 2)
                        <p>1910.134
                            Fit testing must be performed initially
                            (before the employee is required to
                            wear the respirator in the workplace)
                            and must be repeated at least
                            annually. Fit testing must also be
                            conducted whenever respirator design
                            or facial changes occur that could
                            affect the proper fit of the respirator.</p>
                    @endif
                    @if($audit->body_shop_q3_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q3_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q4_comment || $audit->body_shop_q4_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q4_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q4_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q4_answer === 1 && $audit->body_shop_q4_comment || $audit->body_shop_q4_answer === 3 && $audit->body_shop_q4_comment)
                        <h4>Medical Questionnaire issued to employees utilizing respirators?</h4>
                    @elseif($audit->body_shop_q4_answer === 2)
                        <h4>Medical Questionnaire has not been issued to employees utilizing respirators.</h4>
                    @endif
                    @if($audit->body_shop_q4_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q4_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q4_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q4_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q5_comment || $audit->body_shop_q5_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q5_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q5_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q5_answer === 1 && $audit->body_shop_q5_comment || $audit->body_shop_q5_answer === 3 && $audit->body_shop_q5_comment)
                        <h4>Are respirators stored properly?</h4>
                    @elseif($audit->body_shop_q5_answer === 2)
                        <h4>Respirators are not stored properly?</h4>
                    @endif
                    @if($audit->body_shop_q5_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q5_answer === 2)
                        <p>29 CFR 1910.134(h)(2)(i)
                            All respirators shall be stored to
                            protect them from damage,
                            contamination, dust, sunlight,
                            extreme temperatures, excessive
                            moisture, and damaging chemicals,
                            and they shall be packed or stored to
                            prevent deformation of the facepiece
                            and exhalation valve.</p>
                    @endif
                    @if($audit->body_shop_q5_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q5_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q6_comment || $audit->body_shop_q6_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q6_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q6_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q6_answer === 1 && $audit->body_shop_q6_comment || $audit->body_shop_q6_answer === 3 && $audit->body_shop_q6_comment)
                        <h4>Do respirators have NIOSH certification?</h4>
                    @elseif($audit->body_shop_q6_answer === 2)
                        <h4>Respirators do not have NIOSH certification.</h4>
                    @endif
                    @if($audit->body_shop_q6_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q6_answer === 2)
                        <p>29 CFR 1910.134(i)
                            Identification of filters, cartridges, and
                            canisters. The employer shall ensure
                            that all filters, cartridges and
                            canisters used in the workplace are
                            labeled and color coded with the
                            NIOSH approval label and that the
                            label is not removed and remains
                            legible.</p>
                    @endif
                    @if($audit->body_shop_q6_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q6_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q7_comment || $audit->body_shop_q7_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q7_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q7_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q7_answer === 1 && $audit->body_shop_q7_comment || $audit->body_shop_q7_answer === 3 && $audit->body_shop_q7_comment)
                        <h4>Is PPE equipment available and is it in good condition?</h4>
                    @elseif($audit->body_shop_q7_answer === 2)
                        <h4>The PPE equipment is not available or is not in good condition.</h4>
                    @endif
                    @if($audit->body_shop_q7_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q6_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q7_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q7_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q8_comment || $audit->body_shop_q8_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q8_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q8_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q8_answer === 1 && $audit->body_shop_q8_comment || $audit->body_shop_q8_answer === 3 && $audit->body_shop_q8_comment)
                        <h4>Are paint booths free from any flammable material?</h4>
                    @elseif($audit->body_shop_q8_answer === 2)
                        <h4>The paint booths are not free from any flammable material.</h4>
                    @endif
                    @if($audit->body_shop_q8_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q8_answer === 2)
                        <p>29 CFR 1910.107(e)(i)
                            Flammable and combustible liquids —
                            storage and handling.
                            (1) Conformance. The storage of
                            flammable or combustible liquids in
                            connection with spraying operations
                            shall conform to the requirements of
                            §1910.106, where applicable.</p>
                    @endif
                    @if($audit->body_shop_q8_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q8_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q9_comment || $audit->body_shop_q9_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q9_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q9_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q9_answer === 1 && $audit->body_shop_q9_comment || $audit->body_shop_q9_answer === 3 && $audit->body_shop_q9_comment)
                        <h4>Are all the flammable materials stored properly?</h4>
                    @elseif($audit->body_shop_q9_answer === 2)
                        <h4>All flammable materials are not stored properly.</h4>
                    @endif
                    @if($audit->body_shop_q9_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q9_answer === 2)
                        <p>29 CFR 1910.106(a)(32)
                            Storage: Flammable or combustible
                            liquids shall be stored in a tank or in a
                            container that complies with
                            §1910.106(d)(2)(i) of this section</p>
                    @endif
                    @if($audit->body_shop_q9_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q9_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q10_comment || $audit->body_shop_q10_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q10_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q10_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q10_answer === 1 && $audit->body_shop_q10_comment || $audit->body_shop_q10_answer === 3 && $audit->body_shop_q10_comment)
                        <h4>Are all secondary containers filled with chemicals properly labeled?</h4>
                    @elseif($audit->body_shop_q10_answer === 2)
                        <h4>All secondary containers filled with chemicals are not properly labeled.</h4>
                    @endif
                    @if($audit->body_shop_q10_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q10_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q10_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q10_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q11_comment || $audit->body_shop_q11_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q11_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q11_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q11_answer === 1 && $audit->body_shop_q11_comment || $audit->body_shop_q11_answer === 3 && $audit->body_shop_q11_comment)
                        <h4>Has the eye wash equipment been tested, cleaned and documented weekly?</h4>
                    @elseif($audit->body_shop_q11_answer === 2)
                        <h4>The eye wash equipment has not been tested, cleaned and documented weekly.</h4>
                    @endif
                    @if($audit->body_shop_q11_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q11_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q11_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q11_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q12_comment || $audit->body_shop_q12_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q12_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q12_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q12_answer === 1 && $audit->body_shop_q12_comment || $audit->body_shop_q12_answer === 3 && $audit->body_shop_q12_comment)
                        <h4>Is the eye wash equipment readily accessible?</h4>
                    @elseif($audit->body_shop_q12_answer === 2)
                        <h4>The eye wash equipment is not readily accessible.</h4>
                    @endif
                    @if($audit->body_shop_q12_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q12_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q12_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q12_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q13_comment || $audit->body_shop_q13_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q13_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q13_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q13_answer === 1 && $audit->body_shop_q13_comment || $audit->body_shop_q13_answer === 3 && $audit->body_shop_q13_comment)
                        <h4>Has the eye wash container water supply been changed out properly based on
                            manufacturer recommendations per solution used?</h4>
                    @elseif($audit->body_shop_q13_answer === 2)
                        <h4>The eye wash container water supply has not been changed out properly based on
                            manufacturer recommendations per solution used.</h4>
                    @endif
                    @if($audit->body_shop_q13_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q13_answer === 2)
                        <p>Dealership is to follow manufacturing
                            guidelines for water exchange, i.e.
                            change every 90 days with new
                            sanitizer packs also added.
                            Initial/date sign off tag on side of
                            unit.</p>
                    @endif
                    @if($audit->body_shop_q13_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q13_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q14_comment || $audit->body_shop_q14_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q14_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q14_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q14_answer === 1 && $audit->body_shop_q14_comment || $audit->body_shop_q14_answer === 3 && $audit->body_shop_q14_comment)
                        <h4>Do you have documentation on water/solution change out?</h4>
                    @elseif($audit->body_shop_q14_answer === 2)
                        <h4>You do not have documentation on water/solution change out.</h4>
                    @endif
                    @if($audit->body_shop_q14_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q14_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q14_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q15_comment || $audit->body_shop_q15_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q15_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q15_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q15_answer === 1 && $audit->body_shop_q15_comment || $audit->body_shop_q15_answer === 3 && $audit->body_shop_q15_comment)
                        <h4>Are you following the mfg. specs?</h4>
                    @elseif($audit->body_shop_q15_answer === 2)
                        <h4>You are not following the mfg. specs.</h4>
                    @endif
                    @if($audit->body_shop_q15_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q15_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q15_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q16_comment || $audit->body_shop_q16_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q16_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q16_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q16_answer === 1 && $audit->body_shop_q16_comment || $audit->body_shop_q16_answer === 3 && $audit->body_shop_q16_comment)
                        <h4>Have the fire extinguishers had their annual inspection and are they properly
                            identified and fully charged?</h4>
                    @elseif($audit->body_shop_q16_answer === 2)
                        <h4>The fire extinguishers have not had their annual inspection or are not properly
                            identified and fully charged.</h4>
                    @endif
                    @if($audit->body_shop_q16_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q16_answer === 2)
                        <p>29 CFR 1910.157(d)(2) - The
                            employer shall distribute portable fire
                            extinguishers for use by employees on
                            Class A fires so that the travel
                            distance for employees to any
                            extinguisher is 75 ft</p>
                    @endif
                    @if($audit->body_shop_q16_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q16_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q17_comment || $audit->body_shop_q17_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q17_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q17_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q17_answer === 1 && $audit->body_shop_q17_comment || $audit->body_shop_q17_answer === 3 && $audit->body_shop_q17_comment)
                        <h4>Are the fire extinguishers easily accessible?</h4>
                    @elseif($audit->body_shop_q17_answer === 2)
                        <h4>The fire extinguishers are not easily accessible.</h4>
                    @endif
                    @if($audit->body_shop_q17_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q17_answer === 2)
                        <p>29 CFR 1910.157(c)(1) - Fire
                            extinguishers and shall mount, locate and identify them so that they are
                            readily accessible to employees
                            without subjecting the employees to
                            possible injury. Mounting; Height is
                            between 36” to 60”
                            Accessibility is 20’” in front and sides</p>
                    @endif
                    @if($audit->body_shop_q17_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q17_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q18_comment || $audit->body_shop_q18_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q18_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q18_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q18_answer === 1 && $audit->body_shop_q18_comment || $audit->body_shop_q18_answer === 3 && $audit->body_shop_q18_comment)
                        <h4>Are all hoses and cutting tips for the welder/cutting torches in good condition
                            without any cracks or breaks?</h4>
                    @elseif($audit->body_shop_q18_answer === 2)
                        <h4>All hoses and cutting tips for the welder/cutting torches are not in good condition
                            without any cracks or breaks.</h4>
                    @endif
                    @if($audit->body_shop_q18_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q18_answer === 2)
                        <p>29 CFR 1910.252 / ANSI Z49.1
                            Safety in Welding, Cutting, and Allied
                            Processes.</p>
                    @endif
                    @if($audit->body_shop_q18_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q18_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q19_comment || $audit->body_shop_q19_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q19_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q19_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q19_answer === 1 && $audit->body_shop_q19_comment || $audit->body_shop_q19_answer === 3 && $audit->body_shop_q19_comment)
                        <h4>Are all exits properly marked?</h4>
                    @elseif($audit->body_shop_q19_answer === 2)
                        <h4>All exits are not properly marked.</h4>
                    @endif
                    @if($audit->body_shop_q19_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q19_answer === 2)
                        <p>NFPA 101, Section 7.10.1.2
                            NFPA 101 Life Safety Code 3.3.136
                            Means of Egress.
                            A continuous and unobstructed way
                            of travel from any point in a building
                            or structure to a public way consisting
                            of three separate and distinct parts:
                            (1) the exit access, (2) the exit, and (3)
                            the exit discharge.</p>
                    @endif
                    @if($audit->body_shop_q19_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q19_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q20_comment || $audit->body_shop_q20_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q20_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q20_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q20_answer === 1 && $audit->body_shop_q20_comment || $audit->body_shop_q20_answer === 3 && $audit->body_shop_q20_comment)
                        <h4>Are pathways to exits clear of obstructions?</h4>
                    @elseif($audit->body_shop_q20_answer === 2)
                        <h4>Pathways to exits are not clear of obstructions.</h4>
                    @endif
                    @if($audit->body_shop_q20_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q20_answer === 2)
                        <p>Ensure that exit routes are
                            unobstructed such as by materials,
                            equipment, locked doors, or dead-end
                            corridors.</p>
                    @endif
                    @if($audit->body_shop_q20_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q20_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q21_comment || $audit->body_shop_q21_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q21_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q21_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q21_answer === 1 && $audit->body_shop_q21_comment || $audit->body_shop_q21_answer === 3 && $audit->body_shop_q21_comment)
                        <h4>Are all aisles/pathways, stairways and landings free from obstructions and are
                            the shop areas kept clean and orderly?</h4>
                    @elseif($audit->body_shop_q21_answer === 2)
                        <h4>All aisles/pathways, stairways and landings are not free from obstructions and/or
                            the shop areas are not kept clean and orderly.</h4>
                    @endif
                    @if($audit->body_shop_q21_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q21_answer === 2)
                        <p>General Duty Clause 29 U.S.C. §
                            654, 5(a)1: - Each employer shall
                            furnish to each of his employees’
                            employment and a place of
                            employment which are free from recognized hazards that are causing
                            or are likely to cause death or serious
                            physical harm to his employees.&quot;</p>
                    @endif
                    @if($audit->body_shop_q21_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q21_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q22_comment || $audit->body_shop_q22_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q22_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q22_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q22_answer === 1 && $audit->body_shop_q22_comment || $audit->body_shop_q22_answer === 3 && $audit->body_shop_q22_comment)
                        <h4>Are any doorways that are nonfunctioning or blocked
                            marked by a sign stating “NOT AN EXIT”?</h4>
                    @elseif($audit->body_shop_q22_answer === 2)
                        <h4>Doorways that are nonfunctioning or blocked or not marked by a sign stating “NOT AN
                            EXIT”.</h4>
                    @endif
                    @if($audit->body_shop_q22_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q22_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q22_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q22_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q23_comment || $audit->body_shop_q23_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q23_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q23_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q23_answer === 1 && $audit->body_shop_q23_comment || $audit->body_shop_q23_answer === 3 && $audit->body_shop_q23_comment)
                        <h4>Are floors in good repair and free from obstruction and debris and slippery
                            conditions?</h4>
                    @elseif($audit->body_shop_q23_answer === 2)
                        <h4>Floors are not in good repair and/or not free from obstruction and debris and slippery
                            conditions.</h4>
                    @endif
                    @if($audit->body_shop_q23_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q22_answer === 2)
                        <p>General Duty Clause 29 U.S.C. §
                            654, 5(a)1:</p>
                    @endif
                    @if($audit->body_shop_q23_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q23_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q24_comment || $audit->body_shop_q24_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q24_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q24_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q24_answer === 1 && $audit->body_shop_q24_comment || $audit->body_shop_q24_answer === 3 && $audit->body_shop_q24_comment)
                        <h4>Are floor openings in excess of 2.25” wide covered with hinged flaps?</h4>
                    @elseif($audit->body_shop_q24_answer === 2)
                        <h4>Floor openings in excess of 2.25” wide are not covered with hinged flaps.</h4>
                    @endif
                    @if($audit->body_shop_q24_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q24_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q24_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q24_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q25_comment || $audit->body_shop_q25_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q25_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q25_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q25_answer === 1 && $audit->body_shop_q25_comment || $audit->body_shop_q25_answer === 3 && $audit->body_shop_q25_comment)
                        <h4>Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair)
                            working condition?</h4>
                    @elseif($audit->body_shop_q25_answer === 2)
                        <h4>Compressed air hoses are not in safe (no frays, cuts, tape or clamps for repair)
                            working condition.</h4>
                    @endif
                    @if($audit->body_shop_q25_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q25_answer === 2)
                        <p>29 CFR 1910.242 - Never use frayed,
                            damaged or deteriorated hoses.
                            Always store hoses properly and away
                            from heat sources or direct sunlight. A
                            hose failure can cause serious injury.
                            Hose Reels can decrease your chances
                            of injury, as well as help hoses last
                            longer.</p>
                    @endif
                    @if($audit->body_shop_q25_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q25_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q26_comment || $audit->body_shop_q26_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q26_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q26_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q26_answer === 1 && $audit->body_shop_q26_comment || $audit->body_shop_q26_answer === 3 && $audit->body_shop_q26_comment)
                        <h4>All gas cylinders stored properly i.e. tied down etc.?</h4>
                    @elseif($audit->body_shop_q26_answer === 2)
                        <h4>All gas cylinders are not stored properly i.e. tied down etc.</h4>
                    @endif
                    @if($audit->body_shop_q26_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q26_answer === 2)
                        <p>29 CFR 1910.101
                            29 CFR 1910.6 reference
                            49 CFR parts 171-179 & 14 CFR part 103
                            CGAP C-6-1968 & C-8-1962
                            29 CFR 1926.350(a)(7); securing compressed gas cylinders.
                        </p>
                    @endif
                    @if($audit->body_shop_q26_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q26_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q27_comment || $audit->body_shop_q27_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q27_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q27_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q27_answer === 1 && $audit->body_shop_q27_comment || $audit->body_shop_q27_answer === 3 && $audit->body_shop_q27_comment)
                        <h4>Are gas cylinders stored away from sources of heat or electricity and at least 20’ away from
                            combustible materials?</h4>
                    @elseif($audit->body_shop_q27_answer === 2)
                        <h4>Gas cylinders are not stored away from sources of heat or electricity and/or not at least
                            20’ away from combustible materials.</h4>
                    @endif
                    @if($audit->body_shop_q27_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q27_answer === 2)
                        <p>29 CFR 1910.101
                            29 CFR 1910.6 reference
                            49 CFR parts 171-179 & 14 CFR part 103
                            CGAP C-6-1968 & C-8-1962</p>
                    @endif
                    @if($audit->body_shop_q27_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q27_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q28_comment || $audit->body_shop_q28_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q28_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q28_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q28_answer === 1 && $audit->body_shop_q28_comment || $audit->body_shop_q28_answer === 3 && $audit->body_shop_q28_comment)
                        <h4>When dispensing are all tanks holding flammable material properly grounded?</h4>
                    @elseif($audit->body_shop_q28_answer === 2)
                        <h4>When dispensing all tanks holding flammable material are not properly grounded.</h4>
                    @endif
                    @if($audit->body_shop_q28_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q28_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q28_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q28_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q29_comment || $audit->body_shop_q29_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q29_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q29_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q29_answer === 1 && $audit->body_shop_q29_comment || $audit->body_shop_q29_answer === 3 && $audit->body_shop_q29_comment)
                        <h4>Is there proper signage about not smoking in the appropriate areas?</h4>
                    @elseif($audit->body_shop_q29_answer === 2)
                        <h4>No proper signage about not smoking in the appropriate areas.</h4>
                    @endif
                    @if($audit->body_shop_q29_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q29_answer === 2)
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
                    @endif
                    @if($audit->body_shop_q29_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q29_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q30_comment || $audit->body_shop_q30_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q30_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q30_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q30_answer === 1 && $audit->body_shop_q30_comment || $audit->body_shop_q30_answer === 3 && $audit->body_shop_q30_comment)
                        <h4>Are no smoking signs being enforced?</h4>
                    @elseif($audit->body_shop_q30_answer === 2)
                        <h4>No smoking signs are not being enforced.</h4>
                    @endif
                    @if($audit->body_shop_q30_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q30_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q30_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q31_comment || $audit->body_shop_q31_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q31_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q31_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q31_answer === 1 && $audit->body_shop_q31_comment || $audit->body_shop_q31_answer === 3 && $audit->body_shop_q31_comment)
                        <h4>Are goggles or face shields always worn when grinding?</h4>
                    @elseif($audit->body_shop_q31_answer === 2)
                        <h4>Goggles or face shields are not always worn when grinding.</h4>
                    @endif
                    @if($audit->body_shop_q31_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q31_answer === 2)
                        <p>29 CFR 1910 133 (a) (1) - (a) General requirements. (1) The employer shall ensure
                            that each affected employee uses appropriate eye or face protection when exposed
                            to eye or face hazards from flying particles, molten metal, liquid chemicals,
                            acids or caustic liquids, chemical gases or vapors, or potentially injurious
                            light radiation.
                        </p>
                    @endif
                    @if($audit->body_shop_q31_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q31_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q32_comment || $audit->body_shop_q32_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q32_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q32_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q32_answer === 1 && $audit->body_shop_q32_comment || $audit->body_shop_q32_answer === 3 && $audit->body_shop_q32_comment)
                        <h4>Is there proper spacing on grinders; Tool rest 1/8” from grinding wheel Tongue plate 1/4”
                            from grinding wheel?</h4>
                    @elseif($audit->body_shop_q32_answer === 2)
                        <h4>There is not proper spacing on grinders; Tool rest 1/8” from grinding wheel Tongue plate
                            1/4” from grinding wheel.</h4>
                    @endif
                    @if($audit->body_shop_q32_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q32_answer === 2)
                        <p>29 CFR 1910.215(a)(4) - Work rests. (Bottom Plate) On offhand grinding machines,
                            Work rests shall be kept adjusted closely to the wheel with a maximum opening of
                            one-eighth inch

                            29 CFR 1910.215(b)(9) - exposure adjustment. (Top Cover over Wheel) Safety
                            guards. The distance between the wheel periphery and the adjustable tongue or
                            the end of the peripheral member at the top shall never exceed one-fourth
                            inch</p>
                    @endif
                    @if($audit->body_shop_q32_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q32_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q33_comment || $audit->body_shop_q33_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q33_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q33_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q33_answer === 1 && $audit->body_shop_q33_comment || $audit->body_shop_q33_answer === 3 && $audit->body_shop_q33_comment)
                        <h4>Are signs posted warning of automatic starting feature of the compressors?</h4>
                    @elseif($audit->body_shop_q33_answer === 2)
                        <h4>No signs posted warning of automatic starting feature of the compressors.</h4>
                    @endif
                    @if($audit->body_shop_q33_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q33_answer === 2)
                        <p>Industry Standards Apply
                            Safety</p>
                    @endif
                    @if($audit->body_shop_q33_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q33_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q34_comment || $audit->body_shop_q34_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q34_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q34_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q34_answer === 1 && $audit->body_shop_q34_comment || $audit->body_shop_q34_answer === 3 && $audit->body_shop_q34_comment)
                        <h4>Is there clear access of at least 36” to all
                            electrical panels?</h4>
                    @elseif($audit->body_shop_q34_answer === 2)
                        <h4>No clear access of at least 36” to all electrical panels.</h4>
                    @endif
                    @if($audit->body_shop_q34_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q34_answer === 2)
                        <p>1910.303(g)(1) & 1910.303(g)(1)(i)(B)
                            29 CFR 1921.303 (g)
                            NFPA 70 110-26
                            Regulations requires a minimum of three feet of clearance for all electrical
                            equipment serving 600 volts or less</p>
                    @endif
                    @if($audit->body_shop_q34_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q34_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q35_comment || $audit->body_shop_q35_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q35_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q35_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q35_answer === 1 && $audit->body_shop_q35_comment || $audit->body_shop_q35_answer === 3 && $audit->body_shop_q35_comment)
                        <h4>Are all the breakers properly labeled?</h4>
                    @elseif($audit->body_shop_q35_answer === 2)
                        <h4>All the breakers are not properly labeled.</h4>
                    @endif
                    @if($audit->body_shop_q35_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q35_answer === 2)
                        <p>29 CFR 1910.303
                            Suitability for installation and use in conformity with the provisions of this
                            subpart;
                            Note to paragraph (b) (1) (i) of this section: Suitability of equipment for an
                            identified purpose may be evidenced by listing or labeling for that identified
                            purpose. </p>
                    @endif
                    @if($audit->body_shop_q35_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q35_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q36_comment || $audit->body_shop_q36_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q36_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q36_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q36_answer === 1 && $audit->body_shop_q36_comment || $audit->body_shop_q36_answer === 3 && $audit->body_shop_q36_comment)
                        <h4>Are commercial grade extension cords being used properly?</h4>
                    @elseif($audit->body_shop_q36_answer === 2)
                        <h4>Commercial grade extension cords are not being used properly.</h4>
                    @endif
                    @if($audit->body_shop_q36_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q36_answer === 2)
                        <p>29 CFR 1910.334
                            Electrical Use of Equipment
                        </p>
                    @endif
                    @if($audit->body_shop_q36_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q36_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q37_comment || $audit->body_shop_q37_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q37_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q37_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q37_answer === 1 && $audit->body_shop_q37_comment || $audit->body_shop_q37_answer === 3 && $audit->body_shop_q37_comment)
                        <h4>Are all electrical cords in good working order
                            (none frayed, cracked, taped, or spliced or ground missing on 3 prong plugs)?</h4>
                    @elseif($audit->body_shop_q37_answer === 2)
                        <h4>All electrical cords are not in good working order
                            (none frayed, cracked, taped, or spliced or ground missing on 3 prong plugs).</h4>
                    @endif
                    @if($audit->body_shop_q37_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q37_answer === 2)
                        <p>29 CFR 1910.334
                            Electrical cords shall be visually inspected before use on any shift for
                            external defects (such as loose parts, deformed and missing pins, or damage to
                            outer jacket or insulation) and for evidence of possible internal damage (such
                            as pinched or crushed outer jacket).</p>
                    @endif
                    @if($audit->body_shop_q37_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q37_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q38_comment || $audit->body_shop_q38_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q38_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q38_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q38_answer === 1 && $audit->body_shop_q38_comment || $audit->body_shop_q38_answer === 3 && $audit->body_shop_q38_comment)
                        <h4>Are all electrical plug ends still have ground prong attached?</h4>
                    @elseif($audit->body_shop_q38_answer === 2)
                        <h4>All electrical plug ends do not have ground prong attached.</h4>
                    @endif
                    @if($audit->body_shop_q38_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q38_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q38_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q39_comment || $audit->body_shop_q39_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q39_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q39_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q39_answer === 1 && $audit->body_shop_q39_comment || $audit->body_shop_q39_answer === 3 && $audit->body_shop_q39_comment)
                        <h4>Are all other additional electrical issues correct? If “No” explain.</h4>
                    @elseif($audit->body_shop_q39_answer === 2)
                        <h4>All other additional electrical issues not correct.</h4>
                    @endif
                    @if($audit->body_shop_q39_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q39_answer === 2)
                        <p>Safety</p>
                    @endif
                    @if($audit->body_shop_q39_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q39_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q40_comment || $audit->body_shop_q40_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q40_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q40_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q40_answer === 1 && $audit->body_shop_q40_comment || $audit->body_shop_q40_answer === 3 && $audit->body_shop_q40_comment)
                        <h4>There are no other miscellaneous electrical issues to note? If “No” explain further.</h4>
                    @elseif($audit->body_shop_q40_answer === 2)
                        <h4>There are other miscellaneous electrical issues to note.</h4>
                    @endif
                    @if($audit->body_shop_q40_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q40_answer === 2)
                        <p>Safety</p>
                    @endif
                    @if($audit->body_shop_q40_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q40_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q41_comment || $audit->body_shop_q41_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q41_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q41_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q41_answer === 1 && $audit->body_shop_q41_comment || $audit->body_shop_q41_answer === 3 && $audit->body_shop_q41_comment)
                        <h4>Hybrid safety gloves are “Class O Heavy-Duty gloves rated to withstand 1,000 volts?</h4>
                    @elseif($audit->body_shop_q41_answer === 2)
                        <h4>Hybrid safety gloves are not “Class O Heavy-Duty gloves rated to withstand 1,000 volts.</h4>
                    @endif
                    @if($audit->body_shop_q41_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q41_answer === 2)
                        <p>Safety
                            Safety Equipment:
                            Gloves
                            Goggles
                            Key Box
                            Steering wheel Cover
                            Sign for Vehicle
                        </p>
                    @endif
                    @if($audit->body_shop_q41_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q41_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q42_comment || $audit->body_shop_q42_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q42_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q42_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q42_answer === 1 && $audit->body_shop_q42_comment || $audit->body_shop_q42_answer === 3 && $audit->body_shop_q42_comment)
                        <h4>Hybrid safety glasses worn when working on hybrid vehicles?</h4>
                    @elseif($audit->body_shop_q42_answer === 2)
                        <h4>Hybrid safety glasses are not worn when working on hybrid vehicles.</h4>
                    @endif
                    @if($audit->body_shop_q42_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q42_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q42_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q43_comment || $audit->body_shop_q43_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q43_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q43_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q43_answer === 1 && $audit->body_shop_q43_comment || $audit->body_shop_q43_answer === 3 && $audit->body_shop_q43_comment)
                        <h4>Is the first aid kit properly stocked given the dealership work environment?</h4>
                    @elseif($audit->body_shop_q43_answer === 2)
                        <h4>The first aid kit is not properly stocked given the dealership work environment.</h4>
                    @endif
                    @if($audit->body_shop_q43_danger)
                        <span class="text-red-500 italic">Potential High Risk Violation</span>
                    @endif
                    @if($audit->body_shop_q43_answer === 2)
                        <p>29 CFR 1910.151
                            First aid kits
                            First aid supplies are required to be readily available under paragraph §
                            1910.151(b).

                            An example of the minimal contents of a generic first aid kit is described in
                            American National Standard (ANSI) Z308.1-1998. Appendix A

                            "Minimum Requirements for Workplace First-aid Kits."
                        </p>
                    @endif
                    @if($audit->body_shop_q43_comment)
                        <div>
                            <p><span class="font-bold">Comment:</span>
                                {{ $audit->body_shop_q43_comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if($audit->body_shop_q44_comment || $audit->body_shop_q44_answer === 2)
            <div class="grid grid-cols-6 gap-10">
                <div class="col-span-1">
                    @if(!empty($audit->getFirstMedia('body_shop_q44_images')))
                        <img class="aspect-[4/5] w-full rounded object-cover"
                             src="{{ $audit->getMedia('body_shop_q44_images')->first()->getUrl() }}" alt="">
                    @endif
                </div>
                <div class="col-span-5">
                    @if($audit->body_shop_q44_comment)
                        <div>
                            <p><span class="font-bold">Additional Comments:</span><br/>
                                {{ $audit->body_shop_q44_comment }}
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
