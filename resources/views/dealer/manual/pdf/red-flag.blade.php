<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="w-full p-5">
    <div class="h-screen">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto"/>
            {{--            @if($redFlag->store->logo)--}}
            {{--                <img--}}
            {{--                    class="w-full h-25 py-20 mx-auto"--}}
            {{--                    src="{{ asset($redFlag->store->logo) }}"--}}
            {{--                    alt="">--}}
            {{--            @endif--}}
            <h1 class="text-3xl font-bold text-arm-blue-600">{{ tenant('name') }}</h1>
            <h1 class="text-3xl font-bold text-arm-blue-600">Red Flags Rules</h1>
            <p class="text-arm-blue-400">{{ $redFlag->created_at->format('F d, Y') }}</p>
            <p>
                {{ $redFlag->store->address }}<br/>
                {{ $redFlag->store->city }}, {{ $redFlag->store->state }} {{ $redFlag->store->postal_code }}
            </p>
            <p>
                Phone: {{ $redFlag->store->phone }}<br/>
                @if($redFlag->store->fax)
                    Fax: {{ $redFlag->store->fax }}
                @endif
            </p>
        </div>
        <table class="w-full max-w-4xl mx-auto divide-y divide-gray-300 mt-10">
            <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">ARMP Rep Signature
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <tr>
                <td class="whitespace-nowrap py-8 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                <td class="whitespace-nowrap px-8 py-8 text-sm text-gray-500"></td>
            </tr>
            <tr>
                <td class="whitespace-nowrap py-8 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                <td class="whitespace-nowrap px-8 py-8 text-sm text-gray-500"></td>
            </tr>
            <tr>
                <td class="whitespace-nowrap py-8 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                <td class="whitespace-nowrap px-8 py-8 text-sm text-gray-500"></td>
            </tr>
            <tr>
                <td class="whitespace-nowrap py-8 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                <td class="whitespace-nowrap px-8 py-8 text-sm text-gray-500"></td>
            </tr>
            <tr>
                <td class="whitespace-nowrap py-8 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                <td class="whitespace-nowrap px-8 py-8 text-sm text-gray-500"></td>
            </tr>
            </tbody>
            <div>
                <div>

                </div>
            </div>
        </table>
    </div>
    <ul>
        <li class="py-10 space-y-5 page-break">
            <table class="w-full max-w-4xl mx-auto divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Name
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone Number</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->owner_name }}</div>
                                <div class="mt-1 text-gray-500">Owner</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->owner_phone }}</td>
                </tr>
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->general_manager_name }}</div>
                                <div class="mt-1 text-gray-500">General Manager</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->general_manager_phone }}</td>
                </tr>
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->body_shop_manager_name }}</div>
                                <div class="mt-1 text-gray-500">Body Shop Manager</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->body_shop_manager_phone }}</td>
                </tr>
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->parts_manager_name }}</div>
                                <div class="mt-1 text-gray-500">Parts Manager</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->parts_manager_phone }}</td>
                </tr>
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->service_manager_name }}</div>
                                <div class="mt-1 text-gray-500">Service Manager</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->service_manager_phone }}</td>
                </tr>
                <tr>
                    <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redFlag->qualified_individual_name }}</div>
                                <div class="mt-1 text-gray-500">Qualified Individual</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $redFlag->qualified_individual_phone }}</td>
                </tr>
                </tbody>
            </table>
        </li>
    </ul>
    <div class="prose mx-auto">
        <div id="red-flag-rule">
            <h2>Red Flag Rule</h2>
            <p>The Federal Trade Commission and the federal financial institution regulatory agencies have sent to the
                Federal Register for publication final rules on identity theft “red flags” and address discrepancies.
                The final rules implement the Identity Theft Rules (16 C.F.R part 681) in compliance with sections 114
                (Red Flags Rule) and 315 (Address Discrepancy Rule) of the Fair and accurate Credit Transactions Act of
                2003 (Fact Act), 15 U.S.C. 1681m (e) and 15 U.S.C. 1681c (h). </p>
            <p>According to a report of the President’s Identity Theft Task Force, identity theft (a fraud attempted or
                committed using identifying information of another person without authority), results in billions of
                dollars in losses each year to individuals and businesses.</p>
            <p>The final rules require each financial institution and creditor that holds any consumer account, or other
                account for which there is a reasonably foreseeable risk of identity theft, to develop and implement an
                Identity Theft Prevention Program (“ITPP” or “Program”) for combating identity theft in connection with
                new and existing accounts. The Program must include reasonable policies and procedures for detecting,
                preventing, and mitigating identity theft and enable a financial institution or creditor to: </p>
            <ol>
                <li>
                    Identify relevant patterns, practices, and specific forms of activity that are “red flags” signaling
                    possible identity theft and incorporate those red flags into the Program;
                </li>
                <li>Detect red flags that have been incorporated into the Program;</li>
                <li>Respond appropriately to any red flags that are detected to prevent and mitigate identity theft;
                    and
                </li>
                <li>Ensure the Program is updated periodically to reflect changes in risks from identity theft.</li>
            </ol>
            <p>The agencies also issued guidelines to assist financial institutions and creditors in developing and
                implementing a Program, including a supplement that provides examples of red flags.</p>
            <p>The final rules also require credit and debit card issuers to develop policies and procedures to assess
                the validity of a request for a change of address that is followed closely by a request for an
                additional or replacement card. In addition, the final rules require users of consumer reports to
                develop reasonable policies and procedures to apply when they receive a notice of address discrepancy
                from a consumer reporting agency.</p>
            <p>The attached final rulemaking is issued by the Board of Governors of the Federal Reserve System, the
                Federal Deposit Insurance Corporation, the Federal Trade Commission, the National Credit Union
                Administration, the Office of the Comptroller of the Currency, and the Office of Thrift Supervision.
                <strong>The
                    final rules were effective on January 1, 2008 but FTC mandated compliance by January 1,
                    2011.</strong>
            </p>
        </div>
        <div id="identity-theft">
            <h2>Identity Theft Prevention Program, Address Discrepancy Rule, Red Flag Rules</h2>
            <h3>Objectives</h3>
            <p>The objectives of this program are to establish the necessary policies and procedures through a written
                Identity Theft Prevention Program (ITPP) to assist the dealership with the detection, prevention and
                mitigation of identity theft. Specific policies and procedures are also included to comply with The
                Address Discrepancy and Red Flag Rules.</p>
            <p>This Program and the rules outlined shall be implemented and maintained by the Compliance Security
                Officer, <strong>{{ $redFlag->qualified_individual_name }}</strong> and any ITPP Coordinator(s) (not a
                required position).
                <strong>{{ tenant('name') }}</strong> has
                contracted with Automotive Risk Management Partners to assist in the formation, implementation,
                performance, monitoring and recommendations to this program. Qualified Individualx shall report to board
                or equivalent on any updates, changes or issues that arise that would jeopardize this program.</p>
            <p>The specific objectives of the program are as follows:</p>
            <ol>
                <li>Appoint an ITPP Qualified Individual and ITPP Program
                    Coordinator(s) (ITPP Coordinator is an optional position,
                    Qualified Individual will assume this role)
                </li>
                <li>Determine the Covered accounts offered and/or maintained.</li>
                <li>Identify relevant indicators of possible identity theft “Red
                    Flags” for the covered accounts.
                </li>
                <li>Develop procedures for detecting those Red Flags.</li>
                <li>Develop procedures for responding to relevant Red Flags detected.</li>
                <li>Ensure approval by the board of directors or a member of senior
                    management, and to document regular updates given to
                    responsible party or parties.
                </li>
            </ol>
            <p>This program will be overseen by the of <strong>{{ $redFlag->qualified_individual_name }}</strong> of
                <strong>{{ tenant('name') }}</strong>. <strong>{{ $redFlag->qualified_individual_name }}</strong> will
                be responsible for overseeing the implementation and maintenance of the ITTP including assisting
                Automotive Risk Management Partners with the creation of a written report to be delivered to Board or
                equivalent on at least an annual basis.</p>
            <h3>Covered Accounts:</h3>
            <p>Covered Accounts consist of all consumer transactions involving multiple payments (even if immediately
                assigned to a third party) and any other multiple payment accounts (including business accounts) where
                there is a reasonably foreseeable risk of identity theft to <strong>{{ tenant('name') }}</strong> and or
                our customers. The
                covered accounts consist of:</p>
            <ol>
                <li>All retail installment or lease contracts that are assigned to a third party.</li>
                <li>All retail installment or lease contracts that are kept in house and maintained by
                    <strong>{{ tenant('name') }}</strong>.
                </li>
                <li>Any Accounts receivables carried in the service department for customers
                    making multiple or delayed payments on service work performed (including Business Accounts where
                    there is a reasonable foreseeable risk to identity theft).
                </li>
                <li>Any Accounts receivables in the Parts department (including business Accounts where there is a
                    reasonable foreseeable risk to identity theft).
                </li>
            </ol>
            <p><strong>{{ tenant('name') }}</strong> will use account identification and risk assessment worksheet to
                properly identify each covered account that exists and make part of this ITPP.</p>
        </div>
        <div id="methods-for-identifying">
            <h2>Methods for Identifying Relevant Red Flags</h2>
            <p>The Qualified Individual in conjunction with the ITPP coordinator(s) and ARMP will conduct an
                identification of the relevant Red Flags through a prescribed process. This process must consider the
                following areas:
            </p>
            <ul>
                <li>Risk Factors</li>
                <li>Categories of Red Flags</li>
                <li>Other sources of Red Flags</li>
            </ul>
            <p>The FTC and the federal banking regulatory agencies have identified 26 example red flags which are not
                confined to the automotive industry but were compiled with all financial institutions and creditors in
                mind. We have identified 21 of these as relevant to our organization and the automotive industry. These
                red flags will be assessed on a semiannual basis and at that time any potential new red flags will be
                examined by the Qualified Individual and ARMP in order to update this ITPP and to ensure that we are
                consistently mitigating the affects of Identity Theft within <strong>{{ tenant('name') }}</strong>.</p>
            <p>When addressing the risk factors for the purpose of identifying the relevant red flags we must analyze
                the methods <strong>{{ tenant('name') }}</strong> has employed to open and access the Accounts and
                <strong>{{ tenant('name') }}</strong>’s previous
                experience with identity theft. When assessing the risk factors within
                <strong>{{ tenant('name') }}</strong> we must look at these
                relevant processes:</p>
            <ul>
                <li>Who is responsible for accepting the credit statements from the potential customer?</li>
                <li>Who is responsible for actually running the credit bureau?</li>
                <li>Who makes the ultimate decision to complete the transaction?</li>
                <li>Who actually talks with the potential customer?</li>
                <li>Where are all the Accounts stored?</li>
                <li>Where are the Accounts kept while in progress?</li>
            </ul>
            <p>Given the risk factors of <strong>{{ tenant('name') }}</strong>, the responsible party for accepting
                credit applications will be a
                Sales or Finance Manager. All credit bureaus will be run by a Sales or Finance Manager. The ultimate
                decision to proceed with the transaction will be assumed by the Sales and / or Finance Managers in
                consultation with the Qualified Individual who will sign off on the deal only after considering the
                categories of the red flags and running the prospect through dealership’s Red Flag check software or
                other third party systems. If at any time there needs to be a discussion with the prospect, it shall be
                conducted by a Sales Manager, Finance Manager or Qualified Individual. All Accounts should be stored in
                locked secure areas per the requirements of Gramm, Leach, Bliley and the safeguards rule.</p>
            <p>When identifying the relevant red flags, the categories that must be considered are:</p>
            <ul>
                <li>Alerts, notifications, or other warnings received from CRAs (credit reporting agencies) or other
                    service providers, such as fraud detection services (Dealerships Red Flag Check ID theft software).
                </li>
                <li>The presentation of suspicious documents.</li>
                <li>The presentation of suspicious personal identifying information such as suspicious address change.
                </li>
                <li>The unusual use of, or suspicious activity related to covered Accounts.</li>
                <li>Notice from customers, victims of identity theft, Law enforcement authorities, or other persons
                    regarding possible identity theft in connection with your covered Accounts.
                </li>
            </ul>
            <p>When identifying relevant red flags, it is important that the Dealership takes into consideration all
                previous identity theft incidents, as they are clear indicators of future identity theft. The tactics
                used by identity thieves are ever evolving. The Qualified Individual will keep a log of identity theft
                incidents in order to identify any patterns or nuances within the Dealership and the Qualified
                Individual will identify methods of identity theft that reflect changes in identity theft risks.</p>
        </div>
        <div id="detect">
            <h2>Developing the means to detect Red Flags and Verify Identity.</h2>
            <p>Although the procedures may vary depending on the type of Accounts involved, identity verification is a
                standard operating procedure for <strong>{{ tenant('name') }}</strong> to use for any person seeking to
                conduct business with
                <strong>{{ tenant('name') }}</strong>. The Qualified Individual in conjunction with the ITPP Coordinator
                (if assigned) will use
                the Red Flag Identification, Detection, and Response worksheets/software to determine the relevant Red
                Flags. <strong>{{ tenant('name') }}</strong> has adopted the following identity theft identification
                detection process using the
                following means:
            </p>
            <ul>
                <li>Obtain identifying information about, and verifying the identity of, a person opening a covered
                    account.
                </li>
                <li>Where the dealership maintains a covered accounts after it is opened, authenticating customers,
                    monitoring transactions, and verifying the validity of change of address requests.
                </li>
                <li>The process {{ tenant('name') }} will employ for verifying the identity of unknown persons seeking
                    to open a
                    Covered Accounts will be referred to as the;
                </li>
            </ul>
            <p>Unknown Customer Identity Verification Process which follows;</p>
        </div>
        <div id="unknown">
            <h2>Unknown Customer Identity Verification Process</h2>
            <ol>
                <li>Collect a copy of the individuals Driver’s License and match the picture and Physical description
                    to the customer.
                    <ul>
                        <li>Closely inspecting documents provided for identification.</li>
                        <li>Collect a copy to be contained in the folder.</li>
                    </ul>
                </li>
                <li>Check the credit bureau to see if there are any notices of fraud, active-duty alerts, credit
                    freezes, or
                    notices of address discrepancies.
                    <ul>
                        <li>Circle and initial this area on the printed report.</li>
                    </ul>
                </li>
                <li>Verify information given by customer with information on the credit bureau.
                    <ul>
                        <li>Compare that information with any other information {{ tenant('name') }} has on file.</li>
                    </ul>
                </li>
                <li>If deemed necessary, collect additional items that would provide a comfort level such as insurance
                    card, additional credit cards, weapons cards, verify signature from other forms of identity.
                </li>
                <li>Ask verification questions based on information contained in the credit report.
                    <ul>
                        <li>Listen carefully for suspicious statements by the credit applicant.</li>
                    </ul>
                </li>
                <li>Run your Red Flag Identity Verification tool through any number of software systems provided by
                    dealership by entering the individual name, current address, date of birth, and the social security
                    number into the dealership’s software. Ask “Out of Pocket” questions if needed to further verify
                    customer’s identity. Only one number should appear in the SS# box.
                </li>
                <li>If questions are correctly answered and the above steps are satisfactory, then print off the final
                    sheet to verify the process was done and proceed with the deal. Place a copy in deal jacket
                </li>
                <li>If there is a discrepancy in the data, there needs to be further investigation to determine if the
                    person is who they say they are.
                </li>
                <li>If management is comfortable with the fact that there is no identity issue then management needs
                    to make proper notes on the printed red flag check sheet to show why they are comfortable with
                    the deal and proceed as normal.
                </li>
                <li>If there is sufficient reason to suspect that some form of fraud has occurred or been attempted,
                    collect copies of as many documents as you can that pertain to the situation, stop any transaction
                    that is tied to this individual, and contact the local authorities.
                </li>
            </ol>
        </div>
        <div id="updating">
            <h2>Updating the ITPP</h2>
            <p>The Qualified Individual will update the ITPP on an annual basis with the assistance of ARMP and these
                updates will reflect the changes in risks that may have occurred in {{ tenant('name') }}
                . {{ tenant('name') }} will as part
                of but not limited to the updating process, review the identification of covered accounts and relevant
                red
                flags and re-assess the effectiveness of the current detection and response procedures. It is imperative
                that
                {{ tenant('name') }} take into consideration the following:</p>
            <ul>
                <li>Any and all experiences of {{ tenant('name') }} with identity theft.</li>
                <li>Changes in methods of identity theft (this is ever changing)</li>
                <li>Changes in methods to detect, prevent, and mitigate identity theft.</li>
                <li>Changes in types of Accounts that the dealership offers or maintains (i.e., dealer starts accepting
                    multiple payments from some customers for service work or opens an in-house financing
                    program)
                </li>
                <li>Changes in the business arrangements of the Dealership to include any mergers, acquisitions,
                    alliances, joint ventures, and service provider arrangements.
                </li>
            </ul>
            <p>If at any time {{ tenant('name') }} encounters a significant change such as a serious incident of
                identity theft or
                installation of a new credit report retrieval system, the Qualified Individual in conjunction with ARMP
                should immediately update the ITPP.</p>
        </div>
        <div id="policies">
            <h2>General Policies and Procedures for responding to detected Red Flags</h2>
            <p>{{ tenant('name') }} has developed procedures for responding to detected red flags, the response will
                depend on
                the nature and severity of the red flag detected and the quality and quantity of the red flags present
                in any
                one transaction. Not every response is appropriate in every circumstance which is why there needs to be
                a
                range of responses and we need to rely on the personal judgment of the Sales and Finance Managers.
                {{ tenant('name') }} personnel will respond appropriately to detected red flags to prevent and mitigate
                identity
                theft when opening or maintaining covered Accounts.</p>
            <ol>
                <li>Attached to this ITPP are the relevant red flags and the standard process for handling that specific
                    red flag. Dealership personnel need to be flexible knowing that there could be a range of responses
                    for each red flag. When a red flag is detected, it is to immediately be taken to a Sales, Finance
                    Manager or Qualified Individual for review and analysis.
                </li>
                <li>Many if not most of the detected red flags can be cleared through reasonable investigation by a
                    Sales or Finance Manager. When confronted with a red flag refer to the standard process
                    associated with this ITPP. If that is not sufficient then one of the Sales or Finance Manager should
                    sit with the prospect, credit statement (bureau), and red flag check to investigate the immediate
                    concerns with the prospect. If the Sales or Finance Manager feels comfortable with the situation
                    and there’s no concern for identity theft then proceed with the normal process for opening the
                    Accounts.
                </li>
                <li>There are some responses that do not allow for much flexibility such as Fraud alerts and / or
                    active-duty alerts. The Sales or Finance Manager must call the appropriate number listed on the
                    bureau to clarify that everything is ok. Once the Manager is comfortable with the situation then
                    proceed with the normal process. In the case where it’s considered that identity theft has occurred
                    or is being attempted, collect all information that is connected with the Accounts and call local
                    authorities to report the incident.
                </li>
                <li>Once it has been determined that identity theft has occurred or been attempted, it is the
                    responsibility of the dealership to contact the person whose identity has been used fraudulently
                    and inform them of the problem. The person contacting the victim should also recommend;
                    <ul>
                        <li>They put an alert on their credit report by contacting any 1 of the 3 credits
                            reporting agencies.
                        </li>
                        <li>Sign up for a credit monitoring service and or</li>
                        <li>Regularly monitor their credit information.</li>
                    </ul>
                </li>
            </ol>
        </div>
        <div id="program">
            <h2>Red Flag Rules Compliance Program Red Flags currently known in the automobile industry</h2>
            <div id="one">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #1 <span
                                    class="ml-1 font-normal">Fraud or active duty alert posted on a consumer
                                        report.</span></h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reading appropriate area(s) of all consumer reports pulled.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer report is pulled.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever a fraud or active-duty alert is included on a consumer report that is pulled either by the
                    dealership or a lending partner the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Contact the customer using the phone number or other contact information stated in the
                        alert, and obtain permission to proceed.
                    </li>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Documented proof of all procedures followed and copies of all presented material must be
                        included in
                        the deal folder.
                    </li>
                </ul>
            </div>
            <div id="two">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #2 <span
                                    class="ml-1 font-normal">Credit Reporting Agency reports a notice of a credit freeze.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reading appropriate area(s) of all consumer reports pulled.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer report is pulled.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever a notice of a credit freeze is given when a consumer report is requested by either the
                    dealership
                    or a lending partner, the following actions will be taken.</p>
                <p>Do not open an account unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Inform the customer that unless they take action to remove the freeze that the account
                        cannot be opened. Once the freeze has been lifted a consumer report must be taken to
                        verify.
                    </li>
                    <li>Follow all steps required in the Unknown Customer Verification Process, on page 10,
                        and complete to the satisfaction of management and / or the Red Flag Program
                        Qualified Individual.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="three">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #3 <span
                                    class="ml-1 font-normal">A consumer report provides a Notice of Address Discrepancy.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reading appropriate area(s) of all consumer reports pulled.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer report is pulled.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever a Notice of Address Discrepancy is included on a consumer report that is pulled either by
                    the
                    dealership or a lending partner the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                </ul>
            </div>
            <div id="four">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #4 <span
                                    class="ml-1 font-normal">A consumer report indicates a pattern of activity that is inconsistent with history and usual pattern of the applicant..</span>
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li>Recent and significant increases in the volume of inquiries.</li>
                                    <li>A recent surge in established credit relationships.</li>
                                    <li>Material changes in the use of credit with respect to recently established
                                        credit relationships,
                                    </li>
                                    <li>Accounts that have been closed for cause or identified for abuse of Accounts
                                        privileges.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reading appropriate area(s) of all consumer reports pulled.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer report is pulled.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever a Consumer Report contains unusual or inconsistent activity the following actions will be
                    taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="five">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #5 <span
                                    class="ml-1 font-normal">Documents provided for identification appear to have been altered or forged.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Carefully reviewing all presented documentation</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the consumer presents a document for identification that appears to have been altered or
                    forged
                    the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>At least one additional form of government provided identification and at least one
                        other form of identification must be presented that do not have the appearance of being
                        forged or altered.
                    </li>
                    <li>Management and the Red Flag Program Qualified Individual must be consulted and
                        view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="six">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #6 <span
                                    class="ml-1 font-normal">The photograph or physical description on the identification is not consistent with the appearance of the applicant or customer presenting the identification.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Carefully reviewing the applicants Drivers License or other government
                    issued photo identification.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the photograph or physical description on the identification is not consistent with the
                    appearance of the applicant the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>At least one additional form of government provided identification and at least one
                        other form of identification must be presented that do not have the appearance of being
                        forged or altered.
                    </li>
                    <li>Management and / or the Red Flag Program Qualified Individual must be consulted
                        and view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="seven">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #7 <span
                                    class="ml-1 font-normal">Other information on the identification is not consistent with information provided by the person opening a new covered Accounts or customer presenting the identification.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Carefully viewing the applicants Drivers License or other government
                    issued photo identification, and comparing to other information provided.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the other information on the identification is not consistent with information provided by
                    the
                    person opening a new covered Accounts or customer presenting the identification, the following
                    actions
                    will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>At least one additional form of government provided identification and at least one
                        other form of identification must be presented that do not have the appearance of being
                        forged or altered.
                    </li>
                    <li>Management and / or the Red Flag Program Qualified Individual must be consulted
                        and view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="eight">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #8 <span
                                    class="ml-1 font-normal">Other information on the identification is not consistent with readily accessible information that is on file with the financial institution or creditor, such as a signature card or a recent check.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Carefully viewing the applicants Drivers License or other government
                    issued photo
                    identification and comparing to other information provided by the creditor or is on
                    file with the dealership.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the other information on the identification is not consistent with information provided by
                    the
                    person opening a new covered Accounts or customer presenting the identification, the following
                    actions
                    will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Management and / or the Red Flag Program Qualified Individual must be consulted
                        and view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="nine">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #9 <span
                                    class="ml-1 font-normal">An application appears to have been altered or forged, or
