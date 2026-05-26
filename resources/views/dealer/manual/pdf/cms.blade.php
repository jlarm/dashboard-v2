@extends('dealer.manual.pdf._layout', [
    'dealershipName' => $cms->store->name,
    'manualTitle' => 'Compliance Management System',
])

@section('content')

@php $variant = $variant ?? 'all'; @endphp

@if ($variant !== 'body')
{{-- Cover page --}}
<div class="cover">
    <x-application-logo class="cover__logo" />
    <h1 class="cover__dealership">{{ $cms->store->name }}</h1>
    <p class="cover__title">Compliance Management System</p>
    <div class="cover__meta">
        <div class="cover__meta-date">Effective Date</div>
        <div>{{ $cms->created_at->format('F j, Y') }}</div>
        <div style="margin-top: 0.12in;">
            {{ $cms->store->address }}<br>
            {{ $cms->store->city }}, {{ $cms->store->state }} {{ $cms->store->postal_code }}<br>
            Phone: {{ $cms->store->phone }}@if($cms->store->fax)<br>Fax: {{ $cms->store->fax }}@endif
        </div>
    </div>
</div>

{{-- ARMP representative review log --}}
<div class="cover-signatures-page">
    <h2 class="cover-signatures-page__title">ARMP Review Log</h2>
    <p class="cover-signatures-page__subtitle">For ARMP representative use only.</p>
    <table class="cover-signatures">
        <thead>
            <tr>
                <th style="width:35%">Date</th>
                <th>ARMP Representative Signature</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 6; $i++)
                <tr><td></td><td></td></tr>
            @endfor
        </tbody>
    </table>
</div>

@endif

@if ($variant !== 'cover')
{{-- Body content --}}
<div class="body">
@php
    $cmsSig = static function (?string $filename): string {
        if ($filename === null || $filename === '') {
            return '';
        }
        $path = storage_path('app/cms-signatures/'.$filename);
        if (! file_exists($path)) {
            return '';
        }
        $data = 'data:image/png;base64,'.base64_encode((string) file_get_contents($path));
        return '<img src="'.$data.'" alt="Signature" style="max-height: 0.8in; margin-top: 0.1in;"/>';
    };
