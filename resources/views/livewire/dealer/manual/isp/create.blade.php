<div class="p-6">
    <div class="divide-y mb-10">
        <div
            class="sm:flex sm:items-center sm:justify-between">
            <div class="min-w-0 flex-1">
                <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">ISP Manual</h1>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-x-5 gap-y-10 mb-10 pt-10">
            <div>
                <p class="font-bold">Qualified Individual</p>
                <p>{{ $qi }}</p>
                <p>{{ $qip }}</p>
            </div>
            <div>
                <p class="font-bold">Owner</p>
                <p>{{ $owner }}</p>
                <p>{{ $ownerp }}</p>
            </div>
            <div>
                <p class="font-bold">General Manager</p>
                <p>{{ $gm }}</p>
                <p>{{ $gmp }}</p>
            </div>
            <div>
                <p class="font-bold">Service Manager</p>
                <p>{{ $sm }}</p>
                <p>{{ $smp }}</p>
            </div>
            <div>
                <p class="font-bold">Parts Manager</p>
                <p>{{ $pm }}</p>
                <p>{{ $pmp }}</p>
            </div>
            <div>
                <p class="font-bold">Body Shop Manager</p>
                <p>{{ $bsm }}</p>
                <p>{{ $bsmp }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5 py-10">
            <div class="space-y-5">
                <div>
                    <p class="font-bold">Police Emergency Phone Number</p>
                    <p>{{ $pepn }}</p>
                </div>
                <div>
                    <p class="font-bold">Police Non-Emergency Phone Number</p>
                    <p>{{ $pnepn}}</p>
                </div>
            </div>
            <div class="space-y-5">
                <div>
                    <p class="font-bold">Fire Emergency Phone Number</p>
                    <p>{{ $fepn }}</p>
                </div>
                <div>
                    <p class="font-bold">Fire Non-Emergency Phone Number</p>
                    <p>{{ $fnepn }}</p>
                </div>
            </div>
        </div>
        <p class="text-gray-400">If any information above is outdated, please make adjustments in <a
                class="text-gray-500 underline"
                href="{{ (!tenant('locations') ? route('dealer.dealer.settings') : route('dealer.stores.settings', $store)) }}">settings</a>.
        </p>
    </div>
    <div class="prose min-w-full">
        <h1>
            Information Security Program (ISP)
        </h1>
        <p>This document contains the ISP for {{ $store->name }}, and is part of the
            Compliance Management System for the Dealership. This information was
            assembled with the help of Automotive Risk Management Partners, Inc. It
            contains the process that {{ $store->name }} follows to ensure compliance with
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
                    <li>access control</li>
                    <li>system inventory</li>
                    <li>Encryption</li>
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
        <p>The Qualified Individual assigned by
            {{ $store->name }}
            will be {{ $qi }}
            and shall report directly
            to a senior member of your dealership, and your board of directors if your business has a board.</p>
        <h1>Safeguards Rule for Customer/Consumer NPI</h1>
        <p><i>Handling and Processing Customer NPI:</i></p>
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
            <li>All employees and third-party service providers will sign a security, confidentiality and non-
                discloser statement.
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
        <h2>NPI Breach Response</h2>
        <p>&quot;Breach of security&quot; or &quot;breach&quot; means unauthorized access of personal information. Good
            faith access of personal information by an employee or agent of the dealership does not
            constitute a breach of security, provided that the information is not used for a purpose
            unrelated to the business or subject to further unauthorized use. In the event NPI is believed to
            have been breached:</p>
        <ul>
            <li><strong>{{ $qi }}</strong> shall be notified immediately.</li>
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
        <h2>Prepare an Annual Report to Board or Equivalent</h2>
        <p>Your SQI (Single Qualified Individual, {{ $qi }}) must prepare a written report
            annually to the Board or Equivalent to discuss the overall status of your ISP, compliance
            with the revised safeguards rule and material matter related to the company’s ISP including
            Risk Assessment, Risk Management and control decisions, service provider arrangements,
            results of penetration testing, security events and violations along with responses to such
            events and violations, and recommended changes to the ISP. This in NOT required if
            dealer has records on fewer than 5,000 customers.</p>
        <h2>Information Security Policies and Procedure - Information Storage IT Safeguards Cyber Security</h2>
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
        <h2>System Security</h2>
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
        <h2>Disposal of Consumer Information and Records</h2>
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
        <h2>F&amp;I Department</h2>
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
        <h2>F&amp;I Department Risk Assessment of Customer NPI Based on Internal Audit</h2>
        <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
            conducted at the time of installation, and are hereby incorporated.</p>
        <p>These areas will be monitored for future compliance</p>
        <h2>Service Department</h2>
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
        <h2>Parts Department</h2>
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
        <h2>Accounting Department Risk Assessment of Customer NPI Based on Internal
            Audit</h2>
        <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Quarterly Review
            conducted at the time of installation, and are hereby incorporated.</p>
        <p>These areas will be monitored for future compliance</p>
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
        <p>{{ $qi }} shall be responsible for overseeing all third-party providers who come
            in
            contact with, download, handle or have any access to customer or consumer
            NPI. {{ $qi }} will take reasonable steps to ensure that all third-party
            providers have the necessary
            policies, procedures, and employee training to maintain the security of Dealership customer and
            consumer NPI. In addition, all Third-Party Providers shall have the appropriate safeguards language
            in their contracts, and have completed the Dealership Third Party Questionnaire. Completed Third
            Party Provider Questionnaires shall be reviewed to authenticate said provider’s compliance
            procedures, and uploaded to the Compliance Solved dashboard.</p>
        <p>{{ $qi }}, acting as the Qualifies Individual, will monitor and reevaluate
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
        <p>This Information Security Program has been reviewed and approved by {{ $store->name }}
            ownership, and {{ $qi }} is authorized to implement said plan, and authorized
            with
            the appropriate authority to monitor and enforce its provisions and policies.</p>
    </div>
    <form class="divide-y" wire:submit.prevent="submit">
        <div class="py-10">
            <x-signature-pad wire:model.defer="signature"/>
        </div>
        <x-primary-button>
            <svg wire:loading class="animate-spin mr-1 h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Submit
        </x-primary-button>
    </form>
</div>