gives the appearance of having been destroyed and
reassembled.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reviewing the application for signs of alteration, forgery, or having
                    been destroyed and reassembled.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the consumer presents an application appears to have been altered or forged, or gives the
                    appearance of having been destroyed and reassembled the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Management and / or the Red Flag Program Qualified Individual must be consulted
                        and view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="ten">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #10 <span
                                    class="ml-1 font-normal">Personal identifying information provided is inconsistent when compared against external information sources used by the financial institution or creditor.</span>
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li>The address does not match any address in the consumer report; or</li>
                                    <li>The Social Security Number (SSN) has not been issued, or is listed on the Social
                                        Security Administration’s Death Master File.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reading appropriate area(s) of all consumer reports pulled.
                    Notification in the Compliancesolved.com software.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer report is pulled.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever Personal identifying information provided is inconsistent when compared against external
                    information sources used by the financial institution or creditor the following actions will be
                    taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Verify that the correct information was typed into the software provided by dealership
                        and resubmit if necessary.
                    </li>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Collect copies of other documentation containing the SS# such as their Social Security
                        Card.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="eleven">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #11 <span
                                    class="ml-1 font-normal">Personal identifying information provided by the customer
is not consistent with other personal identifying
information provided by the customer.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing information on the different presented documents.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever identifying information provided by the consumer is not consistent with other information
                    provided the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Request additional documentation for proof of identification.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="twelve">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #12 <span
                                    class="ml-1 font-normal">Personal identifying information provided is associated