@endphp
{{--        Compliance Management System Program--}}
        <div>
            <h2>Compliance Management System Program</h2>
            <section>
                <h3 class="font-bold">I. Purpose</h3>
                <p>Dealership is committed to complying with the letter and spirit of Federal and State laws and regulations designed to protect consumers, customers and employees. Dealership compliance is the responsibility of each owner, board member, manager and employee. Dealership has created a Compliance Management System (CMS) to ensure compliance in all aspects of day-to-day business operations. The CMS has been created to establish compliance responsibilities, provide necessary training, review and audit compliance systems and procedures, take necessary corrective action, and manage and respond to consumer complaints.</p>
            </section>
            <section>
                <h3 class="font-bold">II. Scope</h3>
                <p class="font-bold">a. Persons Covered</p>
                <p>This Program, which includes all components and policies to this Program applies to all employees, agents, and/or independent contractors of Dealership who are involved in any aspect of Dealership operations. Failure to comply with any requirement in this Program, or to follow compliance procedures and requirements may result in disciplinary action, including termination of employment and/or the agency or independent contractor relationship.
                </p>
                <p class="font-bold">b. Operations Covered</p>
                <p>This Program applies to all facets of Dealership operations. Compliance practices and procedures are in place for compliance with Consumer Privacy (Gramm–Leach–Bliley), Finance and Insurance (Truth in Lending Act, Equal Credit Opportunity Act, Fair Credit Reporting Act, OFAC), Identify and deter identity theft (Red Flags), and work place safety (OSHA).</p>
                <p class="font-bold">c. Responsibility</p>
                <p>It is each employee’s responsibility to understand and institute Dealership’s compliance policies and procedures. Employees will be provided training for aspects of the compliance program that apply to their duties and responsibilities. Employees are encouraged to bring compliance concerns to the attention of their immediate supervisor or the named Qualified Individual.</p>
            </section>
            <section>
                <h3 class="font-bold">III. Compliance Programs</h3>
                <p>Dealership has in place the following compliance programs;</p>
                <p class="font-bold">a. Privacy and protection of Consumer information</p>
                <p>An Information Security Plan (ISP) providing for the protection and security of customer non-public information. The ISP covers both physical and electronic procedures to maintain sensitive information in a secure manner, and policies that limit what types of information and to whom customer information may be shared with, and who will have access to said information.</p>
                <p class="font-bold">b. Financial</p>
                <p>Compliance with Office of Foreign Assets Control (OFAC) and Financial Crimes Enforcement Network (FINCEN), and Rule 8300 reporting.</p>
                <p class="font-bold">c. Identity Theft Prevention</p>
                <p>An Identity Theft Prevention Program establishing reasonable policies and procedures to:</p>
                <p>Identify the red flags of identity theft that may occur in day-to-day operations; to detect the red flags identified; appropriate actions to take when red flags are detected; and monitoring to update for new identified identity theft threats.</p>
                <p class="font-bold">d. Fair Lending</p>
                <p>The adoption of fair lending statements and procedures approved by ownership, training for employees, auditing and revision and correction for compliance with consumer financial protection laws and regulations.  Dealership Complies with the Equal Credit Opportunity Act and Regulation B, and will not tolerate discrimination in any form, either direct or indirect, from any employee, agent or contractor.</p>
                <p class="font-bold">e. Consumer Complaints</p>
                <p>Establish designated personnel to receive consumer complaints, procedures to categorize received complaints, and procedures to respond to and document final resolution of received complaints.</p>
                <p class="font-bold">f. Occupational Safety and Health OSHA</p>
                <p>Training, reviews and audits for compliance with worker safety. Creation and maintenance of OSHA compliance manuals and training records.</p>
            </section>
            <section>
                <h3>IV. Appointment of Qualified Individual</h3>
                <p>Upon adoption of this Program, the Dealership’s Board of Directors will appoint (and, thereafter, replace as necessary or appropriate) a Qualified Individual, or Officers as the case may be, who will administer the CMS Program. The Qualified Individual will report directly to Ownership and/or the Board of Directors.</p>
            </section>
            <section>
                <h3>V. Automotive Risk Management Partners</h3>
                <p>Dealership has contracted with Automotive Risk Management Partners (ARMP) to provide consulting, training, auditing and review in the establishment of the Dealership CMS.  ARMP will provide training, review procedures and consult with the Qualified Individual and Management regarding compliance responsibilities, programs, create manuals for compliance and compliance record keeping, discuss best practices, audit finance transactions, audit compliance, and consult with management regarding compliance strengths, weaknesses, concerns and modifications that may be required.</p>
            </section>
            <section>
                <h3>VI. Adoption and Approval</h3>
                <p>Dealership’s Board of Directors hereby adopts and approves the Dealership Compliance Management System as set forth above.</p>
            </section>
            <p>Dated this {{ $cms->created_at->format('jS') }} day of {{ $cms->created_at->format('F') }}, {{ $cms->created_at->format('Y') }}.</p>
            <div class="grid grid-cols-3 gap-5">
                @if($cms->adoption_approval_signature_one)
                <div>
                    {!! $cmsSig($cms->adoption_approval_signature_one) !!}
                    <p>{{ $cms->adoption_approval_name_one }}</p>
                </div>
                @endif
                @if($cms->adoption_approval_signature_two)
                <div>
                    {!! $cmsSig($cms->adoption_approval_signature_two) !!}
                    <p>{{ $cms->adoption_approval_name_two }}</p>
                </div>
               @endif
                @if($cms->adoption_approval_signature_three)
                <div>
                    {!! $cmsSig($cms->adoption_approval_signature_three) !!}
                    <p>{{ $cms->adoption_approval_name_three }}</p>
                </div>
               @endif
            </div>
        </div>
        {{--        Dealer Participation Program--}}
        <div>
            <h2>Dealer Participation Program</h2>
            <p>As part of its Fair Lending Policy, Dealership is instituting a Dealer Participation Program (DPP). To reduce the risk of any disparate impact in the financing transaction, and to comply with requirements established by the CFPB which has direct jurisdiction over many Dealer financing sources, Dealership is establishing a Dealer Participation Program (DPP). The Dealer Participation Program consists of five parts:</p>
            <p>1. An up-to-date fair lending policy statement approved by management setting a standard markup for non-subvented loans, and establishing exceptions to the standard markup based solely on legitimate business needs.  Dealership has adopted a policy of a dealer participation rate of
                {{ $cms->standard_dpp_rate }} .</p>
            <p>2. Regular fair lending training for all employees involved with any aspect of the Dealership’s finance transactions, including managers and officers;</p>
            <p>3. Ongoing monitoring for compliance with fair lending policies and procedures, and the Dealer Participation Program;</p>
            <p>4. Audit of policies, and finance transactions for potential fair lending violations, including potential disparate impact;</p>
            <p>5. Revision of policies and procedures, and prompt corrective action when analysis identifies unexplained disparities on a prohibited basis;</p>
            <p>The Dealer Participation Program form to be used when there are deviations from the DPP established buy rate provides exceptions to the established buy rate under the DPP based upon legitimate business exceptions, and as previously provided in Consent Decrees entered into by the Department of Justice in the settlement of previous disparate impact claims related to Dealer markup.</p>
            <p>Adopted and approved by the Board of Directors for {{ $cms->store->name }} this {{ $cms->created_at->format('jS') }} day of {{ $cms->created_at->format('F') }}, {{ $cms->created_at->format('Y') }}</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @if($cms->dealer_participation_program_signature)
                <div>
                    {!! $cmsSig($cms->dealer_participation_program_signature) !!}
                    <p>{{ $cms->dealer_participation_program_name }}</p>
                </div>
                @endif
            </div>
        </div>
        {{--        Dealer Participation Program Form--}}
        <section>
            <h2>Dealer Participation Program Form</h2>
            <div class="max-w-3xl text-sm space-y-10">
                <div class="grid grid-cols-4 gap-5">
                    <div class="col-span-3 flex items-end">
                        <span>Customer:</span>
                        <div class="relative w-full">
                            <label>
                                <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                            </label>
                            <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="grid-cols-1 flex items-end">
                        <span>Date: </span>
                        <div class="relative w-full">
                            <label>
                                <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                            </label>
                            <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="col-span-2 flex items-end">
                        <span>Standard DPP Rate: </span>
                        <div class="relative w-auto">
                            <label>
                                <input disabled placeholder="{{ $cms->standard_dpp_rate }}" type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                            </label>
                            <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="col-span-2 flex items-end">
                        <span>Final DPP Rate: </span>
                        <div class="relative w-auto">
                            <label>
                                <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                            </label>
                            <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
                <p class="italic">If the Final DPP Rate does not equal the Standard DPP Rate, complete the form below.  If the customer did not identify a specific source or amount of a competing rate, indicate “not identified”.</p>
                <div class="space-y-10">
                    <div class="space-y-2">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">Financing source imposed participation rate less than DPP Rates.</label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Financing source participation rate capped at: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="comments">Customer qualifies for Dealer participation program (employee, family member, or other program qualified individual).</label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">Customer negotiated rate.</label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Rate offered: </span>
                            <div class="relative w-auto">
                                <label class="w-auto">
                                    <input disabled type="text" class="peer block w-[300px] border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Customer Counter: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-[260px] border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Agreed Rate: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-[300px] border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Customer Sources: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-[260px] border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>And/Or Competing Rate: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-[223px] border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">Dealer Promotion.</label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Identify Promotion Program: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">PTI Constraint.</label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <span>Monthly payment limitation of $</span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-start">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">Subvented Rate</label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="comments">Inventory reduction considerations (describe approximate number of days in inventory, approximate number in stock, declining value of vehicle, etc.)
                                </label>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <label class="w-full">
                                <textarea disabled rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="grid grid-cols-5 gap-5">
                        <div class="col-span-3 flex items-end">
                            <span>Signature:</span>
                            <div class="relative w-full">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="grid-cols-1 flex items-end">
                            <span>Title: </span>
                            <div class="relative w-full">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-end">
                            <span>Date: </span>
                            <div class="relative w-auto">
                                <label>
                                    <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                </label>
                                <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex flex-start">
                            <div class="relative flex items-start">
                                <div class="text-sm leading-6">
                                    <label for="comments">Approved</label>
                                </div>
                            </div>
                            <div class="flex items-end w-full">
                                <div class="relative">
                                    <label>
                                        <input disabled type="text" class="peer block w-full border-0 py-0 sm:text-sm">
                                    </label>
                                    <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2" aria-hidden="true"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs -mt-0">Manager (shall not have participated in the credit decision) </p>
                    </div>
                </div>
            </div>
            <p>The Equal Credit Opportunity Act makes it illegal for a "creditor" to discriminate in any aspect of a credit transaction because of race, color, religion, national origin, sex, marital status, age, receipt of income from any public assistance program, or the exercise, in good faith, of a right under the Consumer Credit Protection Act.
            </p>
        </section>
        {{--        Appointment and Program Approval--}}
        <div>
            <h2>Appointment and Program Approval</h2>
            <p>The following employee has been appointed as {{ tenant('name') }} Fair Credit Compliance Program Coordinator:</p>
                <p class="font-black">{{ $cms->qi_name }}</p>
            <p>Dealership has adopted and approved a Fair Credit Compliance Policy and Program to be implemented throughout the dealership.</p>
            <p>By signing below, the undersigned, constituting all of the members of the Dealership Board of Directors, acknowledge the Board’s approval of the foregoing Dealership Fair Credit Policy and Fair Credit Compliance Program and its appointment of the Dealership Fair Credit Compliance Program.</p>
            <p>Coordinator this {{ $cms->created_at->format('jS') }} day of {{ $cms->created_at->format('F') }}, {{ $cms->created_at->format('Y') }}.</p>
            <div class="grid grid-cols-3 gap-5">
                @if($cms->appointment_program_signature_one)
                <div>
                    {!! $cmsSig($cms->appointment_program_signature_one) !!}
                    <p>{{ $cms->appointment_program_name_one }}</p>
                </div>
                @endif
                @if($cms->appointment_program_signature_two)
                <div>
                    {!! $cmsSig($cms->appointment_program_signature_two) !!}
                    <p>{{ $cms->appointment_program_name_two }}</p>
                </div>
                @endif
                @if($cms->appointment_program_signature_three)
                <div>
                    {!! $cmsSig($cms->appointment_program_signature_three) !!}
                    <p>{{ $cms->appointment_program_name_three }}</p>
                </div>
                @endif
            </div>
        </div>
        {{--        Acknowledgement--}}
        <div>
            <h2>Acknowledgement</h2>
            <p>The undersigned does hereby acknowledge receipt and review of Dealership Fair Credit Compliance Program, and agrees to the terms contained therein.</p>
            <p>Dated: {{ $cms->created_at->format('F d, Y') }}</p>
            <div class="grid grid-cols-3 gap-5">
                <div>
                    {!! $cmsSig($cms->acknowledgement_signature) !!}
                    <p>{{ $cms->acknowledgement_name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
