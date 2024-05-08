<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/ios-icon.png') }}">

    <title>{{ $contract->dealer_name }} - Automotive Risk Management Partners Inc. Contract</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="p-5">
    <div class="text-sm prose max-w-6xl mx-auto">
        <x-application-logo class="w-auto h-10 my-10" />
        <p>This Agreement dated this <strong>{{ $contract->agreement_date->format('jS') }}</strong> day of <strong>{{ $contract->agreement_date->format('F') }}</strong>, <strong>{{ $contract->agreement_date->format('Y') }}</strong>, is entered into by and between AUTOMOTIVE RISK MANAGEMENT PARTNERS INC., 60-B Terra Cotta Avenue, Suite 159, Crystal Lake, Illinois 60014 (hereinafter referred to as “ARMP”), and <strong>{{ $contract->dealer_name }}</strong> (hereinafter referred to as “DEALER”).</p>
        <p>DEALER owns and operates an automobile dealership for the sale of new and used automobiles.</p>
        <p>ARMP provides consulting services to assist automobile dealers in their compliance with Gramm, Leach, Bliley Act (hereinafter referred to as “GLB”), Patriot Act, Safeguards Rule, OSHA, Red Flags Rule, F&I Compliance, and related Federal and State Government regulations, contained in ARMP’s “Compliance Solved” program. </p>
        <p>DEALER has requested the following compliance services from ARMP: </p>
        <ul>
            @foreach($services as $service)
                <li>{{ $service }}</li>
            @endforeach
        </ul>
        <p>The parties agree that ARMP will provide its services to DEALER commencing <strong>{{ $contract->commence_date->format('F d, Y') }}</strong>, for a period of twelve (12) months from the date of this contract.</p>
        <p>During the term of this Agreement, depending on the compliance services selected above by Dealer, it is agreed by the Parties that ARMP will provide the following services to DEALER:</p>
        <p><strong>A.</strong> Compliance consulting, employee and management training, auditing of compliance procedures and a sampling of customer vehicle transactions, recommend best compliance practices and procedures, creation of required regulatory documents and manuals, and provide suggested policies and procedures for compliance with GLB, FCRA, ECOA, TILA, RED FLAGS RULE, Adverse Action, Risk Based Pricing, and Federal and State regulations associated with the foregoing. <strong>NOTE: ARMP provides no compliance services under the terms of this agreement related in any manner to Dealer advertising, or with respect to structural and building code compliance of any nature, including but not limited to the Americans with Disabilities Act (ADA), and related State., County and Local regulations.</strong></p>
        <p><strong>B.</strong> Initial on-site inspection, evaluation, audit and compliance set up to be completed during the first thirty (30) days of the contract. </p>
        <p><strong>C.</strong> During each 12-month period of the contract ARMP will conduct <strong>{{ $contract->yearly_inspection_total }}</strong> on-site inspections, audits, and review sessions with management.</p>
        <p>DEALER agrees to pay the following amounts for services provided by ARMP:</p>
        <p><strong>A.</strong> An initial fee of <strong>${{ $contract->initial_fee }}</strong> due upon execution of this Agreement.</p>
        <p><strong>B.</strong> A monthly fee of <strong>${{ $contract->monthly_fee }}</strong> due on the first day of each month that the Agreement is in effect. The first monthly payment shall be due on the date of this contract.</p>
        <p>All payments are to be made payable to ARMP and mailed to its address at 60-B Terra Cotta Avenue, Suite 159, Crystal Lake, Illinois 60014, and are to be received by the 1st of each month. If ARMP has not received any payment due under this Agreement within ten (10) days after it is due, DEALER agrees to pay a late fee of $50.00 for each month the installment remains unpaid.  Unpaid balances under this Agreement shall accrue interest at the rate of 1.5% per month on all amounts over thirty (30) days past due. </p>
        <p>The Agreement shall renew at the end of the initial term, and shall thereafter continue for successive annual periods until terminated by either party upon not less than sixty days written notice prior to the then current  term. There will be no renewal fee.  The monthly fee for any extensions will remain as set forth in this agreement. Any change to the monthly fee set forth in this agreement must be in writing and signed by the parties. </p>
        <p>DEALER authorizes ARMP, its agents and employees access to DEALER’s premises, records, and computers for the purpose of performing inspections in accord with this Agreement.</p>
        <p>ARMP, its agents and employees shall hold all information, processes, reports, documentation, or information of any nature that is made available by DEALER to ARMP by virtue of this Agreement, or the relationship created by this Agreement, in strict confidence.  ARMP, its agents and employees shall not disclose to any other person, entity, DEALER or third party provider any of the information it obtains by or through DEALER.  All information provided by DEALER to ARMP and its employees remains the property of DEALER and will be held in the strictest confidence.</p>
        <p>ARMP agrees to implement and maintain physical, electronic, and procedural safeguards as may be required by Federal and State law.</p>
        <p>Dealer agrees during the term of this Agreement to cooperate with ARMP and its representatives.</p>
        <p>DEALER understands that during the term of this Agreement ARMP will make certain recommendations to Dealer concerning compliant practices and procedures. DEALER acknowledges that failure to comply with ARMP’s recommended policies and procedures may result in significant liability and penalties being imposed against DEALER.   DEALER acknowledges that with the exception of the initial on-site inspection, and the inspections performed on a periodic basis, that ARMP and its representatives will not be present at DEALER’s location.  Therefore, DEALER is responsible for implementation, and follow through on those procedures and guidelines suggested by ARMP.  Said guidelines and recommendations will be provided in writing to DEALER at the conclusion of the initial, and each inspection. The guidelines and procedures may be updated from time to time, and DEALER agrees that upon receipt of the written updates, said procedures will be considered for implementation. Dealer acknowledges and understands that ARMP does not provide legal services or advice.  Dealer will consult its own attorneys for legal advice, policy and agreement review, questions and opinions.</p>
        <p>DEALER shall not be entitled to any consequential or incidental damages as a result of a breach of this Agreement by ARMP, its agents, or assigns.  Nor shall ARMP, its agents, or assigns be liable for any failure by the DEALER to comply with and follow the written procedures, recommendations and policies provided to the DEALER by ARMP. Dealer shall not be entitled to any credit or offset, nor shall ARMP be liable for any short term interruption of the “Compliance Solved” web service. “Short term” shall be defined as any continuous period of time of 72 hours or less. In the event the web service is down for a continuous period in excess of 72 hours, Dealer shall be entitled to a pro rata credit for the monthly fee for the month the web service was down. Neither party shall be liable for failure to perform due to act of war or terrorism.</p>
        <p>ARMP owns and retains all right, title and interest, worldwide, in any and all proprietary software, technology, ideas, methods, processes and know-how (“ARMP Technology”) used by ARMP during the provisioning of Services to Dealer. Dealer agrees that any Dealer personnel that may have access to ARMP Technology; shall not resell, repackage, redistribute, etc., in any way, any information that may be gained by Dealer or its personnel during the delivery of Services by ARMP to Dealer.  Upon termination or expiration of this Agreement, ARMP shall remove all copies or embodiments of ARMP Technology from Dealer’s network and Dealer shall cease its use.  Dealer shall comply with all third-party software and technology licenses utilized in the provisioning of the Services.</p>
        <p>Both parties acknowledge that, during the Term of this Agreement, each party may provide the other with or otherwise expose them to confidential and/or proprietary information, including but not limited to data, information, pricing and costs, ideas, materials, specifications, procedures, software, technical processes and formulas, product designs, sales, cost and other unpublished financial information, product and business plans, usage rates, marketing data, customer and Dealer information and contacts or other relevant information clearly intended to be confidential (collectively, “Confidential Information”). Each party shall protect all such Confidential Information of the other with at least the same degree of care it uses to protect its own confidential information, but not less than a reasonable degree of care, and shall not disclose to any third party or use such Confidential Information in any manner not authorized herein.  Neither party shall use, disclose, provide, or permit any person to obtain any such Confidential Information in any form, except for its employees, agents or independent contractors whose access is required to carry out the purposes of this Agreement and who have agreed to be subject to the same restrictions as set forth herein.  The obligations of this Section shall survive the termination or expiration, for whatever reason, of this Agreement, and will continue to apply as long as the confidential nature of the Confidential Information is maintained.</p>
        <p>In the event of any default by DEALER, ARMP shall be entitled to recover, in addition to the sums due and owing under the terms of the Agreement, attorney’s fees and costs it incurs in enforcing the terms and provisions of this Agreement.</p>
        <p>This Agreement shall be binding upon the successors and assigns of ARMP and DEALER.</p>
        <p>The parties consent to personal jurisdiction in the State of Illinois, and agree that any legal action brought between the parties to this Agreement shall be brought in the Twenty-Second Judicial Circuit Court for McHenry County, Illinois.  The parties further agree that the terms of the Agreement, and rights of the respective parties, shall be interpreted in accordance with Illinois Law.   </p>
        <p>If any part, term or provision of this Agreement is held to be illegal, in conflict with any law or otherwise invalid, the remaining portion or portions shall be considered severable and not be affected by such determination, and the rights and obligations of the parties shall be construed and enforced as if the Agreement did not contain the particular part, term or provisions held to be illegal or invalid. </p>
        <p>This Agreement represents the whole and entire agreement between the parties.  No other agreement or representations, oral or written, have been made by ARMP.  This Agreement may not be altered, modified, or amended except in writing properly executed by the parties to it.</p>
        <div class="break-before-page"></div>
        <p>By SIGNING BELOW, the DEALER and ARMP each accept and agree to the terms and conditions set forth in this agreement.</p>
    </div>
    <div>
        <div class="flex flex-row justify-between mt-10">
            <div class="w-1/2">
                <p><strong>AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</strong></p>
                <img class="w-[200px] h-auto" src="{{ global_asset($contract->armp_signature) }}" alt="">
                <p>{{ $contract->armp_printed_name }}</p>
                <p>{{ $contract->armp_date_signed->format('F d, Y') }}</p>
            </div>
            <div class="w-1/2">
                <p><strong>{{ $contract->dealer_name }}</strong></p>
                <img class="w-[200px] h-auto" src="{{ global_asset($contract->dealer_signature) }}" alt="">
                <p>{{ $contract->dealer_printed_name }}</p>
                <p>{{ $contract->dealer_date_signed->format('F d, Y') }}</p>
            </div>
        </div>
        <p class="text-center mt-20 mb-10"><strong>Dealership Information</strong></p>
        <div class="flex flex-row justify-between mt-10">
            <div class="w-1/2">
                <p class="mb-5">Dealership Physical Address</p>
                <p>{{ $contract->dealer_physical_address }}</p>
                <p>{{ $contract->dealer_physical_city }}, {{ $contract->dealer_physical_state }} {{ $contract->dealer_physical_zip }}</p>
                <p>Qualified Individual: {{ $contract->dealer_qi_name }}</p>
                <p>Qualified Individual Email: {{ $contract->dealer_qi_email }}</p>
            </div>
            <div class="w-1/2">
                <p class="mb-5">Dealership Billing Address</p>
                <p>{{ $contract->dealer_billing_address }}</p>
                <p>{{ $contract->dealer_billing_city }}, {{ $contract->dealer_billing_state }} {{ $contract->dealer_billing_zip }}</p>
                @if($contract->dealer_billing_fax)
                    <p>Fax: {{ $contract->dealer_billing_fax }}</p>
                @endif
                <p>Other Contact Name: {{ $contract->dealer_billing_contact_name }}}</p>
                <p>Other Contact Title: {{ $contract->dealer_billing_contact_title }}</p>
                <p>Other Contact Email: {{ $contract->dealer_billing_contact_email }}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