with known fraudulent activity as indicated by internal or
third-party sources used by the financial institution or
creditor.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Notification provided by creditor, credit reporting agency or any other outside source.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever personal identifying information provided is associated with known fraudulent activity as
                    indicated by internal or third-party sources used by the financial institution or creditor, the
                    following
                    actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="thirteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #13 <span
                                    class="ml-1 font-normal">Personal identifying information provided is of a type
commonly associated with fraudulent activity as indicated
by internal or third-party sources used by the financial
institution or creditor.</span>
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li>The address on the application is fictitious, a mail drop, a prison or;</li>
                                    <li>The phone number is invalid, or is associated with a pager or answering
                                        machine.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing information to that provided by any outside sources used by the dealership.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever Personal identifying information provided is of a type commonly associated with fraudulent
                    activity as indicated by internal or third-party sources used by the financial institution or
                    creditor the
                    following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="fourteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #14 <span
                                    class="ml-1 font-normal">The SSN provided is the same as that submitted by other
persons opening an Accounts or other customers.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the SSN provided is the same as that submitted by other persons opening an Accounts or other
                    customers the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Verify that the correct SSN was provided.
                    </li>
                    <li>Verify that the correct information was typed into the software provided by dealership
                        and resubmit if necessary.
                    </li>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Collect copies of other documentation containing the SS# such as their Social Security
                        Card.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="fifteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #15 <span
                                    class="ml-1 font-normal">The person opening the covered Accounts or the customer
