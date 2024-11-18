<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="w-full p-5 pt-0">
    <div class="h-screen">
        <div class="space-y-5 text-center">
            <x-application-logo class=" h-12 w-auto mx-auto"/>
            <h1 class="text-3xl font-bold text-arm-blue-600">{{ $isp->store->name }}</h1>
            <h1 class="text-3xl font-bold text-arm-blue-600">Information Security Program</h1>
            <p class="text-arm-blue-400">{{ $isp->created_at->format('F d, Y') }}</p>
            <p>
                {{ $isp->store->address }}<br/>
                {{ $isp->store->city }}, {{ $isp->store->state }} {{ $isp->store->postal_code }}
            </p>
            <p>
                Phone: {{ $isp->store->phone }}<br/>
                @if($isp->store->fax)
                    Fax: {{ $isp->store->fax }}
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
    <div class="h-screen prose max-w-full">
        <h1>Table of Contents</h1>
        <div class="space-y-6">
            <span class="flex justify-between items-center">
                <span>Dealership Information</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>3</span>
            </span>
            <span class="flex justify-between items-center">
                <span>8 Elements Dealerships Must Comply With</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>4</span>
            </span>
            <span class="flex justify-between items-center">
                <span>ISP Objectives</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>5</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Handling and Processing Customer NPI</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>6</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Incident Response Plan</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>8</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Data Breach Guidelines</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>9</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Information Storage IT Safeguards Cyber Security</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>10</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Disposal of Consumer Information and Records</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>13</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Processing Customer NPI by Department</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>14</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Sales</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>15</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>F&amp;I</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>17</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Service</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>19</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Parts</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>20</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Accounting</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>21</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Cashier</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>23</span>
            </span>
            <span class="ml-16 flex justify-between items-center">
                <span>Body Shop</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>24</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Dealership Personnel</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>25</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Third Party Service Providers</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>26</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Records Retention List</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>28</span>
            </span>
            <span class="flex justify-between items-center">
                <span>Signature Page</span>
                <span class="border-b border-dotted border-black flex-grow mx-2"></span>
                <span>30</span>
            </span>
        </div>
    </div>
    <div class="h-screen">
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
                                    <div class="font-medium text-gray-900">{{ $isp->owner_name }}</div>
                                    <div class="mt-1 text-gray-500">Owner</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->owner_phone }}</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $isp->general_manager_name }}</div>
                                    <div class="mt-1 text-gray-500">General Manager</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->general_manager_phone }}</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $isp->body_shop_manager_name }}</div>
                                    <div class="mt-1 text-gray-500">Body Shop Manager</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->body_shop_manager_phone }}</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $isp->parts_manager_name }}</div>
                                    <div class="mt-1 text-gray-500">Parts Manager</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->parts_manager_phone }}</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $isp->service_manager_name }}</div>
                                    <div class="mt-1 text-gray-500">Service Manager</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->service_manager_phone }}</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-5 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $isp->qualified_individual_name }}</div>
                                    <div class="mt-1 text-gray-500">Qualified Individual</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $isp->qualified_individual_phone }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="w-full max-w-4xl mx-auto grid grid-cols-2 gap-5">
                    <div>
                        Police Emergency Phone Number<br>
                        {{ $isp->police_emergency_phone }}
                    </div>
                    <div>
                        Police Non-Emergency Phone Number<br>
                        {{ $isp->police_non_emergency_phone }}
                    </div>
                    <div>
                        Fire Emergency Phone Number<br>
                        {{ $isp->fire_non_emergency_phone }}
                    </div>
                    <div>
                        Fire Non-Emergency Phone Number<br>
                        {{ $isp->fire_non_emergency_phone }}
                    </div>
                    <div>
                        Fire Alarm Type<br>
                        {{ $isp->fire_alarm_type }}
                    </div>
                    <div>
                        Burglar Alarm Type<br>
                        {{ $isp->burglar_alarm_type }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="prose max-w-none px-6">
        <div class="h-screen">
            <h1>
                Information Security Program (ISP)
            </h1>
            <p>This document contains the ISP for {{ tenant('name') }}, and is part of the
                Compliance Management System for the Dealership. This information was
                assembled with the help of Automotive Risk Management Partners, Inc. It
                contains the process that {{ tenant('name') }} follows to ensure compliance with
                the Gramm Leach Bliley Act, Federal Trade Commission Safeguards Rule,
                and the privacy and security of customer and dealership information.</p>
            <p>All information provided includes all revisions to the Safeguards Rule that are to be
                implemented by June 9 th , 2023. There are 8 elements that dealerships must comply
                with listed below and reviewed throughout this ISP manual.</p>
            <ol>
                <li>Designation of a Qualified Individual</li>
                <li>Periodic Risk Assessments of dealership</li>
                <li>Design and Implement safeguards for
                    <ul>
                        <li>Access Control</li>
                        <li>System Inventory</li>
                        <li>Encryption</li>
                        <li>Data Breach</li>
                        <li>Secure development practices</li>
                        <li>MFA – Multifactor Authentication</li>
                        <li>Disposal Procedures</li>
                        <li>Change management procedures</li>
                        <li>Monitoring and Logging of Authorized User Activity</li>
                    </ul>
                </li>
                <li>Penetration Testing</li>
                <li>Implement P&amp;P for personnel to implement your ISP</li>
                <li>Oversee Service Providers</li>
                <li>Draft Incident Response Plan</li>
                <li>Prepare an annual report to board or equivalent</li>
            </ol>
            <h2>**Prepare an Annual Report to Board or Equivalent</h2>
            <p>Your SQI (Single Qualified Individual, {{ $isp->qualified_individual_name }}) must prepare a written report
                annually to the Board or Equivalent to discuss the overall status of your ISP, compliance
                with the revised safeguards rule and material matter related to the company’s ISP including
                Risk Assessment, Risk Management and control decisions, service provider arrangements,
                results of penetration testing, security events and violations along with responses to such
                events and violations, and recommended changes to the ISP. This is NOT required if
                dealer has records on fewer than 5,000 customers.</p>
        </div>
        <div class="h-screen">
            <h1>Information Security Program</h1>
            <h2>Objectives</h2>
            <p>The objective of this program is to establish the necessary policies and procedures for the handling
                of, use of, and safeguarding of consumer/customer information as required for compliance with the
                Gramm Leach Bliley Act.</p>
            <p>Concerning this program, “Non-Public Personal Information” (NPI) shall mean any information about
                a customer/consumer of dealership which it receives about the customer/consumer, and can be
                directly attributed in any manner to a customer/consumer.</p>
            <p>The objectives of the program are as follows:</p>
            <ul>
                <li>Ensure the security and confidentiality of all customers/consumers NPI and data, both
                    electronically and physically.
                </li>
                <li>Protect against reasonably anticipated threats or hazards, both internal and external, to the
                    security and integrity of NPI that is maintained, handled and retained by dealership.
                </li>
                <li>Protect against unauthorized use and disclosure of NPI that could result in harm or
                    inconvenience to any customer of dealership and verify steps are taken to maintain current
                    knowledge of security threats.
                </li>
                <li>Maintain written proof of continued compliance with the established program.</li>
            </ul>
            <h2>Single Qualifies Individual (Program Coordinator)</h2>
            <p>The Safeguards Rule requires the appointment of a “Single Qualified Individual” (SQI) who will be
                responsible for overseeing, implementing, and enforcing all aspects of your information security
                program to include the following:</p>
            <ul>
                <li>Enforce ISP policies and procedures.</li>
                <li>Oversee and implementing periodic risk assessments.</li>
                <li>Coordinate regular employee information security training.</li>
                <li>Implementing mandatory safeguards and testing and auditing those safeguards.</li>
                <li>Supervise service providers that handle customer information.</li>
                <li>Designing and overseeing the drafting of a written incident response plan.</li>
            </ul>
            <p>The Qualified Individual assigned by {{ $isp->store->name }} will be {{ $isp->qualified_individual_name }}
                and shall report directly
                to a senior member of your dealership, and your board of directors if your business has a board.</p>
        </div>
        <div class="h-screen">
            <h1>Safeguards Rule for Customer/Consumer NPI</h1>
            <h2>Handling and Processing Customer NPI:</h2>
            <ul>
                <li>All employees are required to complete an <strong><i>information security awareness training
                            program</i></strong> on the proper handling and safeguarding of customer information, and
                    applicable
                    laws and regulations. Records of employee training will be maintained electronically in the
                    dealerships on-line dashboard.
                </li>
                <li>At no time will any employee, independent contractor, or third party acting on behalf of the
                    dealership allow customer information to be exposed to the risk of being lost, misplaced or
                    stolen.
                </li>
                <li>It shall be every employees’ responsibility to ensure that all customer information will be
                    handled, used, and stored securely, and in accord with the policies and procedures
                    established in this ISP.
                </li>
                <li>Customer information shall be transmitted or shared, internally or externally, only for
                    legitimate business purposes.
                </li>
                <li>Any sharing of customer/consumer information with any third party shall only be done with
                    verified entities necessary to the transaction and that have been properly vetted for
                    information security safeguards and compliance utilizing an individual service provider risk
                    assessment.
                </li>
                <li>Each employee that has a need to access the Dealership Management System, must have
                    their own unique password for login.
                </li>
                <li>Deal jackets may be obtained by management staff only.</li>
                <li>All deal jackets that are being held by managers must be secured in locked filing cabinets
                    when not in use.
                </li>
                <li>Any program designed to capture e-mail addresses from customers such as drawings,
                    giveaways, solicitations must be secured in locked receptacles.
                </li>
                <li>At NO time are deal jackets to be left alone or unattended for any length of time.</li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing an inspection is to be performed by each department manager to
                    ensure compliance.
                </li>
                <li>All new employees will be trained in the Gramm-Leach-Bliley Act and Patriot Act
                    requirements within 30 days of employment.
                </li>
                <li>All computers that access the internet must have the newest version of an antivirus
                    software installed and operating.
                </li>
                <li>All customers are to be given a dealership Privacy Policy Notice at the beginning of each
                    deal.
                </li>
                <li>All Dealership employees shall comply with the Privacy Policy.</li>
                <li>Faxing or emailing customer NPI may only be done with dealership equipment and through
                    the dealership server, and only if secure protocols are in place.
                </li>
                <li>Copies of driver licenses must be secured in a deal jacket or disposed of in a secure
                    shredding receptacle.
                </li>
                <li>Storage of customer information on personal devices is strictly forbidden.</li>
                <li>All employees and third-party service providers are responsible for complying with
                    dealerships program.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <ul>
                <li>All employees and third-party service providers will sign a security, confidentiality and non-
                    disclosure statement.
                </li>
                <li>All information that is classified as customer or consumer NPI may only be accessed on a
                    need-to-know basis.
                </li>
                <li>Personnel shall not be permitted to copy, access, or use customer and consumer NPI for
                    their own personal use or for any reason not authorized by employer.
                </li>
                <li><strong>Enforcement</strong> - All persons who do not comply with dealerships Information Security
                    Program shall be subject to disciplinary measures up to and including termination of
                    employment for employees and termination of third-party providers that perform services
                    for dealership.
                </li>
            </ul>
            <h2>Draft your Incident Response Plan</h2>
            <p>Written plan, in advance, of what actions you will take in the event of a “Security Event” i.e.,
                unauthorized access to or disruption or misuse of an information system, information stored
                on such system, or customer information held in physical form.</p>
        </div>
        <div class="h-screen">
            <h2>NPI Breach Response, Data Breach (Incident Response Plan)</h2>
            <p>&quot;Breach of security&quot; or &quot;breach&quot; means unauthorized access of personal information. Good
                faith access of personal information by an employee or agent of the dealership does not
                constitute a breach of security, provided that the information is not used for a purpose
                unrelated to the business or subject to further unauthorized use. In the event NPI is believed to
                have been breached:</p>
            <ul>
                <li><strong>{{ $isp->qualified_individual_name }}</strong> shall be notified immediately.</li>
                <li>Management will be advised</li>
                <li>The nature and extent of the breach shall be determined.</li>
                <li>Determine whether there is a reasonable expectation of harm to any individuals as a result
                    of the incident.
                </li>
                <li>Determine the extent to which any breach has caused, or is likely to result in customer NPI
                    being compromised.
                </li>
                <li>Notify consumers/customers regarding details of the disclosure, the information likely to
                    have been disclosed, the action taken to correct the breach and to secure the information,
                    and the name address, email and phone number of the individual to contact regarding
                    information concerning the breach where it is determined the individual may be adversely
                    affected.
                </li>
                <li><strong>[Provide notice to individuals and State departments pursuant to state law where
                        needed]</strong></li>
            </ul>
        </div>
        <div class="h-screen">
            <h2>Data Breach Guidelines</h2>
            <h4>Safeguards Rule</h4>
            <p>Requires financial institutions to notify the FTC of a security breach that affects at least 500 consumers as soon as possible, but no later than 30 days after discovery.</p>
            <p>ONLINE REPORTING FORM: <a
                    href="https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form" target="_blank">https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form</a></p>
            <p>Now that the Safeguards Rule reporting requirement is in effect, what must businesses do? The amendment requires financial institutions to notify the FTC as soon as possible – and no later than 30 days after discovery – of a security breach involving the information of at least 500 consumers. Here’s how the Rule defines an incident that triggers notification:</p>
            <p>An acquisition of unencrypted customer information without the authorization of the individual to which the information pertains. Customer information is considered unencrypted for this purpose if the encryption key was accessed by an unauthorized person. Unauthorized acquisition will be presumed to include unauthorized access to unencrypted customer information unless you have reliable evidence showing that there has not been, or could not reasonably have been, unauthorized acquisition of such information.</p>
            <p>If that happens at your company, we want to make it as easy as possible for you comply with the reporting requirements of the Safeguards Rule. <a href="https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form" target="_blank">You must use a new online form</a> that explains in plain language the specific information you need to provide. Again the link for the online reporting is listed below</p>
            <p>Link for the online form is listed below:</p>
            <p>
                <a href="https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form">https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form</a></p>
        </div>
        <div class="h-screen">
            <h1>Information Security Policies and Procedure - Information Storage IT Safeguards Cyber Security</h1>
            <ul>
                <li><strong>Access control</strong> where dealer must insure physical locks and physical data and password
                    protection on all electronic data.
                </li>
                <li><strong>Dealer must take inventory</strong> – Include all systems that are part of the business so that
                    your
                    dealership can locate all customer information it controls.
                </li>
                <li>In rare in instances where you develop your own software you are required to implement
                    <strong>Secured Development Practices</strong> for apps that transmit, access or store customer
                    information.
                </li>
                <li>All systems must be password protected including DMS terminals as well as
                    PC.
                </li>
                <li>All system passwords will be set to expire no longer than 90 days from issue
                    date.
                </li>
                <li>Passwords are to be random alpha numeric combinations of 8 or more and cannot be
                    identical to the user id or common words.
                </li>
                <li>Passwords cannot be written or posted in the terminal area.</li>
                <li>Passwords must be unique to the user and not shared among employees.</li>
                <li>Users accessing the system must be sensitive to observers reading their
                    password as they log on.
                </li>
                <li>Screensavers must be installed on all PC’s. They must be password protected
                    with an interval not to exceed 5 minutes of inactivity.
                </li>
                <li>Non-PC terminals must be logged off when unattended.</li>
                <li>All media containing confidential customer information (disk drives,
                    , USB keys, etc.) must be secure.
                </li>
                <li>All servers containing confidential customer information must be in a locked,
                    limited access room.
                </li>
                <li>All computer systems containing confidential customer information must not
                    be exposed to any non-protected network sources including the internet, and third
                    party networks.
                </li>
                <li>Terminals and PCs should be turned off at the end of the day by the last user
                    of that equipment.
                </li>
                <li>Non-essential drives that access the system and can be used to add programs must be de-
                    activated.
                </li>
                <li>Computer screens should not be in public view if possible.</li>
                <li>Confidential customer data must not be stored on PC, or personal devices.</li>
                <li>A physical inventory of all computer hardware must be maintained.</li>
                <li>Any back up media must be protected in a locked, secure location.</li>
                <li>Obsolete equipment that is being decommissioned should be cleansed of
                    confidential customer data, and the procedure documented before being destroyed.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <h1>System Security</h1>
            <ul>
                <li>All computer systems must be protected by current anti-virus software</li>
                <li>Networks with internet access must be protected by a secure firewall.</li>
                <li>Both anti-virus and firewall systems must be periodically updated.</li>
                <li>Use of USB flash drives is restricted</li>
                <li>All software downloads must be approved by IT.</li>
                <li><strong>Encryption</strong> – dealerships must encrypt all customer information held or transmitted when
                    in transit over external networks and when at rest.
                </li>
                <li>Dealer must implement <strong>Multifactor Authentication</strong> when ever any individual accesses an
                    information system containing customer information. (Two or more forms of password code
                    control, or reasonably equivalent controls approved by your SQI)
                </li>
                <li>
                    <strong>Change Management Procedures</strong> – Due to increased cybersecurity risk associated with
                    changes/modifications to Company’s IT infrastructure and systems, any addition, removal,
                    or modification of the elements within Company’s IT infrastructure and systems shall be
                    governed as follows:
                    <ul>
                        <li><strong>Adding/removing end-user devices</strong>: The Qualifies Individual in conjunction with
                            designated IT personnel must be involved in adding and removing end-user devices. These
                            devices can include, but are not limited to laptops, desktops, smart phones, and tablets.
                            These devices are required to be securely configured in accordance with the technical and
                            electronic safeguards discussed in this ISP.
                        </li>
                        <li><strong>Adding/removing third-party software and applications</strong>: Prior to adding
                            third-party
                            software or applications, the service provider must be assessed for the adequacy of their
                            technical and physical information safeguards as discussed in this ISP. Removal of third-
                            party software or applications should involve the Qualifies Individual and designated IT
                            personnel and should abide by technical and electronic safeguards discussed in this ISP.
                        </li>
                        <li>
                            <strong>Web browser additions/modifications</strong>: Before allowing any browser to execute on
                            the
                            network, the following steps, at a minimum, must be taken:
                            <ul>
                                <li>Plugins are limited to trusted sources or are otherwise disabled.</li>
                                <li>Automatic updates have been properly configured.</li>
                                <li>Pop-up blockers have been enabled.</li>
                                <li>Content filters have been enabled.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Major additions/modifications to servers, operating systems, or network (and
                                related elements)</strong>: Any major modification, addition, or removal of dealership’s
                            servers,
                            operating systems, or network elements (i.e., routers, firewalls, etc.) must be completed with
                            the following:
                            <ul>
                                <li>A full penetration test.</li>
                                <li>A full internal and external vulnerability assessment</li>
                                <li>Consider conducting a risk assessment, as appropriate based on the changes made.</li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <ul>
                <li>Implement <strong>Monitoring and logging of Authorized User Activity</strong> which will monitor
                    activity of authorized users and detect unauthorized access or use of customers
                    information by such user. Focus on understanding what/when/how information was
                    accessed in case of a security event.
                </li>
                <li>Regular testing/auditing of the effectiveness of your safeguards key controls, systems and
                    procedures. Implement either a continuous monitoring of your information system or annual
                    periodic <strong>Penetration Testing</strong> and vulnerability assessments.
                </li>
            </ul>
            <p><strong>[Include procedures and protocols currently in place and recommended by IT department
                    that are not duplicates of above]</strong></p>
        </div>
        <div class="h-screen">
            <h1>Disposal of Consumer Information and Records</h1>
            <p>Amendments to the Fair Credit Reporting Act require that users of consumer reports, which contain
                consumer information, be properly disposed of. Consumer information means any record about an
                individual, whether in paper, electronic, or other form, that is a consumer report or is derived from a
                consumer report. Any person who maintains or possesses consumer information for a business
                purpose must properly dispose of such information by taking <strong>reasonable measures</strong> to protect
                against unauthorized access to or use of the information in connection with its disposal.</p>
            <ul>
                <li>Dealership uses Shredding Co, a vetted third-party provider to dispose of all documents
                    containing any consumer information.
                </li>
                <li>Dealership shall have all electronic equipment scrubbed of all information by vetted and
                    qualified third-party providers prior to disposing of any equipment that contained electronic
                    data.
                </li>
                <li>Customer NPI in all forms that is moved within the dealership must be handed off in a manner
                    that leaves no doubt the hand-off has occurred (you may not leave completed deals on a desk
                    without acknowledgement of the personnel receiving the information and that he or she has
                    taken possession of that deal).
                </li>
                <li><strong>Disposal Procedures</strong> - Personnel must shred customer information prior to disposal, use
                    secured wastebins, and use reputable document disposal vendors. Follow document retention
                    policies already in place and dispose of customer information within 2 years of expiration from
                    retention policy unless it cannot be feasibly destroyed due to the way the information is
                    maintained. Apply same rules to service providers and require vendors to delete data after
                    use.
                    <ul>
                        <li>Customer information that does not involve a finalized transaction such as a completed
                            automobile sale must either be secured in a fashion for future processing or disposed as
                            described above.
                        </li>
                        <li>Credit bureaus must be secured and not left unattended or in an open environment that
                            could be viewed by anyone not directly on a need-to-know basis.
                        </li>
                    </ul>
                </li>
            </ul>
            <h2>General Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Review
                conducted at the time of installation, and are hereby incorporated herein.</p>
            <p>These areas will be monitored for future compliance.</p>
        </div>
        <div class="h-screen">
            <h1>Processing Customer NPI by Department</h1>
            <p><strong>From Sales Department to:</strong></p>
            <ul>
                <li>Accounting Dept. - Sales department prepares a buyer’s order form and gives to the
                    General Sales Manager. Deals are then further prepared in the F&amp;I office, and put together in
                    a deal jacket, which is then turned over to the license and title clerk to be processed.
                    Information then goes to accounting to be prepared for the finance company (if a finance
                    deal) for funding. Once the deal is sent to the finance source, it is filed and secured in
                    accounting.
                </li>
                <li>Service and Parts Dept. – “We Owes” and requests for internal work on vehicles are the
                    only correspondence transferred.
                </li>
            </ul>
            <p><strong>From Accounting Department to:</strong></p>
            <ul>
                <li>Sales Dept. – “See Above” – there may be times where sales will remove a deal from
                    accounting for review of specific issues but it is returned to a secure environment after review.
                </li>
            </ul>
            <p><strong>From Service and Parts Department to:</strong></p>
            <ul>
                <li>Accounting Dept. – All R/O’s and invoices flow back to the cashier for payment and then to
                    accounting for filing.
                </li>
            </ul>
            <p><strong>From Sales Department to:</strong></p>
            <ul>
                <li>Third Party Vendors – F&amp;I shall acquire proper privacy verbiage from the 3 rd party vendors.</li>
                <li>Finance Companies – In normal course of business, information is securely transferred
                    either electronically or faxed for processing. The deals are then secured until needed.
                </li>
            </ul>
            <p><strong>From Accounting Department to:</strong></p>
            <ul>
                <li>Finance Companies – All installment contracts are sent to banks for funding.</li>
                <li>Manufacturers – “Retail Delivery Reports” are securely handled online.</li>
            </ul>
            <p><strong>From Service and Parts Department to:</strong></p>
            <ul>
                <li>Accounting Dept. – All R/O’s and invoices flow back to the cashier for payment and then to
                    accounting for filing.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <h1>Sales Department</h1>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>All credit bureaus processed must never be left unattended until securely stored in a
                    restricted access and locked location.
                </li>
                <li>All credit bureaus processed must be attached inside of a secure deal jacket, maintained in
                    a dead deal file in a secure location, or disposed of in a locked secure shredding container.
                </li>
                <li>All credit applications shall be kept secure and never left unattended.</li>
                <li>All credit applications in which credit was run shall be maintained in the deal jacket, or the
                    dead deal file.
                </li>
                <li>All credit applications taken where no credit was run, and no credit decision was made,
                    shall be shredded and destroyed.
                </li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>All customer information shall be placed in either the deal Jacket and secured, the secured
                    dead deal file, or destroyed.
                </li>
                <li>Customer information on working deals shall be kept secured and locked at all times said
                    information is not in use. In no event shall information on working deals be kept in excess
                    of 45 days from the date the information is collected. After 45 days all customer information
                    collected that has not resulted in a transaction or pending transaction shall be placed in the
                    dead deal file where required, or destroyed.
                </li>
                <li>Deal jackets may be obtained by management staff only.</li>
                <li>Deal jackets that are retrieved from the office must be signed out on the Customer NPI Log
                    and signed back in when returned.
                </li>
                <li>All deal jackets that are being held by Sales Manager, Finance Manager, or any other
                    authorized person must be secured in locked cabinets when not in use.
                </li>
                <li>Any program designed to capture email or postal addresses from customers such as
                    drawings, giveaways, or solicitations must be secured in locked receptacles.
                </li>
                <li>At no time are deal jackets to be left alone or unattended for any length of time.</li>
                <li>All terminals or PCs are to be logged off before being left unattended.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing an inspection is to be performed by the manger on duty or his/ her
                    designee to ensure compliance.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <h2>Filing or Disposing of Customer Information:</h2>
            <ul>
                <li>A completed deal, ready to be handed over to the accounting office, must be handed off in
                    a manner that leaves no doubt that the hand-off has occurred (you may not leave
                    completed deals on a desk without acknowledgement of the office staff receiving the deal
                    and that they have taken possession of that deal).
                </li>
                <li>Customer information that does not involve a finalized transaction such as a completed
                    automobile sale must either be secured in a fashion for future processing or disposed of in
                    a secured shredding receptacle.
                </li>
                <li>Credit bureaus must be secured in a fashion as to not be left unattended or in an open
                    environment that could be viewed by anyone not directly in a need-to-know basis.
                </li>
            </ul>
            <h2>Sales Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance.</p>
        </div>
        <div class="h-screen">
            <h1>F&amp;I Department</h1>
            <p><strong>Internal Security Plan</strong></p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>After a deal is accepted by the F&amp;I office for processing, that deal can only be accessed by
                    Sales Manager, or Finance Manager.
                </li>
                <li>All deal jackets must be secured and out of sight before leaving the F&amp; I office. All F&amp;I
                    offices shall be locked when no authorized person is present.
                </li>
                <li>All credit bureaus processed must either be attached to the inside of deal jacket or
                    disposed of in a locked security container.
                </li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>Credit bureaus may not be faxed without consent of Sales Manager, or Finance Manager</li>
                <li>Deal jackets that are retrieved from the office must be signed out on the Customer NPI log
                    and signed back in when finished.
                </li>
                <li>Any requests for customer information from any “need to know” persons or institutions such
                    as banks or credit unions must be properly verified before any customer information is
                    disclosed.
                </li>
                <li>At no time are deal jackets to be left alone unattended for any length of time.</li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing an inspection is to be performed by Sales Manager, or Finance
                    Manager to ensure compliance.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information</h2>
            <ul>
                <li>A completed deal ready to be handed over to the accounting office must be handed off in a
                    manner that leaves no doubt that the hand-off has occurred (you may not leave completed
                    deals on a desk without acknowledgement of the office personal receiving the deal and that
                    they have taken possession of that deal).
                </li>
                <li>Customer information that does not involve a finalized transaction such as a completed
                    automobile sale must either be secured in a fashion for future processing or disposed of in
                    a secured shredding receptacle.
                </li>
                <li>Credit bureaus must be secured in a fashion as to not be left unattended or in an open
                    environment that could be viewed by anyone not directly in a need-to-know basis.
                </li>
                <li>On all bring-backs where funding was not possible, the “Dead Deal File” must either be
                    secured for future processing or disposed of in a secured shredding receptacle.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <h2>F&amp;I Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h1>Service Department</h1>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>All service documents that contain customer information including work orders and service
                    invoices are to be securely filed or disposed of in a secure shredding receptacle.
                </li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>All customer documents with possible NPI must be filed each day or secured for future
                    filing in a locked cabinet.
                </li>
                <li>Customer service files that are retrieved from the office must be signed out on the Service
                    Customer NPI log and signed back in when finished.
                </li>
                <li>At no time are invoices, work orders or any other document containing customer
                    information to be left alone or unattended for any length of time.
                </li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing, an inspection is to be performed by Service Manager to ensure
                    compliance.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information:</h2>
            <ul>
                <li>All documents that are used or handled in the Service Department that contain customer
                    information must be kept secure at all times; either in the possession of an authorized
                    person, secured in a locked filing cabinet, desk or office, or in a secure shredding
                    receptacle.
                </li>
                <li>All service history files must remain secure and retained per the Document Retention
                    Schedule of Dealership.
                </li>
                <li>Only authorized persons may access service history files.</li>
            </ul>
            <h2>Service Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h1>Parts Department</h1>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>All parts tickets or other documents with possible customer NPI must either be secured or
                    disposed of in a secured shredding receptacle.
                </li>
                <li>Customer NPI used in conjunction with special parts ordering must be secured each night.</li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>At no time are parts tickets or any other documents with possible customer NPI to be left
                    alone or unattended for any length of time.
                </li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing an inspection is to be performed by Parts Manager to ensure
                    compliance.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information:</h2>
            <p>All documents that are used or handled in the Parts Department that contain customer
                information must be kept secure at all times; either in the possession of an authorized
                person, secured in a locked filing cabinet, desk or office, or in a secure shredding
                receptacle.</p>
            <h2>Parts Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h2>Accounting Department</h2>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI:</h2>
            <ul>
                <li>After a deal is received from the F&amp;I office for processing, that deal can only be accessed
                    by office personal or management after having first signed out the deal in the NPI log.
                </li>
                <li>All filing cabinets must be able to be secured with a lock.</li>
                <li>All deal jackets kept in other areas of dealership, such as Parts Department or offsite
                    storage and must be able to be secured by lock, with access limited only to office personal
                    or management staff
                </li>
                <li>All deal jackets and other NPI documents must be kept in a secured manner until such time
                    that they are stored in a more permanent location.
                </li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>Deal jackets may be obtained by management staff only.</li>
                <li>Deal jackets that are retrieved from the office must be signed out on the Customer NPI log
                    and signed back in when finished.
                </li>
                <li>All deal jackets held for title work must be secured at night or when unattended.</li>
                <li>At no time are deal jackets to be left alone or unattended.</li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing, an inspection is to be performed by Office Manager to ensure
                    compliance.
                </li>
                <li>Back-up tape from DMS must be treated as an NPI document and should be stored in a
                    secured data safe.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information</h2>
            <ul>
                <li>All documents that are used or handled in the Accounting Department that contain
                    customer information must be kept secure at all times; either in the possession of an
                    authorized person, secured in a locked filing cabinet or office, or in a secure shredding
                    receptacle.
                </li>
                <li>A completed deal handed over to the accounting office must be acknowledged in a manner
                    that leaves no doubt that the hand-off has occurred.
                </li>
                <li>Deal jackets that are to be destroyed must be shredded.</li>
            </ul>
        </div>
        <div class="h-screen">
            <h2>Accounting Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h1>Cashier</h1>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>All copies of driver licenses are to be filed or disposed of in a secure shredding receptacle.</li>
                <li>All extra copies of invoices are to be disposed of in secured shredding receptacles.</li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>Any program designed to capture email addresses from customers such as drawings,
                    giveaways, or solicitations must be secured in locked receptacles.
                </li>
                <li>At no time are any NPI documents to be left alone or unattended for any length of time.</li>
                <li>Any information requested from an outside source must be confirmed as to the source of
                    the inquiry.
                </li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing, an inspection is to be performed by Office Manager to ensure
                    compliance.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information:</h2>
            <ul>
                <li>All documents that are used or handled in the Cashier area that contain customer
                    information must be kept secure at all times; either in the possession of an authorized
                    person, secured in a locked filing cabinet or office, or in a secure shredding receptacle.
                </li>
                <li>All completed invoices must be secured, and extra copies must be disposed of in secured
                    shredding receptacles.
                </li>
                <li>All cash receipts are to be either stapled inside the deal jacket or filed in a secured cabinet.</li>
            </ul>
            <h2>Cashier Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h1>Body Shop</h1>
            <p>Internal Security Plan</p>
            <h2>Handling and Processing Customer NPI</h2>
            <ul>
                <li>All documents containing NPI such as body shop estimates, work orders or invoice copies
                    are to be either securely filed or disposed of in a secure shredding receptacle.
                </li>
                <li>Each employee that has a need to access the DMS (Dealership Management System)
                    must have their own unique password for login.
                </li>
                <li>All customer documents with possible NPI must be filed each day or secured for future
                    filing in a locked cabinet.
                </li>
                <li>Customer body shop files that are retrieved from the office must be signed out on the
                    Service Customer NPI log and signed back in when finished.
                </li>
                <li>At no time are any customer NPI documents such as body shop estimates, work orders or
                    invoices are to be left alone unattended for any length of time.
                </li>
                <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                <li>All terminals or PCs with customer information must be placed in a position to hide
                    sensitive information from others not directly involved with the transaction.
                </li>
                <li>Each night at closing an inspection is to be performed by Body Shop Manager to ensure
                    compliance.
                </li>
                <li>Credit card information on any document must be secured and not left in an open or
                    unsecured area.
                </li>
            </ul>
            <h2>Filing or Disposing of Customer Information:</h2>
            <p>All documents that are used or handled in the Accounting Department that contain
                customer information must be kept secure at all times; either in the possession of an
                authorized person, secured in a locked filing cabinet or office, or in a secure shredding
                receptacle.</p>
            <h2>Body Shop Risk Assessment of Customer NPI Based on Internal Audit</h2>
            <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
                conducted at the time of installation, and are hereby incorporated.</p>
            <p>These areas will be monitored for future compliance</p>
        </div>
        <div class="h-screen">
            <h1>Dealership Personnel</h1>
            <p>Internal Security Plan</p>
            <ul>
                <li>Dealership will check references of each potential employee prior to the start of his or her
                    employment.
                </li>
                <li>Dealership shall obtain a background check in accord with the Fair Credit Reporting Act
                    and applicable state laws and regulations on each new hire that will have access to
                    customer information prior to the start of his or her employment.
                </li>
                <li>All new employees will participate in Dealership’s Information Security Program. Each
                    person shall sign and acknowledge his or her agreement to abide by information security
                    practices and procedures, and the provisions of this ISP.
                </li>
                <li>Training must be performed no later than 30 days after start of employment and all
                    employees will be given a yearly refresher course to include any changes to the
                    dealership’s ISP, OFAC policy, and current requirements. Topics will include:
                    <ol>
                        <li>Identifying for employees the types of customers NPI that falls under the protection
                            of the privacy and safeguard rules.
                        </li>
                        <li>Locking rooms and securing information deemed to be customer NPI.</li>
                        <li>Not sharing passwords for access to Dealership’s DMS for access to customers NPI.</li>
                        <li>Maintaining the security of their password.</li>
                        <li>Appropriately disposing of customer NPI records.</li>
                        <li>Other training as deemed necessary by the Security Officer.</li>
                    </ol>
                </li>
                <li>Security of customer/consumer information is the responsibility of each and every
                    Dealership employee.
                </li>
            </ul>
            <p>All employees will be made aware of Dealership’s security policy, and that failure to comply with
                these policies could result in disciplinary measures, up to and including termination of employment.</p>
        </div>
        <div class="h-screen">
            <h1>Third Party Providers</h1>
            <p>Internal Security Plan</p>
            <p><strong>Oversee Service Providers</strong> – any entity permitted access to customer information through its
                provision of services directly to dealer must be monitored to verify maintenance of adequate
                safeguards protecting customer information. Review service providers and require them by signed
                agreement to agree to 3 rd party security audits when asked.</p>
            <ul>
                <li>Conducting thorough risk assessment to verify that the service provider understands and is
                    capable of complying with Federal consumer financial law;
                </li>
                <li>Requesting and reviewing the service provider’s policies, procedures, internal controls, and
                    training materials to ensure that the service provider conducts appropriate training and
                    oversight of employees or agents that have consumer contact or compliance responsibilities;
                </li>
                <li>Including in the contract with the service provider clear expectations about compliance, as well
                    as appropriate and enforceable consequences for violating any compliance-related
                    responsibilities, including engaging in unfair, deceptive, or abusive acts or practices;
                </li>
                <li>Establishing internal controls and on-going monitoring to determine whether the service
                    provider is complying with Federal consumer financial law; and
                </li>
                <li>Taking prompt action to address fully any problems identified through the monitoring process,
                    including terminating the relationship where appropriate.
                </li>
            </ul>
            <h2>Third Party Provider Requirements</h2>
            <ul>
                <li>All third-party providers must complete and provide the Dealership Third Party Risk
                    Assessment form (set forth below).
                </li>
                <li>Dealership shall obtain a copy of the privacy policy of each outside entity that has access to
                    the dealership’s customer information.
                </li>
                <li>Third party privacy policies received will be uploaded to the respective folder in on the
                    dashboard.
                </li>
                <li>All third-party provider contracts must have “safeguard rule” language in their contract
                    verifying compliance with and training of personnel in compliance with GLBA and the FTC
                    Safeguards Rule. Third party contracts should at a minimum contain provisions similar to
                    the “Addendum to Provider Agreement” set forth below.
                </li>
                <li>All third-party providers must have opt-out clauses for breach of our customer NPI.</li>
                <li>All third-party providers must maintain reasonable safeguard procedure and policies to
                    protect dealership’s customer NPI.
                </li>
                <li>All third-party providers must offer Dealership an indemnification clause in their contract.</li>
                <li>All third-party providers must provide access to their policies, procedures, internal controls,
                    and training materials upon reasonable request.
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <p>{{ $isp->qualified_individual_name }} shall be responsible for overseeing all third-party providers who come
                in
                contact with, download, handle or have any access to customer or consumer
                NPI. {{ $isp->qualified_individual_name }} will take reasonable steps to ensure that all third-party
                providers have the necessary
                policies, procedures, and employee training to maintain the security of Dealership customer and
                consumer NPI. In addition, all Third-Party Providers shall have the appropriate safeguards language
                in their contracts, and have completed the Dealership Third Party Questionnaire. Completed Third
                Party Provider Questionnaires shall be reviewed to authenticate said provider’s compliance
                procedures, and uploaded to the Compliance Solved dashboard.</p>
        </div>
        <div class="h-screen">
            <h1>Records Retention List</h1>
            <ul>
                <li>Customer Information & Account Records
                    <ul>
                        <li>Account Opening Forms: Retain for 5 to 7 years after account closure.</li>
                        <li>Customer Identification Records (KYC/AML records): Retain for 5 years after the last transaction or account closure.</li>
                        <li>Bank Statements & Transaction History: Retain for 7 years.</li>
                        <li>Loan Documents (including approvals and rejections): Retain for 7 years after loan closure or termination.</li>
                    </ul>
                </li>
                <li>
                    Tax and Regulatory Records
                    <ul>
                        <li>Tax Returns: Retain for 7 years after filing.</li>
                        <li>Tax Filings and Supporting Documents: Retain for 7 years.</li>
                        <li>Anti-Money Laundering (AML) and Suspicious Activity Reports (SARs): Retain for 5 years after the report was filed.</li>
                    </ul>
                </li>
                <li>
                    Investment & Trading Records
                    <ul>
                        <li>Brokerage Statements & Investment Records: Retain for 7 years after account closure.</li>
                        <li>Investment Transactions (Buy/Sell Orders, Trades): Retain for 7 years.</li>
                        <li>Prospectuses & Offering Documents: Retain for 7 years after offering closure.</li>
                        <li>Employee Trading Records: Retain for 5 years.</li>
                    </ul>
                </li>
                <li>
                    Financial Statements
                    <ul>
                        <li>Annual Financial Statements: Retain for 7 years.</li>
                        <li>Audit Reports: Retain for 7 years.</li>
                        <li>General Ledger Entries & Journals: Retain for 7 years.</li>
                        <li>Bank Reconciliations: Retain for 7 years.</li>
                    </ul>
                </li>
                <li>
                    Credit and Loan Documentation
                    <ul>
                        <li>Loan Agreements & Contracts: Retain for 7 years after loan repayment.</li>
                        <li>Mortgage Documentation: Retain for 7 years after payoff or foreclosure.</li>
                        <li>Default or Delinquency Records: Retain for 7 years after resolution.</li>
                        <li>Foreclosure Documentation: Retain for 7 years after resolution.</li>
                    </ul>
                </li>
                <li>
                    Employee and Payroll Records
                    <ul>
                        <li>Employee Records: Retain for 5 to 7 years after termination.</li>
                        <li>Payroll Records: Retain for 7 years.</li>
                        <li>Tax Forms (W-2, 1099): Retain for 7 years.</li>
                        <li>Benefits and Retirement Plan Records: Retain for 7 years after termination of plan.</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <ul>
                <li>
                    Loan/Payment Systems & Electronic Records
                    <ul>
                        <li>Electronic Transactions (e.g., wire transfers): Retain for 5 years.</li>
                        <li>Data Retention for Digital Banking Services: Retain for 5 to 7 years, depending on the type of data.</li>
                        <li>Digital Contracts/Signatures: Retain for 7 years.</li>
                    </ul>
                </li>
                <li>
                    Insurance and Risk Management
                    <ul>
                        <li>Insurance Policies & Coverage Records: Retain for 5 years after expiration.</li>
                        <li>Claims Records: Retain for 5 to 7 years after the settlement of claims.</li>
                        <li>Risk Management Documents: Retain for 7 years.</li>
                    </ul>
                </li>
                <li>
                    Corporate & Legal Documents
                    <ul>
                        <li>Corporate Charters, Bylaws, and Articles of Incorporation: Retain for permanent.</li>
                        <li>Board Meeting Minutes: Retain for permanent.</li>
                        <li>Legal Contracts and Agreements: Retain for 7 years after termination or expiration.</li>
                        <li>Litigation Documents: Retain for 7 years after resolution.</li>
                    </ul>
                </li>
                <li>
                    General Business & Operational Records
                    <ul>
                        <li>Vendor Contracts: Retain for 7 years after termination.</li>
                        <li>General Correspondence: Retain for 3 years (or according to specific contractual or legal requirements).</li>
                        <li>Internal Audit Reports: Retain for 7 years.</li>
                        <li>Marketing and Promotional Materials: Retain for 3 years.</li>
                    </ul>
                </li>
                <li>
                    Security & Privacy Records
                    <ul>
                        <li>Data Breach & Security Incident Reports: Retain for 5 years after resolution.</li>
                        <li>Internal and External Security Audits: Retain for 7 years.</li>
                    </ul>
                </li>
                <li>
                    Miscellaneous Financial Records
                    <ul>
                        <li>Bankruptcy & Insolvency Records: Retain for 7 years after resolution.</li>
                        <li>Safe Deposit Box Records: Retain for 7 years after box closure.</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="h-screen">
            <p>{{ $isp->qualified_individual_name }}, acting as the Qualifies Individual, will monitor and reevaluate
                this Information
                Security Program on a regular and continuing basis, and will include and consider:</p>
            <ul>
                <li>The results of evaluations, reviews, audits and testing of the existing system.</li>
                <li>Changes to regulatory requirements.</li>
                <li>Changes and/or modifications the Security Qualifies Individual and upper management
                    deems necessary to enhance the program based upon reasonable security testing and any
                    changes in operations.
                </li>
            </ul>
            <p>An initial Information Security Risk Assessment was completed at the time of the installation
                of the Compliance Solved Program. Said assessment is a part of the Information Security
                Program, and has been uploaded to the Dealership dashboard.</p>
            <p>Quarterly Audits will be kept electronically on the Dealership dashboard.</p>
            <p>This Information Security Program has been reviewed and approved by {{ $isp->store->name }}
                ownership, and {{ $isp->qualified_individual_name }} is authorized to implement said plan, and authorized
                with
                the appropriate authority to monitor and enforce its provisions and policies.</p>
            <p>Effective Date: {{ $isp->created_at->format('F d, Y') }}</p>
            <p>{{ $isp->user->name }}</p>
            <img src="{{ storage_path() }}/app/isp-signatures/{{ $isp->signature }}" alt="Signature"/>
         </div>
    </div>
</div>
</body>
</html>