fails to provide all required personal identifying
information on an application or in response to
notification that the application is incomplete.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Reviewing application information for completeness</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where an application is taken.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever the person opening the covered Accounts or the customer fails to provide all required
                    personal
                    identifying information on an application or in response to notification that the application is
                    incomplete
                    the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="sixteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #16 <span
                                    class="ml-1 font-normal">Personal identifying information provided is not consistent
with personal identifying information that is on file with
the financial institution or creditor.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Carefully view the applicants Drivers License or other
                    government issued photo identification and comparing to other
                    information provided by the creditor or is on file with the
                    dealership.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer is unknown.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever personal identifying information provided is not consistent with personal identifying
                    information that is on file with the financial institution or creditor the following actions will be
                    taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Management and / or the Red Flag Program Qualified Individual must be consulted
                        and view all forms of identification before continuing.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="seventeen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #17 <span
                                    class="ml-1 font-normal">When using the armp.app software, the
customer is unable to properly respond to the 2 questions
asked.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Use of the armp.app software</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts where a consumer is unknown.</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>When using the dealership’s software and the customer is unable to properly respond to the 2
                    questions
                    asked the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>If needed ask the customer a couple questions from information included in the
                        consumer report.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="eighteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #18 <span
                                    class="ml-1 font-normal">Signatures do not appear to conform on identification documents provided.</span>
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li>The signature on the driver’s license does not match that on the credit
                                        application.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing signatures on the different presented documents.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever signatures do not appear to conform on identification documents provided the following
                    actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Request additional signature documentation for proof of identification.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="nineteen">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #19 <span
                                    class="ml-1 font-normal">Personal identifying information provided by the customer
is known and associated with fraudulent activity as
indicated in alerts or warnings received by the creditor,
credit reporting agency or any law enforcement agency.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing information on presented documents with any alerts or warning received.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever identifying information provided by the consumer is not consistent with other information
                    provided the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Request additional signature documentation for proof of identification.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="twenty">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #20 <span
                                    class="ml-1 font-normal">A customer requests to have a vehicle from a sale or lease
transaction delivered to an offsite location other than a
facility of the dealership.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing information on the different presented documents.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever identifying information provided by the consumer is not consistent with other information
                    provided the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Request additional signature documentation for proof of identification.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <div id="twentyone">
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
                            <h3 class="text-sm font-medium text-red-800 mt-0 mb-0">Red Flags #21 <span
                                    class="ml-1 font-normal">A co-buyer or co-lessee cannot be present at the dealership
facility to sign the required documents.</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <p><strong>Detection by:</strong> Following the Unknown Identity Verification Process.
                    Comparing information on the different presented documents.</p>
                <p><strong>Applicable Accounts:</strong> All covered Accounts</p>
                <p><strong>Action(s) to be taken when detected;</strong></p>
                <p>Whenever identifying information provided by the consumer is not consistent with other information
                    provided the following actions will be taken.</p>
                <p>Do not open an Accounts unless the following procedures are satisfactorily completed and
                    documented.</p>
                <ul>
                    <li>Follow all steps required in the Unknown Customer Verification Process and complete
                        to the satisfaction of management and / or the Red Flag Program Qualified Individual.
                    </li>
                    <li>Ask the customer for an explanation of the condition. An explanation must be given
                        that explains the condition without being indicative of fraud.
                    </li>
                    <li>Request additional signature documentation for proof of identification.
                    </li>
                    <li>Documented proof of all procedures followed, and copies of all presented
                        material must be included in the deal folder.
                    </li>
                </ul>
            </div>
            <p>{{ tenant('name') }} will train all relevant personnel within the dealership with the assistance of
                ARMP to ensure that everyone knows the process that is being instituted. All relevant
                personnel involved in opening covered accounts, working with existing accounts (if any),
                or anyone requesting or using credit reports. All relevant new personnel will be trained
                within 90 days of employment. All personnel will sign an acknowledgment once they have
                been through the Red Flag Rules Identity Theft Prevention training program. In addition to
                the Red Flag Rules Identity Theft Prevention training, relevant personnel will be trained in
                the use of their dealership software. It will be the responsibility of the Qualified Individual
                to identify all personnel that require training and work with ARMP to ensure they are
                trained within the 90 day timeframe.</p>
        </div>
        <div id="acknowledgement">
            The undersigned employee acknowledges {{ tenant('name') }} has instituted an Identity
            Theft Prevention Program (hereinafter referred to as ITPP), and agrees to comply with its
            practices and procedures. Employee agrees to abide by the policies contained in the ITPP,
            and to take all necessary steps and precautions to help detect, prevent and mitigate identity
            theft. I will follow employer procedures to prevent Identity Theft in accordance with the
            ITPP. I further acknowledge that intentional violation of procedures and policies set
            forth in the ITPP, may result in my termination.
        </div>
        <div id="oversee">
            <h2>Overseeing Service Providers</h2>
            <p>Any third-party service provider that is engaged in an activity in connection with one or more covered
                Accounts, {{ tenant('name') }} will ensure that the activity of the service provider is conducted in
                accordance
                with reasonable policies and procedures designed to detect, prevent, and mitigate the risk of identity
                theft.
                All service providers will sign off on a service provider agreement requiring the service provider to
                have
                policies and procedures in place to detect relevant red flags that may arise in the performance of the
                service provider’s activities, and either report the red flags to {{ tenant('name') }} or take
                appropriate steps to
                prevent or mitigate identity theft.</p>
            <p>{{ tenant('name') }}’s covered Accounts are limited to installment sale contracts and leases which are
                immediately assigned to finance sources and no Accounts are maintained and or serviced, thus
                {{ tenant('name') }} does not retain any service provider to maintain or service these accounts.
                {{ tenant('name') }} does not outsource the actual Accounts opening function.</p>
            <p>There are some examples of possible arrangements of the user of service providers in the opening of
                covered accounts and if at any time this occurs, {{ tenant('name') }} will have this service provider
                sign the
                appropriate acknowledgment attached to this ITPP.</p>
            <ul>
                <li>A broker or other third party acting on behalf of the dealer secures the customers signature on
                    installment sale contracts or leases.
                </li>
                <li>A vendor of identity theft prevention services retained by the dealer performs the duties of the
                    dealer under the Red Flags Rule with the respect to each potential covered Accounts.
                </li>
            </ul>
            <p>The Qualified Individual will deliver a report to {{ $redFlag->owner_name }} on an annual basis covering
                the
                following:</p>
            <ol>
                <li>The effectiveness of the policies and procedures of the dealership in addressing the risk of
                    identity
                    theft in connection with the opening of covered Accounts and with respect to existing Accounts.
                </li>
                <li>Service provider arrangements.</li>
                <li>Significant incidents involving identity theft and management’s response.</li>
                <li>Recommendations for material changes to the program.</li>
            </ol>
            <p>{{ tenant('name') }} and/or the board of directors will be responsible for reviewing the above reports
                and
                approving any material changes necessary to address changing identity theft risks. {{ tenant('name') }},
                a
                member of the board of directors, or a member of senior management will sign off on this ITPP and
                approve its mission.</p>
        </div>
        <div id="understand">
            <h2>Acceptance of procedures for Address Discrepancy, Red Flag Rules, and Identity Theft Mitigation</h2>
            <p>I the undersigned accept the Procedures contained herein and agree to implement
                them to the best ability possible. {{ tenant('name') }} has received their Red Flag program and
                have been trained on the Red Flag Check dealership software and the procedures contained
                herein.</p>
        </div>
        <p>{{ $redFlag->user->name }}</p>
        <img src="{{ storage_path() }}/app/red-flag-signatures/{{ $redFlag->signature }}" alt="Signature"/>
    </div>
</div>
</body>
</html>
