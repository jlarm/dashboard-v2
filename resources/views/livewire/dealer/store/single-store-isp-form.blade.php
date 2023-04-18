<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div>
        <form class="divide-y" wire:submit.prevent="submit">
            <div class="pb-10 space-y-6">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="qi" class="block text-sm font-medium text-gray-700">Qualified Individual
                            Name</label>
                        <div class="mt-1">
                            <input disabled wire:model="qi" type="text" name="qi" id="qi"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('qi')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="qip" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="qip" type="text" name="qip" id="qip"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('qip')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="sm" class="block text-sm font-medium text-gray-700">Service
                            Manager</label>
                        <div class="mt-1">
                            <input disabled wire:model="sm" type="text" name="sm" id="sm"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('sm')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="smp" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="smp" type="text" name="smp" id="smp"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('smp')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="pm" class="block text-sm font-medium text-gray-700">Parts
                            Manager</label>
                        <div class="mt-1">
                            <input disabled wire:model="pm" type="text" name="pm" id="pm"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('pm')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="pmp" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="pmp" type="text" name="pmp" id="pmp"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('pmp')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="bsm" class="block text-sm font-medium text-gray-700">Body Shop
                            Manager</label>
                        <div class="mt-1">
                            <input disabled wire:model="bsm" type="text" name="bsm" id="bsm"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('bsm')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="bsmp" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="bsmp" type="text" name="bsmp" id="bsmp"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('bsmp')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="gm" class="block text-sm font-medium text-gray-700">General
                            Manager</label>
                        <div class="mt-1">
                            <input disabled wire:model="gm" type="text" name="gm" id="gm"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('gm')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="gmp" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="gmp" type="text" name="gmp" id="gmp"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('gmp')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="owner" class="block text-sm font-medium text-gray-700">Owner</label>
                        <div class="mt-1">
                            <input disabled wire:model="owner" type="text" name="owner" id="owner"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('owner')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="ownerp" class="block text-sm font-medium text-gray-700">Phone
                            Number</label>
                        <div class="mt-1">
                            <input disabled wire:model="ownerp" type="text" name="ownerp" id="ownerp"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                            @error('ownerp')
                            <p class="mt-2 text-sm text-red-600">This field is required.</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-10 space-y-6">
                @if(!tenant('locations'))
                    <p>If this information is outdated please update in <a class="text-arm-blue-500 underline"
                                                                           href="{{ route('dealer.dealer.settings') }}">settings</a>
                        @endif
                    </p>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="pepn" class="block text-sm font-medium text-gray-700">Police
                                Emergency
                                Phone Number</label>
                            <div class="mt-1">
                                <input disabled wire:model.defer="pepn" type="text" name="pepn" id="pepn"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('pepn')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="pnepn" class="block text-sm font-medium text-gray-700">Police
                                Non-Emergency Phone Number</label>
                            <div class="mt-1">
                                <input disabled wire:model.defer="pnepn" type="text" name="pnepn" id="pnepn"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('pnepn')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="fepn" class="block text-sm font-medium text-gray-700">Fire Emergency
                                Phone Number</label>
                            <div class="mt-1">
                                <input disabled wire:model.defer="fepn" type="text" name="fepn" id="fepn"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('fepn')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="fnepn" class="block text-sm font-medium text-gray-700">Fire
                                Non-Emergency Phone Number</label>
                            <div class="mt-1">
                                <input disabled wire:model.defer="fnepn" type="text" name="fnepn" id="fnepn"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('fnepn')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="py-10 space-y-6">
                <div>
                    <label for="alarmSystem" class="block text-sm font-medium text-gray-700">What type of
                        fire alarm System do you use?</label>
                    <div class="mt-1">
                        <input disabled wire:model.defer="alarmSystem" type="text" name="alarmSystem"
                               id="alarmSystem"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                        @error('alarmSystem')
                        <p class="mt-2 text-sm text-red-600">This field is required.</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="alarmSystem" class="block text-sm font-medium text-gray-700">What type of
                        burglar alarm system do you use?</label>
                    <div class="mt-1">
                        <input disabled wire:model.defer="burglarSystem" type="text" name="alarmSystem"
                               id="alarmSystem"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                        @error('alarmSystem')
                        <p class="mt-2 text-sm text-red-600">This field is required.</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-10">
                <x-signature-pad wire:model.defer="signature"/>
            </div>
            <x-primary-button>Submit</x-primary-button>
        </form>
    </div>
    <div class="prose">
        <div id="emergency-action-plan">
            <h2>Emergency Action Plan</h2>
            <h3>Purpose</h3>
            <p><strong>{{ config('app.name') }}</strong> is dedicated to the protection of its employees from
                emergencies such as
                tornadoes and fires. When emergencies do occur, our Emergency Action Plan (EAP) is initiated.
                This EAP is in place to ensure employee safety from emergencies during regular hours and
                after hours. It provides a written document detailing and organizing the actions and procedures
                to be followed by employees in case of a workplace emergency.</p>
            <p>OSHA's Emergency Action Plan requirements, found at 29 CFR 1910.38(a), require
                <strong>{{ config('app.name') }}</strong> to have a written emergency action plan (EAP). This plan
                applies to all operations
                in our company where employees may encounter an emergency situation.</p>
            <p>The EAP communicates to employees, policies and procedures to follow in emergencies. This
                written plan is available, upon request, to employees, their designated representatives, and any
                OSHA officials who ask to see it.</p>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $qi }}</strong> (or designee) is the (EAP) Emergency Action Plan administrator, who has
                overall responsibility for the plan. This responsibility includes the following:</p>
            <ul>
                <li>Developing and maintaining a written Emergency Action Plan for regular and after hours
                    work conditions;
                </li>
                <li>Notifying the proper rescue and law enforcement authorities, and the building
                    owner/superintendent in the event of an emergency affecting the facility;
                </li>
                <li>Taking security measures to protect employees;</li>
                <li>Integrating the Emergency Action Plan with any existing general emergency plan
                    covering the building or work area occupied;
                </li>
                <li>Distributing procedures for reporting emergencies, the location of safe exits, and
                    evacuation routes to each employee;
                </li>
                <li>Conducting drills to acquaint employees with emergency procedures and to judge the
                    effectiveness of the plan;
                </li>
                <li>Training designated employees in emergency response such as the use of fire
                    extinguishers and the application of first aid;
                </li>
                <li>Deciding which emergency response to initiate (evacuate or not);</li>
                <li>Ensuring that equipment is placed and locked in storage rooms or desks for protection;</li>
                <li>Maintaining records and property as necessary; and</li>
                <li>Ensuring that our facility meets all local fire codes, building codes, and regulations.</li>
            </ul>
            <p><strong>{{ $qi }}</strong> is responsible for reviewing and updating the plan as necessary. Copies
                of this plan may be obtained from <strong>{{ $qi }}’s</strong> office or compliance dashboard.</p>
            <p><strong>{{ $qi }}</strong>, has full authority to decide to implement the EAP if he/she believes an
                emergency might threaten human health. The following potential emergencies might reasonably
                be expected at this facility and thus call for the implementation of this EAP:</p>
            <p>Fire hazards and chemical spills</p>
            <p>The following personnel can be contacted regarding further information about duties under this
                written Emergency Action Plan:</p>
            <p><strong>{{ $qi }}</strong>, <strong>{{ $sm }}</strong>, or <strong>{{ $pm }}</strong></p>
            <p>Key management personnel emergency telephone numbers are kept in a safe place for
                immediate use in the event of an emergency. These telephone numbers include:</p>
            <table class="full-width border">
                <thead>
                <tr>
                    <th>Key Management Member</th>
                    <th>Title</th>
                    <th>Telephone Number</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $gm }}</td>
                    <td>General Manager</td>
                    <td>{{ $gmp }}</td>
                </tr>
                <tr>
                    <td>{{ $sm }}</td>
                    <td>Service Manager</td>
                    <td>{{ $smp }}</td>
                </tr>
                <tr>
                    <td>{{ $pm }}</td>
                    <td>Parts Manager</td>
                    <td>{{ $pmp }}</td>
                </tbody>
            </table>
            <p>These telephone numbers of key management personnel have been distributed to the following
                persons to be retained in their homes for use in communicating an emergency occurring during
                non-work hours:</p>
            <table class="full-width border">
                <thead>
                <tr>
                    <th>Management/Owners</th>
                    <th>Title</th>
                    <th>Telephone Number</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $gm }}</td>
                    <td>General Manager</td>
                    <td>{{ $gmp }}</td>
                </tr>
                <tr>
                    <td>{{ $sm }}</td>
                    <td>Service Manager</td>
                    <td>{{ $smp }}</td>
                </tr>
                </tbody>
            </table>
            <p>If, after reading this plan, you find that improvements can be made, please contact the Plan
                Administrator, <strong>{{ $qi }}</strong>. We encourage all suggestions because we are committed
                to the success of our Emergency Action Plan. We strive for clear understanding, safe behavior,
                and involvement in the program from every level of the company.</p>
            <h3>Alarms</h3>
            <p>Different emergencies call for different alarms to indicate what actions employees should take.
                <strong>{{ config('app.name') }}</strong> has established an employee alarm system that complies with 29
                CFR 1910.165.
                <strong>{{ config('app.name') }}</strong> uses in house fire suppression... We use a distinctive alarm
                capable of
                identification as a signal whether or not to evacuate for each emergency. We realize that where
                alarm signals have similar sounds and are used for purposes other than to signal evacuation,
                they can be confused with the fire alarm signal and either be ignored or cause overreaction.
                Therefore, we use a distinctive signal for each purpose, including alerting fire brigade members,
                if applicable. Fire alarms are located on each floor near each required exit. We will use the
                tornado alarm to warn employees of tornado watches and warning only.</p>
            <p>Because we use a communication system as an alarm system, all emergency messages have
                priority over all non-emergency messages.</p>
            <p>We have posted the following emergency telephone numbers near telephones, or emergency
                notice boards, and other conspicuous locations for use when telephones serve as a means of
                reporting emergencies:</p>
            <div class="grid grid-cols-2">
                <p class="mr-6">
                    <strong class="block">Emergency Responder</strong>
                    Fire, Police, EMS
                </p>
                <p>
                    <strong class="block">Telephone Number</strong>
                    911</p>
            </div>
            <p><strong>Emergency Reporting and Weather Monitoring Procedures</strong></p>
            <p><i>In the Event of an Emergency Requiring Evacuation</i></p>
            <p>When employees detect an emergency that requires an evacuation, such as a fire or hazardous
                release, they should notify direct supervisor, manager in charge of their department, call 911.
                Employee, supervisor or manager must call 911 if building alarm has not been activated.
                Building alarms may also activate and notify emergency response and local Fire Department.</p>
            <p>Our backup method for reporting emergencies that require evacuation includes the following:</p>
            <p>Work with local fire department and other first responders and ask for assistance</p>
            <p><i>In the Event of a Tornado Watch</i></p>
            <p>We monitor tornadoes by visual viewing, radios and TV.</p>
            <p>Our backup method for monitoring tornadoes includes the following: TV and radio</p>
            <h3>Evacuation Procedures</h3>
            <p>Some emergencies require evacuation or escape procedures, while some require employees to
                stay indoors, or in a safe area. Our emergency escape procedures are designed to respond to many
                potential emergencies, depending on the degree of seriousness. Nothing in these
                procedures precludes the Plan Administrator&#39;s authority in determining whether employees
                should remain inside or evacuate.</p>
            <p>At this company, the following types of emergency evacuations exist:</p>
            <p>Only those in the immediate area of an emergency may be expected to evacuate or move to a
                safe area such as when a localized fire breaks out but is extinguished before spreading,
                activating a fire suppression system discharges employee alarm.</p>
            <p>Our emergency escape procedures and assignments are designed to respond to many potential
                emergencies that require them, including: Fire, explosions and or hazardous chemical releases
                such as chemical spills...</p>
            <p>Employees need to know what to do if they are alerted to a specific emergency. After an alarm
                is sounded to evacuate, employees should take the following steps:</p>
            <p>Cease working and proceed to the nearest available and safe exit to leave the facility. Cover
                steps for evacuating non-employees and disabled employees.</p>
            <p>Once evacuated, employees are to head toward their designated exterior or safe area, where a
                head count will be performed, and further instructions given. Following is a list of exterior
                refuges/safe zones:</p>
            <div class="grid grid-cols-2">
                <p class="mr-6">
                    <strong class="block">Department Group</strong>
                    All Departments
                </p>
                <p>
                    <strong class="block">Designated Safe Area</strong>
                    Exterior of building parking lots</p>
            </div>
            <p><i>Procedures to Account for Employees</i></p>
            <p>Supervisors will assist in a safe and orderly evacuation for all types of emergencies that require
                evacuation. Once evacuation is complete, they conduct head counts. The supervisors are
                trained in the complete workplace layout and the various alternative escape routes from the
                workplace. Before leaving, these supervisors check rooms and other enclosed spaces in the
                workplace for employees who may be trapped or otherwise unable to evacuate the area.</p>
            <p>Supervisors will direct and assist in safe and orderly emergency evacuation to;</p>
            <ul>
                <li>Provide guidance and instruction for all types of emergency situations,</li>
                <li>Be aware of employees with special needs who may require extra assistance,</li>
                <li>Use the buddy system, and</li>
                <li>Avoid hazardous areas during an emergency evacuation.</li>
            </ul>
            <p>The Supervisors will also serve as a resource of information about emergency procedures and
                conduct head counts once evacuation is complete.</p>
            <p>Frontline supervisors must be aware of the locations of those employees working on a particular
                day when an emergency occurs, as well as suppliers, customers, and other non-employees on
                the premises, when an emergency occurs, and be aware of who is absent or otherwise away
                from the premises. Accounting for employees and non-employees will aid local responding fire/rescue
                departments in determining whether rescue efforts are necessary. Each manager will
                be responsible for their employees.</p>
            <p>Once each evacuated group of employees have reached their evacuation destinations, each
                supervisor:</p>
            <ul>
                <li>Takes roll of his or her group,</li>
                <li>Makes sure all persons are accounted for,</li>
                <li>Reports in to a central checkpoint managed by <strong>{{ $qi }}</strong> or designee, and</li>
                <li>Assumes role of department contact to answer questions.</li>
            </ul>
            <p>Head count results should be given to the Fire Chief, and firefighter, if requested. Follow any
                and all Fire Departments and emergency response personnel recommendations.</p>
            <p>No employees are to return to the buildings until advised by their supervisor or designee (after
                determination has been made that such re-entry is safe). If anyone is injured or contaminated,
                the Plan Administrator will activate rescue and first aid actions with the local emergency
                response teams, i.e., fire department, police and or EMS personnel. If an emergency incident
                expands, the EAP Administrator may send employees home by normal means or provide them
                with transportation to an offsite location.</p>
            <h3>Non-Evacuation Emergency Procedures</h3>
            <p><strong>{{ config('app.name') }}</strong> has the following non-evacuation procedures:</p>
            <p>Proceed to the nearest shelter, or move to a different area a safe distance from the emergency.</p>
            <p><i>Responding to a tornado alarm</i></p>
            <p>In the event of a tornado, it is corporate policy to provide emergency warning and shelter. Once
                employees are made aware of a tornado situation, they are to follow these procedures:</p>
            <p>Tornado emergency will include alerting any visitors to the emergency and taking those visitors
                with them to the nearest tornado shelter.</p>
            <p>Employees should stay away from windows, but stay inside the building they are in. Employees
                are not to leave the shelter or return to their regular duties until the all clear is given.</p>
            <p><strong>{{ $qi }}</strong> or designee will determine when it is safe for employees to leave their
                tornado shelter and return to work. At that time, the Plan Administrator will notify the emergency
                response teams, i.e., fire department or police departments.</p>
            <p>If there is structural damage, the Plan Administrator will contact insurance company.</p>
            <p>If anyone is injured or contaminated, the Plan Administrator will activate rescue and first aid
                actions coordinating with local emergency response teams.</p>
            <h3>Plan Administrator Duties</h3>
            <p>During an emergency, <strong>{{ $qi }}</strong> will do the following:</p>
            <p>Assist where ever possible.</p>
            <h3>Rescue and First Aid</h3>
            <p>Rescue and first aid may be necessary during emergency situations. Circumstances calling for
                rescue and/or first aid will be coordinated with the local fire department and EMS.</p>
            <p>Appropriate first-aid supplies have also been provided.</p>
            <p>Professional emergency services responding in an emergency will help with and direct all
                rescue and medical duty assignments upon their arrival on site.</p>
            <h3>Training</h3>
            <p>Our Plan Administrator reviews with each of our employees at the following times, those parts of
                the Emergency Action Plan that employees must know to protect themselves in the event of an
                emergency:</p>
            <ul>
                <li>Initially when the plan is developed,</li>
                <li>Whenever a new employee is hired,</li>
                <li>Whenever an employee&#39;s responsibilities or designated actions under the plan change,</li>
                <li>Whenever new equipment, materials, or processes are introduced into the workplace,</li>
                <li>Whenever the layout or design or the facility changes, and</li>
                <li>Whenever the plan is changed.</li>
            </ul>
            <p>The training includes the following: self-administered from the supervisors to the employees.</p>
            <p>The information in this plan is not intended for casual reading, but is intended to get the
                appropriate message across. We communicate the contents of this plan through a briefing
                delivered by supervisors in their department meetings.</p>
            <h3>Emergency Equipment and Support</h3>
            <p>Our company provides the following equipment and support for use by our trained personnel
                during emergencies:</p>
            <p>Fire extinguishers, fire hoses, brooms, shovels, hoses, spill control kits, absorbent, and
                flashlights.</p>
        </div>

        <div id="hazard-communication-program">
            <h2>Hazard Communication Program</h2>
            <h3>Purpose</h3>
            <p>The purpose of this program is to inform interested persons, including employees, that
                <strong>{{ config('app.name') }}</strong> is complying with the OSHA Hazard Communication Standard,
                Title 29 Code of
                Federal Regulations 1910.1200, by compiling a hazardous chemicals list, by using material
                safety data sheets (SDSs), by ensuring that containers are labeled, and by providing our
                employees with training and information availability.</p>
            <p>This program applies to all work operations in our company where employees may be exposed
                to hazardous substances under normal working conditions or during an emergency situation.</p>
            <p>The safety and health manager, <strong>{{ $qi }}</strong>, is the program coordinator, acting as the
                representative of the plant manager, who has overall responsibility for the program.
                <strong>{{ $qi }}</strong> will review and update the program, as necessary. Copies of the written
                program
                may be obtained from <strong>{{ $qi }}</strong>, service department or online compliance
                dashboard.</p>
            <p>All employees, or their designated representatives, can obtain further information on this written
                program, the hazard communication standard, applicable SDSs, and chemical information lists
                from <strong>{{ $qi }}’s</strong> office and dealership’s compliance dashboard.</p>
            <h3>Hazard Evaluation Procedures</h3>
            <p>Our chemical inventory is a list of hazardous chemicals known to be present in our workplace.
                Anyone who comes into contact with the hazardous chemicals on the list needs to know what
                those chemicals are and how to protect themselves. All SDS that enter into the building through
                shipping and receiving will be taken to the supervisor’s office were the SDS booklets are kept.</p>
            <p>The safety and health manager, <strong>{{ $qi }}</strong>, also keeps the chemical inventory list,
                along with related work practices used in our facility located in the service department’s
                supervisor&#39;s office or electronically on any dealership’s computers, where it is always accessible
                during work hours.</p>
            <p>The company does not manufacture any chemicals and, therefore, does not make any hazard
                determinations.</p>
            <p>After the chemical inventory is compiled, it serves as a list of every chemical for which an SDS
                must be maintained. Parts <strong>Managerx</strong> updates the inventory as necessary.</p>
            <h3>Material Safety Data Sheets (SDS’s)</h3>
            <p><strong>{{ $pm }}</strong>, <strong>titlex3</strong> will be responsible for obtaining/maintaining the
                SDSs at our facility.
                He/she will contact the chemical manufacturer or vendor if additional research is necessary. All
                new procurements for the company must be cleared by <strong>{{ $pm }}</strong> or
                <strong>{{ $sm }}</strong>,</p>
            <p>The material safety data sheets are kept at the following location(s) in our facility: service
                department’s supervisor&#39;s office, <strong>{{ $sm }}</strong>. Employees can obtain access to them by
                accessing the supervisor’s office during their shift and on a SDS link provided on dealership
                computers.</p>
            <p>The procedure followed if the SDS is not received at time of first shipment is: contact chemical
                manufacturer and have them ship/fax an SDS to the dealership. There is also access to an on-
                line SDS warehouse provided by ARMP and or manufacturers and can print them out from
                there.</p>
            <p>We do not generate SDSs.</p>
            <p>No alternatives to SDSs are used in this workplace.</p>
            <h3>Labels &amp; Other Forms of Warning</h3>
            <p>Labels list at least the chemical identity, appropriate hazard warnings, and the name and
                address of the manufacturer, importer or other responsible party. Our labels are legible and
                prominently displayed, though their sizes and colors can vary.</p>
            <p><strong>{{ $sm }}</strong>, is responsible for ensuring that all hazardous chemicals in in-plant
                containers are properly labeled and updated, as necessary. Service Manager or designee also
                ensures that newly purchased materials are checked for labels prior to use.</p>
            <p><strong>{{ $pm }}</strong>, is responsible for ensuring the proper labeling of any shipped containers.
            </p>
            <p><strong>{{ $pm }}</strong> or designee will refer to the corresponding SDS to assist employees in
                verifying label information.</p>
            <p>A poster is displayed in the employee lunch room/locker room to inform employees about the
                hazard communication standard. It is an OSHA standard SDS poster.</p>
            <p>The labeling system used on in-plant and shipped containers is a HMIS labeling system. HMIS
                stands for Hazardous Materials Identification System.</p>
            <p>If employees transfer chemicals from a labeled container to a portable container that is intended
                only for their IMMEDIATE use, no labels are required on the portable container.</p>
            <p>No alternatives to labeling are used in this workplace.</p>
            <p>The following procedures are used to review and update label information when necessary and
                to ensure that labels that fall off or become unreadable are immediately replaced: during the
                quarterly audit supervisors will note any damaged or missing labels and replace immediately.</p>
            <h3>Training</h3>
            <p>Everyone who works with or is potentially exposed to hazardous chemicals will receive initial
                training and any necessary retraining on the Hazard Communication Standard and the safe use
                of those hazardous chemicals by Automotive Risk Management Partners Whenever a new
                hazard is introduced or an old hazard changes, additional training is provided.</p>
            <p>We ask our employees to ask Automotive Risk Management Partners and <strong>{{ $sm }}</strong> if
                they have any questions. As part of the assessment of the training program, Automotive Risk
                Management Partners asks for input from employees regarding the training they have received,
                and their suggestions for improving it.</p>
            <p>All employees receive training for hazard communication.</p>
            <p>Training content is organized according to an on-line web base training program that is time and
                date stamp when completed. They are trained on specific hazardous chemicals present in their
                work environment The format of the training program used is the same by using an on-line web
                base training program.</p>
            <p>The training plan emphasizes the elements required by 29 CFR 1910.1200(h).</p>
            <p>The procedure to train new employees at the time of their initial assignment is when they are
                hired and assigned user names and passwords to access an on-line web-based training
                program and must be completed within their 90-day probationary period. We train employees
                when a new hazard is introduced by introduce the chemical at their department meeting and
                review the current SDS explaining any specific hazards that should be known about the
                chemical.</p>
            <p>Annually employees will be administered the on-line web base training modules and sign off on.</p>
            <h3>Hazards of Unlabeled Pipes</h3>
            <p>We inform employees of the hazards of chemicals contained in unlabeled pipes in their work
                areas during their initial hiring process.</p>
            <h3>Additional Information</h3>
            <p>All employees, or their designated representatives, can obtain further information on this written
                program, the hazard communication standard, applicable SDS’s, and chemical information lists
                from Automotive Risk Management Partners or <strong>{{ $sm }}</strong>.</p>
            <h3>Appendix</h3>
            <p>We have attached to this plan the lists, samples, or procedures that ensure better
                understanding of our written program.</p>
            <p class="red">"STATE PLAN STATE SPECIFIC Hazard communication added here if needed"</p>
        </div>

        <div id="hazwoper">
            <h2>HAZWOPER (Hazardous Waste Operations and Emergency Response)</h2>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $sm }}</strong>, is responsible for developing and maintaining our facility&#39;s HAZWOPER
                plan. The plan is available for review and is kept at supervisor&#39;s and or manager&#39;s office in
                the
                service department.</p>
            <h3>General</h3>
            <p>HAZWOPER is a complicated regulation, with many different elements required. At
                <strong>{{ config('app.name') }}</strong>
                we have done a thorough job of complying with the many aspects of HAZWOPER.</p>
            <p>Because employees use a variety of types of PPE and/or respiratory equipment, in their day-to-
                day operations, or in the event of a chemical spill, we needed to develop PPE and/or
                Respiratory Protection plans. See attached plans.</p>
            <p><strong>{{ $sm }}</strong>, is in charge of the HAZWOPER safety and health programs.</p>
            <p>The decontamination procedures used at our facility are Universal absorbent mats, socks,
                booms, pillows, and floor absorbent granular and compound floor sweep that handle oils,
                coolants, solvents, water and many other types of liquids found in and around auto dealerships.
                Call emergency response i.e., fire departments HAZMAT unit if spill is in a large quantity.</p>
            <p>The site control measures used are immediately clean up any chemical spills with absorbent
                material provided by your department supervisor.</p>
            <h3>HAZWOPER Training Program</h3>
            <p>As part of the HAZWOPER program, this facility has developed and implemented a program to
                inform workers (including contractors and subcontractors) performing hazardous waste or
                emergency response operations of the level and degree of exposure they are likely to
                encounter.</p>
            <p>This company has also implemented procedures for introducing effective new technologies that
                provide improved worker protection in hazardous waste operations and spill/leak cleanup.
                Examples include PPE, foams, absorbents, adsorbents, neutralizers, etc.</p>
            <p>Training makes workers aware of the potential hazards they may encounter and provides the
                necessary knowledge and skills to perform their work with minimal risk to their safety and
                health. The employer must develop a training program for all employees exposed to safety and
                health hazards.</p>
            <p>Both supervisors and workers must be trained to:</p>
            <ul>
                <li>Recognize hazards and to prevent them;</li>
                <li>Select, care for, and use respirators properly as well as other types of personal
                    protective equipment;
                </li>
                <li>Understand engineering controls and their use;</li>
                <li>Use proper decontamination procedures;</li>
                <li>Understand the Emergency Response Plan, medical surveillance requirements, confined
                    space entry procedures, spill containment program, and any appropriate work practices.
                </li>
            </ul>
            <p>Workers also must know the names of personnel and their alternatives responsible for site
                safety and health. The amount of instruction differs with the nature of the work operations.
                Employees must not perform any hazardous waste or emergency response operation unless
                they have been trained to the level required by their job function and responsibility and has been
                certified by their instructor as having completed the necessary training. All emergency
                responders must receive refresher training sufficient to maintain or demonstrate competency
                annually. Employee training requirements are further defined by the nature of the work (e.g.,
                temporary emergency response personnel, firefighters, safety officers, HAZMAT personnel,
                incident commanders, etc.)</p>
            <p>At our facility, <strong>{{ $qi }}</strong>, is the person responsible for conducting training. We make
                a determination as to who to train by using the following criteria:</p>
            <p>All service and parts department employees and any other employee that would possibly be
                exposed and are working around potential hazardous chemicals etc.</p>
            <p>We want to offer the best training for our workers, so the format of the program that is used is to
                utilize an outside consulting company that provides on line instructional training/documentation
                and testing of HAZ-COM related material.</p>
            <p>The procedure to train new employees at the time of their initial assignment is that they are
                assign a series of training module through there department supervisor and will be responsible
                for completion in a short period of time, i.e., probationary period. Tracking the training and
                retraining will be accomplished by supervisors and dealership management.</p>
            <p>Employees at all hazardous waste sites have been trained to the level required by their job
                function and responsibility prior to performing any hazardous waste operation.</p>
            <p>All emergency responders have received refresher training sufficient to maintain or demonstrate
                competency annually.</p>
            <p>We ascertain that this plan is being followed by utilizing a web base training program that time
                and date stamps all training upon completion.</p>
            <h3>Organizational Structure</h3>
            <p><strong>{{ $sm }}</strong>, is the general supervisor who has the responsibility and authority to direct
                all hazardous waste operations.</p>
            <p><strong>{{ $qi }}</strong>, is the site safety and health supervisor who has the responsibility and
                authority to develop and implement the site safety and health plan and verify compliance.</p>
            <p>Other personnel who are needed for hazardous waste site operations and emergency response
                are <strong>{{ $sm }}</strong>, and <strong>{{ $pm }}</strong>. Their general functions and
                responsibilities are
                management oversight and assistance if needed during emergencies.</p>
            <p>The lines of authority, responsibility, and communication are as follows: <strong>{{ $qi }}</strong>,
                <strong>{{ $sm }}</strong> and then <strong>{{ $pm }}</strong></p>
            <p>Our organizational structure is reviewed and updated as necessary to reflect the current status
                of waste site operations.</p>
            <h3>Site-Specific Safety and Health Plan</h3>
            <p>Our Site-Specific Safety and Health Plan is a program that aids in eliminating or effectively
                controlling anticipated safety and health hazards. The Site-Specific Safety and Health Plan
                identify the hazards of each phase of the specific site operation and is kept on the work site.
                The Site-Specific Safety and Health Plan addresses the safety and health hazards of each
                phase of site operation and includes the requirements and procedures for employee protection.</p>
            <p>Personal protective equipment is used by employees for some of the site tasks and operations
                being conducted. See the attached Personal Protective Equipment Plan for details.</p>
            <p>Our facility does air monitoring as follows: None</p>
            <p>Our facility does personnel monitoring as follows: visual inspection during auditing process
                when employees are working with said chemicals</p>
            <p>The environmental sampling techniques and instrumentation that are used, including methods
                of maintenance and calibration of monitoring and sampling equipment used, are as follows: this
                is outsourced to the appropriate service vendor that the product was purchased from</p>
            <p>Our spill containment program is as follows: Universal absorbent mats, socks, booms, pillows,
                and floor absorbent granular and compound floor sweep that handle oils, coolants, solvents,
                water and many other types of liquids found in and around auto dealerships.</p>
            <p>The work plan is kept in the shop foreman&#39;s office. We conduct inspections to detect
                deficiencies in the site safety and health plan as follows: quarterly</p>
            <h3>Contractor Safety</h3>
            <p>Contractors working at our facility need to be protected from hazards that may be on our
                premises.</p>
            <p>We routinely make the written safety and health program available to any contractor who will be
                involved with the hazardous waste operation.</p>
        </div>

        <div id="lockout-tagout">
            <h2>Lockout/Tagout – Energy Control Program</h2>
            <h3>Purpose</h3>
            <p>This procedure establishes this company&#39;s requirements for the lockout of energy isolating
                devices whenever maintenance or servicing is done on machines or equipment, in accordance
                with the requirements of OSHA&#39;s 1910.147. This program applies to all work operations at
                <strong>{{ config('app.name') }}</strong> where employees must deal with lockout/tagout situations as
                part of their job
                duties to ensure that the machine or equipment is stopped, isolated from all potentially
                hazardous energy sources, and locked out before employees perform any servicing or
                maintenance.</p>
            <h3>Authorized and Affected Employees</h3>
            <p>Authorized employees subject to the requirements of this program and to be trained on their
                duties within it include: outside certified contractor/electrical company employees and
                supervisory personnel only, no hourly employees from <strong>{{ config('app.name') }}</strong> are
                authorized to utilize
                lockout/tagout equipment. Affected employees subject to the requirements of this program and to be
                trained on their duties
                within it include all employees located in the service department and parts department.</p>
            <h3>Machinery and Equipment</h3>
            <p>The machinery and equipment in this facility that falls under the Control of Hazardous Energy
                Standard includes the following: no such machine or equipment has the potential for stored or
                residual energy or reaccumulating of stored energy after shut down which could endanger
                employees.</p>
            <p>Lockout is the preferred method of isolating machines or equipment from energy sources.
                Tagout is to be performed instead of lockout only when there is no way to lockout a machine.
                See your supervisor for a list of machines that can only be tagout.</p>
            <h3>Lockout / Tagout Procedures</h3>
            <p>Affected employees are notified in person when their machine is to be locked out and or tagged
                out.</p>
            <p>The machinery and equipment listed above follows these shutdowns, isolation, blocking and
                securing procedures for lockout/tagout: Preparation for shutdown. Before an authorized or
                affected employee turns off a machine or equipment, the authorized person shall have
                knowledge of the type and magnitude of the energy, the hazards of the energy to be controlled,
                and the method or means to control the energy.</p>
            <p>Machine or equipment shutdown. The machine or equipment shall be turned off or shut down
                using the procedures established for the machine or the equipment. An orderly shutdown must
                be utilized to avoid any additional or increased hazard(s) to employees as a result of equipment
                stoppage.</p>
            <p>Machine or equipment isolation. All energy isolating devices that are needed to control the
                energy to the machine or equipment shall be physically located and operated in such a manner
                as to isolate the machine or equipment from the energy source(s).</p>
            <p>The machinery and equipment listed above follows these lockout placement, removal, transfer,
                and responsibility procedures: Lockout or tagout devices shall be affixed to each energy
                isolating device by authorized personnel.</p>
            <p>- Lockout devices, where used, shall be affixed in a manner that will hold the energy isolating
                devices in a &quot;safe&quot; or &quot;off&quot; position.</p>
            <p>- Tagout devices, where used, shall be affixed in such a manner as will clearly indicate that the
                operation or movement of energy isolating devices from the &quot;safe&quot; or &quot;off&quot; position
                is prohibited.</p>
            <p>Where tagout devices are used with energy isolating devices designed with the capability of
                being locked, the tag attachment shall be fastened at the same point at which the lock would
                have been attached. Where a tag cannot be affixed directly to the energy isolating device, the
                tag shall be located as close as safely possible to the device, in a position that will be
                immediately obvious to anyone attempting to operate the device.</p>
            <p>Stored energy. Following the application of lockout or tagout devices to energy isolating devices,
                all potentially hazardous stored or residual energy shall be relieved, disconnected, restrained,
                and otherwise rendered safe.</p>
            <p>(ii) If there is a possibility of reaccumulating of stored energy to a hazardous level, verification of
                isolation shall be continued until the servicing or maintenance is completed, or until the
                possibility of such accumulation no longer exists.</p>
            <p>Verification of isolation. Prior to starting work on machines or equipment that have been locked
                out or tagged out, the authorized personnel shall verify that isolation and DE-energization of the
                machine or equipment have been accomplished, even though isolation is performed prior to
                shut down and is checked at that point. Release from lockout or tagout.</p>
            <p>Before lockout or tagout devices are removed and energy is restored to the machine or
                equipment, procedures shall be followed and actions taken by the authorized employee(s) to
                ensure the following:</p>
            <p>- The machine or equipment. The work area shall be inspected to ensure that nonessential
                items have been removed and to ensure that machine or equipment components are
                operationally intact.</p>
            <p>- Employees. The work area shall be checked to ensure that all employees have been safely
                positioned or removed.</p>
            <p>After lockout or tagout devices have been removed and before a machine or equipment is
                started, affected employees shall be notified that the lockout or tagout device(s) have been
                removed.</p>
            <p>Lockout or tagout devices removal. Each lockout or tagout device shall be removed from each
                energy isolating device by the person who applied the device. Exception: When the authorized
                person who applied the lockout or tagout device is not available to remove it, that device may be
                removed under the direction of the employer, provided that specific procedures and training for
                such removal have been developed, documented and incorporated into the employer&#39;s energy
                control program. The employer shall demonstrate that the specific procedure provides
                equivalent safety to the removal of the device by the authorized person who applied it. The
                specific procedure shall include at least the following elements:</p>
            <p>- Verification by the employer that the authorized person who applied the device is not at the
                facility;</p>
            <p>- Making all the reasonable efforts to contact the authorized person to inform him/her that
                his/her lockout or tagout device has been removed; and</p>
            <p>- Ensuring that the authorized person has this knowledge before he/she resumes work at that
                facility.</p>
            <p>The machinery and equipment listed above follows this procedure to test the machines to
                determine and verify the effectiveness of lockout devices, tagout devices, and other energy
                control measures: Ensure that the equipment is disconnected from the energy source(s) by:</p>
            <p>Checking that no personnel are exposed, then
                Verifying the isolation of the equipment by operating the push button or other normal operating
                or startup control(s) to make certain the equipment will not operate.
                Return the operating control(s) to neutral or &quot;off&quot; position after verifying that the
                equipment is
                isolated. The machine or equipment is now locked out and servicing or maintenance may safely
                begin.</p>
            <h3>Periodic Inspection</h3>
            <p>A periodic inspection is done, looking at the energy control procedures performed to ensure that
                the procedure and requirements of the standard are being followed. This inspection is
                performed bi-annually.</p>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $sm }}</strong>, has overall responsibility for coordinating safety and health programs in
                this
                company.</p>
            <p>Service Manager is the person having overall responsibility for the Lockout/Tagout Program.
                Service manager will review and update the program, as necessary. Copies of the written
                program may be obtained from service manager’s office.</p>
        </div>

        <div id="electrical-safety-plan">
            <h2>Electrical Safety Plan</h2>
            <h3>General Company Policy</h3>
            <p>The purpose of this program is to inform interested persons, including employees, that
                <strong>{{ config('app.name') }}</strong> is complying with the OSHA Electrical Safety Standard, Title
                29 Code of Federal
                Regulations 1910.333, by determining that this workplace needs written procedures for
                preventing electric shock or other injuries resulting from direct/indirect electrical contacts to
                employees working on or near energized or deenergized parts. This program applies to all work
                operations at <strong>{{ config('app.name') }}</strong> where employees may be exposed to live parts
                and/or those parts
                that have been deenergized.</p>
            <p><strong>{{ $qi }}</strong> has overall responsibility for coordinating safety and health programs in
                this company. <strong>{{ $sm }}</strong> is the person having overall responsibility for the Electrical
                Safety Program. Service manager will review and update the program, as necessary. Copies of
                the written program may be obtained from service manager’s office. Under this program, our
                employees receive instructions in the purpose and use of energy control procedures, as well as
                the other required elements of the Control of Hazardous Energy standard. This instruction
                includes the deenergizing of equipment, applying locks and tags, verifying DE-energization, and
                equipment reenergizing.</p>
            <p>If, after reading this program, you find that improvements can be made, please contact your
                department manager. We encourage all suggestions because we are committed to creating a
                safe workplace for all our employees and a successful electrical safety program is an important
                component of our overall safety plan. We strive for clear understanding, safe work practices,
                and involvement in the program from every level of the company.</p>
            <h3>Hazard Analysis Report</h3>
            <p>To determine areas of <strong>{{ config('app.name') }}</strong> that need to be included in the
                Electrical Safety Program,
                the service manager has conducted a hazard analysis of our workplace. This analysis located in
                shop foreman’s office, has provided us with information identifying which departments have
                equipment using electricity, various types of wiring installations, and the types of employee
                functions that must be covered by the Electrical Safety Program. The departments/areas of our
                company identified as having electrically operated equipment and/or wiring installations are
                service department, technicians’ service bays, parts department, detail center, body shop (if
                applicable).</p>
            <p>Electrically operated equipment that must be deenergized before work can be done on it and
                where it is located includes all power equipment that must be unplugged and or disconnected
                from electrical power source before work can be administered. There are no such electrical
                tools/equipment that once unplugged would need to power down i.e., hold a short-term electrical
                charge.</p>
            <p>Employees of our company who are qualified to work on, near, or with energized electric circuits
                and equipment are employees who have undergone on-the-job training and who, in the course
                of such training, has demonstrated an ability to perform duties safely at his or her level of training
                and who is under the direct supervision of a qualified person that is a qualified person
                for the performance of those duties.</p>
            <p>Employees working on, near, or with energized electric circuits and equipment who have limited
                knowledge of electrical circuitry are considered an unqualified person who has little or no
                training in avoiding the electrical hazards of working on or near exposed energized parts.</p>
            <h3>Training Program</h3>
            <p>Every employee at <strong>{{ config('app.name') }}</strong> who faces the risk of electric shock from
                working on or near
                energized or deenergized electrical sources receives training in electrical related safety work
                practices pertaining to the individual&#39;s job assignment.</p>
            <p>The goal of our electrical safety training program is to ensure that all employees understand the
                hazards associated with electric energy and that they are capable of performing the necessary
                steps to protect themselves and their coworkers.</p>
            <p>Our electrical training program covers these basic elements:</p>
            <ul>
                <li>Lockout and tagging of conductors and parts of electrical equipment.</li>
                <li>Safe procedures for deenergizing circuits and equipment.</li>
                <li>Application of locks and tags.</li>
                <li>Verification that the equipment has been deenergized.</li>
                <li>Procedures for reenergizing the circuits or equipment.</li>
                <li>Other electrically related information which is necessary for employee safety.</li>
            </ul>
            <p>These are the electrical safety procedures we teach to those employees who have limited
                knowledge (&quot;unqualified&quot;) of electrical circuitry but must work near or on such electrical
                equipment. This training must be completed before participants will be allowed to work in areas
                of <strong>{{ config('app.name') }}</strong> where electrical hazards exist.</p>
            <p>The format we follow for our training program receives both classroom instruction through on-
                line web base training on electrical safety and on-the-job training.</p>
            <p>The procedures we follow when training new employees who will be working on or near
                electrical equipment or circuitry is that each employee must take the basic safety web base
                training module, sign off and test before their initial assignment. When changes involving
                electrical elements occur in our company, we provide additional employee training ensuring the
                safety of all affected workers. In this case, we follow these procedures: immediate on-the-job
                training will take place when situations such as new equipment, reorganization and remodeling
                take place in the dealership.</p>
            <p><strong>{{ config('app.name') }}</strong> conducts the electrical safety training for all employees.
                Every employee who
                participates in the Electrical Safety Program receives an acknowledgement from the web base
                training program which they will sign off on verifying that they have completed the course, that
                they understand the information presented, and that they will follow all company policies and
                procedures regarding electrical safety. These signed certificates of training as well as all training
                materials and documentation are kept on dealership’s online compliance dashboard.</p>
            <h3>Lockout and Tagging Program</h3>
            <p>It is a <strong>{{ config('app.name') }}</strong> policy that circuits and equipment must be disconnected
                from all electric
                energy sources before work on them begins. We use lockout and tagging devices to prevent the
                accidental reenergization of this equipment. Lockout and tagout procedures are the main
                component of our electrical safety program. The safety procedures that make up our lockout
                and tagging program include these elements:</p>
            <p>Deenergizing circuits and equipment. We disconnect the circuits and equipment to be worked
                on from all electric energy sources and we release any potential stored energy that could
                accidentally reenergize equipment.</p>
            <ul>
                <li><strong>Application of locks and tags.</strong> Only authorized employees are allowed to place a
                    lock and
                    tag on each disconnecting means used to deenergize our circuits or equipment before work
                    begins. Our locks prevent unauthorized persons from reenergizing the equipment or circuits and
                    the tags prohibit unauthorized operation of the disconnecting device.
                </li>
                <li><strong>Verification of deenergized condition of circuits and equipment.</strong> Prior to work on
                    the
                    equipment, we require that a &quot;qualified&quot; employee verify that the equipment is deenergized
                    and
                    cannot be restarted.
                </li>
                <li><strong>Reenergizing circuits and equipment.</strong> Before circuits or equipment are reenergized,
                    we
                    follow these steps in this order:
                    <ul>
                        <li>A &quot;qualified&quot; employee conducts tests and verifies that all tools and devices have
                            been
                            removed.
                        </li>
                        <li>All exposed employees are warned to stay clear of circuits and equipment.</li>
                        <li>Authorized employees remove their own locks and tags.</li>
                        <li>We do a visual inspection of the area to be sure all employees are clear of the circuits
                            and equipment.
                        </li>
                    </ul>
                </li>
            </ul>
            <p>In addition to lockout and tagging elements, see &quot;LOTO&quot; safety tab for additional full
                disclosure
                procedures.</p>
            <p>Lockout/tagout must be performed by a qualified person as assigned by department supervisor.
                They must be trained and authorized to deenergize, verify, and reenergize electric circuits and
                equipment in our company.</p>
            <h3>Enforcement</h3>
            <p>Constant awareness of and respect for electrical hazards, and compliance with all safety rules
                are considered conditions of employment. Supervisors and individuals in the Safety and
                Personnel Department reserve the right to issue disciplinary warnings to employees, up to and
                including termination, for failure to follow the guidelines of this program.</p>
            <h3>Appendix</h3>
            <p>We have attached to this plan any lists, samples, or procedures we thought would ensure better
                understanding of our written program.</p>
            <h3>DISCONNECTING HIGH VOLTAGE IN ELECTRIC/HYBRID VEHICLES</h3>
            <p>Electric and Hybrid vehicle run in excess of 300 plus volts</p>
            <p>Equipment needed, High Voltage Gloves and a 12 Volt meter</p>
            <h3>Battery Basics</h3>
            <img src="{{ asset('storage/battery-pack.jpeg') }}" alt="Battery Pack">
            <ul>
                <li>Equipment needed, High Voltage Gloves and a 12 Volt meter</li>
                <li>Battery Packs that are inside of case</li>
                <li>Battery Smart Module (BSM) which communicates on serial data to identifies a number of situations
                    where high voltage should be disabled or any other number of issues identified i.e., shorts, SIR,
                    interlocks.
                    <ul>
                        <li>BSM opens the circuits disconnecting power to vehicle when the following occur:
                            <ul>
                                <li>Turning vehicle key off with and or</li>
                                <li>Disconnecting battery terminals</li>
                            </ul>
                        </li>
                        <li>Orange service plug (Disconnect switch) – for additional protection (interrupts the voltage
                            coming out of battery packs).
                        </li>
                    </ul>
                </li>
                <li>Once the vehicles Key is turned off, the BSM Opens the contacts inside the battery disconnecting the
                    High Voltage source from the actual outlet terminals that provide power to the vehicle.
                </li>
            </ul>
            <h3>7 Step Process to insure proper HV source disconnected</h3>
            <ol>
                <li>Turn key off and remove it from the vehicle and store it on the workbench.</li>
                <li>Disconnect cable from 12-volt battery on the negative lead and insure cable cannot re-touch battery
                    terminal.
                </li>
                <li><span class="red">(Put High Voltage Gloves on)</span>
                    <ul>
                        <li>Disconnect the orange service plug on the side of the HV battery and remove and store it on
                            the workbench as well. This gives an additional level of protection in case the contact
                            relays were stuck “Closed” after turning the key off or disconnecting battery terminals.
                        </li>
                    </ul>
                </li>
                <li>Wait 10 minutes to ensure capacitors are fully discharged
                    <ul>
                        <li>Take your volt meter and put leads on the positive and negative battery terminals and make
                            sure the meter shows active 12 volts. This confirms your settings are correct on the meter.
                        </li>
                    </ul>
                </li>
                <li><span class="red">(HV Gloves on)</span>
                    <ul>
                        <li>Remove the Power Inverter electrical cover to give you access to the HV terminals inside.
                        </li>
                    </ul>
                </li>
                <li><span class="red">(HV Gloves on)</span>
                    <ul>
                        <li>Take the voltmeter and touch each HV terminal and check that it is registering “0” volts.
                        </li>
                    </ul>
                </li>
                <li><span class="red">(HV Gloves on)</span>
                    <ul>
                        <li>Reverse the polarity and check HV terminals again ensuring a reading of “0” volts.</li>
                        <li>This will ensure that the vehicle has been disabled from all electrical charges
                            throughout.
                        </li>
                    </ul>
                </li>
                <li>Re-check volt meter on the battery terminals again to ensure the meter is still operating properly
                    and that all electrical tests were being recorded accurately at ZERO voltage. Doing this last check
                    is called the “Live Dead Live” procedure.
                </li>
            </ol>
            <h3>Live Dead Live Procedure Completed</h3>
            <p><i>***Now you will know positively that the Hybrid/EV vehicle is not carrying any voltage that can harm
                    you in any way. It is now safe to work on your vehicle.
                </i></p>
        </div>

        <div id="storm-water-pollution-plan">
            <h2>Storm Water Pollution Plan</h2>
            <h3>General Company Policy</h3>
            <p>The purpose of this program is to inform interested persons, including employees, that our company is
                complying with EPA requirements for preparing and maintaining a Stormwater Written Pollution Prevention
                Plan under the stormwater regulations (40 CFR 122).</p>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $sm }}</strong>, is responsible for our written stormwater pollution prevention plan. Copies
                of our written plan may be obtained from service departments office. Employees can obtain access to the
                plan by accessing the supervisor’s office area to review.
                <strong>{{ $sm }}</strong> and <strong>{{ $qi }}</strong>, make up our company's stormwater pollution
                prevention committee.</p>
            <h3>Evaluation of Pollution Sources</h3>
            <p>We maintain a current drainage site map and topographic map of our facility.</p>
            <p>We have had no significant spills and leaks of toxic or hazardous materials at our facility.</p>
            <p><strong>{{ config('app.name') }}</strong> has no significant materials that have been treated, stored or
                disposed in a manner to allow exposure to stormwater.</p>
            <p>At our facility, the following activities have a high potential for contaminating stormwater: working
                with the removal and storage of gasoline, oils, antifreeze etc. the following pollutants of concern may
                be associated with these activities: oil and gasoline discharge in excess amounts</p>
            <p>The following is the method we use for the on-site storage or disposal of these materials: 55-gallon
                drums and larger quantities kept outside above storage drums.</p>
            <p>We use the following materials management practices to minimize contact of these materials with
                precipitation and stormwater runoff: utilizing built in traps and have them cleaned out and removed by
                authorized Haz-Mat companies</p>
            <p>Our facility has the following materials loading and access areas: parts department loading dock area</p>
            <p>To help reduce pollutants in stormwater runoff, we use the following existing structural and
                non-structural control measures: utilizing built in traps and have them cleaned out and removed by
                authorized Haz-Mat companies and to include regularly scheduled actions such as sweeping or
                inspections. </p>
            <p>These measures are located throughout the dealership.</p>
            <p>Our facility's stormwater does receive treatment. The following process is used: local city and or county
                water treatment centers</p>
            <p>The following are predictions of the direction of flow for the types of pollutants likely to be present
                for each area of the plant generating stormwater discharges associated with industrial activity:
                N/A </p>
            <p>The following types of pollutants are likely to be present for each area of the plant generating
                stormwater discharges associated with industrial activity: oils, gasoline and antifreeze. </p>
            <p>The following is a summary of our existing stormwater sampling data: there are no sampling measures at
                this time.</p>
            <h3>Primary Stormwater Practices and Elements</h3>
            <p>We use standard and accepted practices, including management, maintenance, training, and inspections, to
                reduce pollutants.</p>
            <h3>Maintaining the Plan</h3>
            <p><strong>{{ $sm }}</strong> is responsible for conducting periodic site evaluations.</p>
            <p><strong>{{ $sm }}</strong> is responsible for keeping records of all inspections and reports.</p>
            <p><strong>{{ $sm }}</strong> is responsible for updating the plan as needed.</p>
            <p>The following are the procedures for updating our plan: review annually with department supervisor </p>
            <h2>Special Requirements</h2>
            <p><strong>{{ $qi }}</strong> and or <strong>{{ $sm }}</strong> is responsible for incorporating into the
                plan any necessary changes resulting from major changes in a facility's design, construction, operation
                or maintenance.</p>
            <p><strong>{{ $sm }}</strong> is responsible for determining if the facility is subject to any special
                requirements.</p>
            <p><strong>{{ $sm }}</strong> is responsible for incorporating into the plan any applicable special
                requirements.</p>
            <h3>Appendix</h3>
            <p>We have attached lists, samples, or procedures to this plan that will help ensure better understanding of
                our written program.</p>
        </div>

        <div id="used-oil-management">
            <h2>Used Oil Management Plan</h2>
            <p>Properly managing used oil is important for four main reasons:</p>
            <ul>
                <li>To protect the environment.</li>
                <li>To protect human health.</li>
                <li>To protect against liability for environmental damages.</li>
                <li>To reuse, rather than waste, a valuable resource.</li>
            </ul>
            <p>Used oil, even when not classified as a hazardous waste under RCRA, can have harmful effects if it is
                released into the environment. In addition, people's health can be affected if used oil is handled
                improperly.</p>
            <p>Superfund regulations allow the federal government to hold any party that created or contributed to the
                creation of a hazardous waste site (including some used oil) financially responsible for cleanup
                costs.</p>
            <p>Used oil is a valuable resource because it has lubrication value and heat value. When treated to remove
                contaminants, the used oil can be used as a base stock to produce new lubricating oil. Because used oil
                has heat value, it can be burned as fuel. Properly burning the used oil keeps its heat value from being
                wasted and saves the virgin heating oil that would be burned instead.</p>
            <h3>Purpose</h3>
            <p>This plan provides one source of written documentation for used oil records for
                <strong>{{ config('app.name') }}</strong>. In addition, this plan will inform interested persons,
                including company and contractor employees, about this company's compliance with Environmental
                Protection Agency (EPA) requirements (found at 40 CFR 279) for used oil generators.</p>
            <p>This plan provides a written description of used oil management procedures, disposal methods, and
                transportation requirements. We encourage any suggestions that our employees have for improving our
                written plan for used oil management, as we are committed to developing and maintaining an effective
                protocol. We strive for clear understanding, environmentally sound practices, and involvement in the
                plan from every level of the company.</p>
            <h3>Administrative Duties</h3>
            <p>Service manager is responsible for developing the written used oil management plan; for ensuring that our
                written plan is complete, kept up to date, and made available to applicable or required authorities; and
                for maintaining used oil management records. A copy of our used oil management plan may be reviewed by
                employees. It is located in the service manager’s office.</p>
            <h3>Used Oil Defined</h3>
            <p>The EPA defines used oil as "any oil that has been refined from crude oil or any synthetic oil that has
                been used and as a result of such use is contaminated by physical or chemical impurities." Used oil can
                be generated during "do-it-yourself" projects, from automotive sources, or during industrial operations.
                This includes oils that are used as hydraulic fluid as well as oils that are used to lubricate
                automobiles and other machinery, cool engines, or suspend materials in industrial processes. Oils used
                for these purposes can become contaminated with physical materials (such as metal particles from engine
                wear) or chemical contaminants (such as gasoline combustion products, like toluene).</p>
            <h3>Used Oil Management</h3>
            <p>At this facility, we generate used oil from removal of oil from automobiles for oil change operations. It
                is likely to contain the following contaminants: metals and other engine related material</p>
            <p>This company adheres to the following practices. We:</p>
            <ul>
                <li>Never dump or dispose of used oil in the trash, in sewers, or on the ground.</li>
                <li>Make sure our collection and storage set-ups are leak proof, spill proof, and that tanks have lids
                    or are covered to prevent water from entering.
                </li>
                <li>Use lockable fills to prevent dumping of materials into the tank when it is not supervised.</li>
                <li>Maintain our collection containers regularly, comply with local fire and safety regulations, and
                    avoid leaks and spills.
                </li>
                <li> Label storage tanks "Used Oil."</li>
                <li>Clean up any used oil spills or leaks. This includes providing soak-up material (e.g., sawdust,
                    kitty litter, or a commercial product) for minor spills. It keeps the area clean and helps prevent
                    personal injury.
                </li>
                <li>Keep records of used oil sent to burners.</li>
            </ul>
            <p><i>Storing Used Oil</i></p>
            <ul>
                <li>Our facility stores used oil in 55-gallon drums and above storage tanks. This facility follows these
                    storage practices. We:
                </li>
                <li>Never mix used oil with any other material. This facility keeps gasoline, solvents, degreasers,
                    paints, and so on, from making the used oil a hazardous waste and increasing collection costs.
                </li>
                <li>Carefully record the amount of used oil placed into and removed from storage devices. Recordkeeping
                    plays an important role in leak detection for ASTs, USTs, and drums.
                </li>
                <li>Have constructed secondary containment around our drums/tanks with a capacity for 100 percent of the
                    contents of the drums we store; the base of the containment area is sloped so that any spilled oil
                    may be recollected and removed.
                </li>
                <li>Equip storage containers with wide-mouth, long-necked funnels to reduce spills during QUg.</li>
                <li>Equip storage containers with a pressure relief valve to reduce a buildup of pressure, which could
                    cause leaks.
                </li>
                <li>Keep absorbent materials such as kitty litter and sawdust to clean up any spills that occur.</li>
                <li>Keep the area near the storage devices neat and clean.</li>
            </ul>
            <p><i>Recycling Used Oil</i></p>
            <ul>
                <li>Recycling used oil cashes in on either its lubricating value or heat value. We use this method of
                    management whenever possible because it is easier to do and more cost effective than properly
                    disposing of used oil.
                </li>
                <li>At this facility, we recycle our used oil by having it hauled away by a state approved used oil
                    company method because we do not recycle it or use it for any other function on-site.
                </li>
            </ul>
            <p><i>Responding to Releases of Used Oil</i></p>
            <ul>
                <li>Even though all steps have been taken to prevent leaks or spills from occurring, this company is
                    also prepared to respond to spills of used oil. We instruct workers to use the following protocol to
                    manage spills of used oil and provide any necessary equipment:
                </li>
                <li> Stop the release. This action will vary depending on why the release is occurring. For example, if
                    the spill occurs because a 55-gallon drum has been knocked over, the drum should be righted to stop
                    more used oil from being released.
                </li>
                <li>If the spill occurs because a valve on a storage device has been left open, the valve should be
                    closed. If a leak is a result of a puncture in the tank or drum, rags or similar materials should be
                    used to plug the leak.
                </li>
                <li>Contain the release. We strive to prevent the used oil that has been released from spreading. For
                    example, a sorbent, such as kitty litter or sawdust, should be spread over the spilled used oil.
                </li>
                <li>Clean up the release. Depending on the extent of the release, cleaning up the used oil can be a
                    simple or a complicated task. For small spills on the ground, the soil can be dug up and disposed
                    of. (The soil must be tested to determine if it exhibits hazardous characteristics.) For larger
                    spills where puddles of used oil have formed, vacuum-type machinery can be used to collect the used
                    oil before the soil is dug up for disposal. Because releases that contaminate a great deal of soil
                    or ground or surface water are very difficult to clean up, this company contacts professionals to
                    conduct the cleanup operation.
                </li>
                <li>Properly manage the used oil that has been cleaned up. Any leaked or spilled used oil is managed
                    just like any other used oil under 40 CFR 279.
                </li>
                <li>Properly manage the solid materials generated during the cleanup. We place solid materials used to
                    clean up a spill of used oil in a sieve-like container to allow the used oil to drip from the solid
                    materials into a storage device. In addition, we compact the materials to remove the used oil.
                    (Removal is complete when there are no more signs of free-flowing oil.) Materials contaminated with
                    used oil that are burned can be managed in the same manner as used oil.
                </li>
                <li>Contaminated materials that will not be burned for energy are tested to determine if they exhibit
                    hazardous waste characteristics. If they do not test hazardous, they are disposed of in a RCRA
                    subtitle D facility. If they are hazardous, they are disposed of in a RCRA subtitle C facility.
                </li>
                <li>Remove the storage device from service and repair or replace it.</li>
            </ul>
            <p><i>Disposing of Used Oil</i></p>
            <ul>
                <li>Although recycling is the best management option for used oil, this company has discovered this
                    option is not feasible. Knowledge of how the used oil was generated or testing has revealed that our
                    used oil is contaminated with none. This used oil is generated in quantities too small to be
                    economically recycled. Therefore, we have chosen to properly dispose of our used oil.
                </li>
                <li>Because our used oil is contaminated with halogens in concentrations less than 1,000 ppm or not
                    considered a hazardous waste, we place the used oil in a landfill that accepts industrial wastes and
                    meets RCRA Subtitle D requirements.
                </li>
            </ul>
            <p><i>Managing and Disposing of Used Oil Filters</i></p>
            <ul>
                <li>Whenever this company changes the oil in a fleet vehicle, the oil filter is also changed to keep the
                    solid contaminants of the old oil from immediately contaminating the new oil. Used oil filters can
                    contain 10 to 16 ounces of used oil; therefore, proper management of this source of used oil is a
                    concern of this company. Used oil filters are not considered a hazardous waste under RCRA if they
                    are not terne-plated and have been properly drained of oil.
                </li>
                <li>When used oil filters are removed from a warm engine, this company uses the Gravity draining - when
                    the filter is removed from the engine, it should be placed with its gasket side down in a drain pan.
                    If the filter has an anti-drain valve, the "dome end" of the filter should be punctured with a
                    screwdriver (or similar device) so that the oil can flow freely. The filter should then be allowed
                    to drain for 12 to 24 hours.
                </li>
                <li>We store our drained used oil filters in a covered, rainproof container to prevent used oil from
                    being washed from the filters to the surrounding environment. Our used oil filters are then recycled
                    or properly disposed of.
                </li>
            </ul>
            <p><i>Shipping/Transporting Used Oil</i></p>
            <ul>
                <li>The used oil management standards define a used oil transporter as any person who transports used
                    oil, any person who collects used oil from more than one generator and transports the collected oil,
                    and owners and operators of used oil transfer facilities." <strong>{{ config('app.name') }}</strong>
                    utilizes a waste transport company for hauling our used oil and other products for proper disposal.
                    Our transporter has an EPA ID number and complies with all relevant used oil regulations, including
                    keeping tracking records of where the used oil is collected and where it will be transported to.
                </li>
            </ul>
            <p>When working with our transporter, we:</p>
            <ul>
                <li>Know that the hauler has an EPA ID number.</li>
                <li>Check our hauler's qualifications to make sure the hauler takes the oil to a reputable recycling
                    operation.
                </li>
                <li>Measure the level of oil in a tank before and after the hauler collects it to be certain the oil
                    collected matches the amount the hauler reports collecting.
                </li>
                <li>Make sure a company representative signs and dates the hauler's tracking sheet.</li>
                <li>Ask for a receipt from the transporter that states how much used oil was collected from our facility
                    and where the used oil will be taken. (These records are not required under the used oil management
                    standards, but may be useful should a problem arise.)
                </li>
                <li>Make sure that the hauler maintains storage tanks/containers; labels containers "Used Oil"; stores
                    used oil over oil-impervious surfaces; has secondary containment structures in place; stores used
                    oil for no more than 35 days; tests waste in out-of-service tanks; closes out-of-service tanks
                    containing hazardous waste according to EPA standards.
                </li>
            </ul>
            <h3>Employee Training</h3>
            <p>Although training is not strictly required under the regulations, we have designated a service manager to
                train personnel who will handle used oil. Direct any questions concerning used oil training to this
                person.</p>
            <p>Under this plan, employees are informed of used oil management procedures relevant to the positions in
                which they work. This training occurs both in the classroom and on the job.</p>
            <p>We keep records of job titles and written job descriptions for all positions related to used oil
                management and the names of employees QUg each job. We also keep records describing the type and amount
                of training provided.</p>
            <h3>Related Requirements</h3>
            <p>Related regulations that we must still comply with include:</p>
            <ul>
                <li>Spill Prevention Control and Countermeasures requirements (40 CFR 112) Please see related documents
                    for information on how this company meets these additional requirements.
                </li>
            </ul>
            <h3>Recordkeeping</h3>
            <p>Service manager is responsible for keeping the following records:</p>
            <p>Shipping manifest, used oil transport sheets</p>
            <h3>Maintaining the Plan</h3>
            <p>Service manager is responsible for:</p>
            <ul>
                <li>Conducting periodic site audits.</li>
                <li>Keeping records of all inspections and reports.</li>
                <li>Updating the plan as needed by incorporating any necessary changes resulting from major changes in
                    our facility's operation or maintenance.
                </li>
            </ul>
        </div>

        <div id="rpp">
            <h2>Respiratory Protection Plan</h2>
            <h3>Purpose</h3>
            <p>This respirator program lays out standard operating procedures to ensure the protection of all employees
                from respiratory hazards in accordance with the requirements of OSHA 29 CFR 1910.134.</p>
            <h3>Administrative Duties</h3>
            <p>At <strong>{{ config('app.name') }}</strong> our Respiratory Protection Program Administrator is body
                <strong>{{ $bsm }}</strong>.</p>
            <p>The body shop manager is also qualified by appropriate training and experience that is commensurate with
                the complexity of the program to administer or oversee our Respiratory Protection Program and conduct
                the required evaluations of program effectiveness.</p>
            <p>Employees may review a copy of our Respiratory Protection Program. It is located in the supervisor's
                office, <strong>{{ $bsm }}</strong>'s. Our Program Administrator, <strong>{{ $qi }}</strong>, reviews
                this program periodically to ensure its effectiveness.</p>
            <h3>Respirator Selection</h3>
            <p>Respirators are selected on the basis of respiratory hazards to which the worker is exposed and workplace
                and user factors that affect respirator performance and reliability. All selections are made by the body
                shop manager.</p>
            <p>The body shop manager will develop detailed written standard operating procedures governing the selection
                of respirators using the following guidelines: Select and provide respirators based on respiratory
                hazard(s) to which a worker is exposed and workplace and user factors that affect respirator performance
                and reliability.</p>
            <p>* Select a NIOSH-certified respirator. </p>
            <p>* Identify and evaluate the respiratory hazard(s) in the workplace, including a reasonable estimate of
                employee exposures to respiratory hazard(s) and an identification of the contaminant's chemical state
                and physical form. Consider the atmosphere to be IDLH,</p>
            <p><strong><i>Immediately Dangerous to Life and Health</i></strong>, if you cannot identify or reasonably
                estimate employee exposure.</p>
            <p>* Select respirators from a sufficient number of respirator models and sizes so that the respirator is
                acceptable to, and correctly fits, the user.</p>
            <p>When selecting respirators for IDLH atmospheres:</p>
            <p>* Provide these respirators: - A full facepiece pressure demand SCBA certified by NIOSH for a minimum
                service life of thirty minutes, or - A combination full facepiece pressure demand supplied-air
                respirator (SAR) with auxiliary self-contained air supply.</p>
            <p>* Provide respirators NIOSH-certified for escape from the atmosphere in which they will be used when they
                are used only for escape from IDLH atmospheres.</p>
            <p>* Consider all oxygen-deficient atmospheres to be IDLH. Exception: If you can demonstrate that, under all
                foreseeable conditions, the oxygen concentration can be maintained within the ranges specified in Table
                II of 29 CFR 1910.134 (i.e., for the altitudes set out in the table), then any atmosphere-supplying
                respirator may be used.</p>
            <p>When selecting respirators for atmospheres that are not IDLH:</p>
            <p>* Provide a respirator that is adequate to protect the health of the employee and ensure compliance with
                all other OSHA statutory and regulatory requirements, under routine and reasonably foreseeable emergency
                situations.</p>
            <p>* Select respirators appropriate for the chemical state and physical form of the contaminant.</p>
            <p>* For protection against gasses and vapors, provide:</p>
            <ul>
                <li>An atmosphere-supplying respirator, or</li>
                <li>An air-purifying respirator, provided that: (1) The respirator is equipped with an
                    end-of-service-life indicator (ESLI) certified by NIOSH for the contaminant; or (2) If there is no
                    ESLI appropriate for conditions in our workplace, implement a change schedule for canisters and
                    cartridges that is based on objective information or data that will ensure that canisters and
                    cartridges are changed before the end of their service life. Describe in the respirator program the
                    information and data relied upon and the basis for the canister and cartridge change schedule and
                    the basis for reliance on the data.
                </li>
            </ul>
            <p>* For protection against particulates, provide:</p>
            <ul>
                <li>An atmosphere-supplying respirator; or</li>
                <li>An air-purifying respirator equipped with a filter certified by NIOSH under 30 CFR part 11 as a high
                    efficiency particulate air (HEPA) filter, or an air-purifying respirator equipped with a filter
                    certified for particulates by NIOSH under 42 CFR 84, or
                </li>
                <li>For contaminants consisting primarily of particles with mass median aerodynamic diameters (MMAD) of
                    at least 2 micrometers, an air-purifying respirator equipped with any filter certified for
                    particulates by NIOSH.
                </li>
            </ul>
            <p>Respirators are selected according to 29 FR 1910.134(d).</p>
            <p>For information regarding the types of respirators in use at this facility and their uses, see the table
                in the full plan.</p>
            <h3>Medical Evaluations</h3>
            <p>At <strong>{{ config('app.name') }}</strong>, persons will not be assigned to tasks requiring use of
                respirators nor fit tested unless it has been determined that they are physically able to perform the
                work and use the respirator.</p>
            <p>Medical evaluations are provided according to the requirements of 29 CFR 1910.134(e).</p>
            <p>Employees may contact their supervisor for a copy of their confidential medical evaluation or
                questionnaire.</p>
            <h3>Fit Test Procedures</h3>
            <p><strong>{{ config('app.name') }}</strong> makes sure that employees are fit tested:</p>
            <ul>
                <li>before they are required to use a respirator,</li>
                <li>according to 29 CFR 1910.134(f), and</li>
                <li>with the same make, model, style, and size of respirator that will be used.</li>
            </ul>
            <p>Employees must pass one of the fit test types that follow the protocols and procedures contained in 29
                CFR 1910.134 Appendix A.</p>
            <p>Our workplace-specific fit testing procedures include the following:</p>
            <ol>
                <li>The test subject shall be allowed to pick the most acceptable respirator from a sufficient number of
                    respirator models and sizes so that the respirator is acceptable to, and correctly fits, the user.
                </li>
                <li>Prior to the selection process, the test subject shall be shown how to put on a respirator, how it
                    should be positioned on the face, how to set strap tension and how to determine an acceptable fit. A
                    mirror shall be available to assist the subject in evaluating the fit and positioning of the
                    respirator. This instruction may not constitute the subject's formal training on respirator use,
                    because it is only a review.
                </li>
                <li>The test subject shall be informed that he/she is being asked to select the respirator that provides
                    the most acceptable fit. Each respirator represents a different size and shape, and if fitted and
                    used properly, will provide adequate protection.
                </li>
                <li>The test subject shall be instructed to hold each chosen facepiece up to the face and eliminate
                    those that obviously do not give an acceptable fit.
                </li>
                <li>The more acceptable facepieces are noted in case the one selected proves unacceptable; the most
                    comfortable mask is donned and worn at least five minutes to assess comfort. Assistance in assessing
                    comfort can be given by discussing the points in the following item A.6. If the test subject is not
                    familiar with using a particular respirator, the test subject shall be directed to don the mask
                    several times and to adjust the straps each time to become adept at setting proper tension on the
                    straps.
                </li>
                <li>Assessment of comfort shall include a review of the following points with the test subject and
                    allowing the test subject adequate time to determine the comfort of the respirator:
                    <ul>
                        <li>(a) Position of the mask on the nose;</li>
                        <li>(b) Room for eye protection;</li>
                        <li>(c) Room to talk;</li>
                        <li>(d) Position of mask on face and cheeks.</li>
                    </ul>
                </li>
                <li>The following criteria shall be used to help determine the adequacy of the respirator fit:
                    <ul>
                        <li>(a) Chin properly placed;</li>
                        <li>(b) Adequate strap tension, not overly tightened;</li>
                        <li>(c) Fit across nose bridge;</li>
                        <li>(d) Respirator of proper size to span distance from nose to chin;</li>
                        <li>(e) Tendency of respirator to slip;</li>
                        <li>(f) Self-observation in mirror to evaluate fit and respirator position.</li>
                    </ul>
                </li>
                <li>The test subject shall conduct a user seal check, either the negative and positive pressure seal
                    checks described in Appendix B-1 of this section or those recommended by the respirator manufacturer
                    which provide equivalent protection to the procedures in Appendix B-1. Before conducting the
                    negative and positive pressure checks, the subject shall be told to seat the mask on the face by
                    moving the head from side-to-side and up and down slowly while taking in a few slow deep breaths.
                    Another facepiece shall be selected and retested if the test subject fails the user seal check
                    tests.
                </li>
                <li>The test shall not be conducted if there is any hair growth between the skin and the facepiece
                    sealing surface, such as stubble beard growth, beard, mustache or sideburns which cross the
                    respirator sealing surface. Any type of apparel which interferes with a satisfactory fit shall be
                    altered or removed.
                </li>
                <li>If a test subject exhibits difficulty in breathing during the tests, she or he shall be referred to
                    a physician or other licensed health care professional, as appropriate, to determine whether the
                    test subject can wear a respirator while performing her or his duties.
                </li>
                <li>If the employee finds the fit of the respirator unacceptable, the test subject shall be given the
                    opportunity to select a different respirator and to be retested.
                </li>
                <li>Exercise regimen. Prior to the commencement of the fit test, the test subject shall be given a
                    description of the fit test and the test subject's responsibilities during the test procedure. The
                    description of the process shall include a description of the test exercises that the subject will
                    be performing. The respirator to be tested shall be worn for at least 5 minutes before the start of
                    the fit test.
                </li>
                <li>The fit test shall be performed while the test subject is wearing any applicable safety equipment
                    that may be worn during actual respirator use which could interfere with respirator fit.
                </li>
                <li>Test Exercises. (a) The following test exercises are to be performed for all fit testing methods
                    prescribed in this appendix, except for the CNP method. A separate fit testing exercise regimen is
                    contained in the CNP protocol. The test subject shall perform exercises, in the test environment, in
                    the following manner:
                    <ul>
                        <li>(1) Normal breathing. In a normal standing position, without talking, the subject shall
                            breathe normally.
                        </li>
                        <li>(2) Deep breathing. In a normal standing position, the subject shall breathe slowly and
                            deeply, taking caution so as not to hyperventilate.
                        </li>
                        <li>(3) Turning head side to side. Standing in place, the subject shall slowly turn his/her head
                            from side to side between the extreme positions on each side. The head shall be held at each
                            extreme momentarily so the subject can inhale at each side.
                        </li>
                        <li>(4) Moving your head up and down. Standing in place, the subject shall slowly move his/her
                            head up and down. The subject shall be instructed to inhale in the up position (i.e., when
                            looking toward the ceiling).
                        </li>
                        <li>(5) Talking. The subject shall talk out loud slowly and loud enough so as to be heard
                            clearly by the test conductor. The subject can read from a prepared text such as the Rainbow
                            Passage, count backward from 100, or recite a memorized poem or song. Rainbow Passage When
                            the sunlight strikes raindrops in the air, they act like a prism and form a rainbow. The
                            rainbow is a division of white light into many beautiful colors. These take the shape of a
                            long
                            round arch, with its path high above, and its two ends apparently beyond the horizon. There
                            is,
                            according to legend, a boiling pot of gold at one end. People look, but no one ever finds
                            it.
                            When a man looks for something beyond reach, his friends say he is looking for the pot of
                            gold
                            at the end of the rainbow.
                        </li>
                        <li>(6) Grimace. The test subject shall grimace by smiling or frowning. (This applies only to
                            QNFT testing; it is not performed for QLFT.)
                        </li>
                        <li>(7) Bending over. The test subject shall bend at the waist as if he/she were to touch
                            his/her toes.
                            Jogging in place shall be substituted for this exercise in those test environments such as
                            shroud
                            type QNFT or QLFT units that do not permit bending over at the waist.
                        </li>
                        <li>(8) Normal breathing. Same as exercise (1).</li>
                        <li>(b) Each test exercise shall be performed for one minute except for the grimace exercise
                            which
                            shall be performed for 15 seconds. The test subject shall be questioned by the test
                            conductor
                            regarding the comfort of the respirator upon completion of the protocol. If it has become
                            unacceptable, another model of respirator shall be tried. The respirator shall not be
                            adjusted
                            once the fit test exercises begin. Any adjustment voids the test, and the fit test must be
                            repeated. B.
                        </li>
                    </ul>
                </li>
            </ol>
            <p>Qualitative Fit Test (QLFT) Protocols</p>
            <h3>Proper Use Procedures</h3>
            <p>Once the respirator has been properly selected and fitted, its protection efficiency must be maintained
                for proper use according to 29 CFR 1910.134(g). Our company ensures with written procedures that
                respirators are used properly in the workplace. Our proper respirator use procedures are:</p>
            <p>CHECKLIST TO ENSURE PROPER RESPIRATOR USAGE BASED ON OSHA 29 CFR 1910.134(g): </p>
            <p>Facepiece Seal Protection</p>
            <p>* Do not permit respirators with tight-fitting facepieces to be worn by employees who have:</p>
            <ul>
                <li>Facial hair that comes between the sealing surface of the facepiece and the face or that interferes
                    with valve function; or
                </li>
                <li>Any condition that interferes with the face-to-facepiece seal or valve function.</li>
            </ul>
            <p>* If an employee wears corrective glasses or goggles or other personal protective equipment, ensure that
                such equipment is worn in a manner that does not interfere with the seal of the facepiece to the face of
                the user.</p>
            <p>* For all tight-fitting respirators, ensure that employees perform a user seal check each time they put
                on the respirator using the procedures in 29 CFR 1910.134 Appendix B-1 (User Seal Check Procedures) or
                procedures recommended by the respirator manufacturer that you can demonstrate are as effective as those
                in Appendix B-1.</p>
            <p>Continuing Respirator Effectiveness</p>
            <p>* Appropriate surveillance must be maintained of work area conditions and degree of employee exposure or
                stress. When there is a change in work area conditions or degree of employee exposure or stress that may
                affect respirator effectiveness, reevaluate the continued effectiveness of the respirator.</p>
            <p>* Ensure that employees leave the respirator use area:</p>
            <ul>
                <li>To wash their faces and respirator facepieces as necessary to prevent eye or skin irritation
                    associated with respirator use; or - If they detect vapor or gas breakthrough, changes in breathing
                    resistance, or leakage of the facepiece; or
                </li>
                <li>To replace the respirator or the filter, cartridge, or canister elements.</li>
                <li>If the employee detects vapor or gas breakthrough, changes in breathing resistance, or leakage of
                    the facepiece, replace or repair the respirator before allowing the employee to return to the work
                    area.
                </li>
            </ul>
            <p>Procedures for IDLH Atmospheres Ensure that:</p>
            <p>* One employee or, when needed, more than one employee is located outside the IDLH atmosphere; </p>
            <p>* Visual, voice, or signal line communication is maintained between the employee(s) in the IDLH
                atmosphere and the employee(s) located outside the IDLH atmosphere;</p>
            <p>* The employee(s) located outside the IDLH atmosphere are trained and equipped to provide effective
                emergency rescue;</p>
            <p>* The employer or designee is notified before the employee(s) located outside the IDLH atmosphere enter
                the IDLH atmosphere to provide emergency rescue;</p>
            <p>* The employer or designee authorized to do so by the company, once notified, provides necessary
                assistance appropriate to the situation; </p>
            <p>* Employee(s) located outside the IDLH atmospheres are equipped with:</p>
            <ul>
                <li>Pressure demand or other positive pressure SCBAs, or a pressure demand or other positive pressure
                    supplied-air respirator with auxiliary SCBA; and either:
                </li>
                <li>Appropriate retrieval equipment for removing the employee(s) who enter(s) these hazardous
                    atmospheres where retrieval equipment would contribute to the rescue of the employee(s) and would
                    not increase the overall risk resulting from entry; or
                </li>
                <li>Equivalent means for rescue where retrieval equipment is not required under the bullet item above
                    this one.
                </li>
            </ul>
            <p>Procedures for Interior Structural Firefighting</p>
            <p>In addition to the requirements set forth in the row above for Procedures for IDLH Atmospheres, in
                interior structural fires, ensure that:</p>
            <p>* At least two employees enter the IDLH atmosphere and remain in visual or voice contact with one another
                at all times;</p>
            <p>* At least two employees are located outside the IDLH atmosphere</p>
            <h3>Maintenance and Care Procedures</h3>
            <p>Our company provides each respirator user with a respirator that is clean, sanitary, and in good working
                order, according to the requirements in 29 CFR 1910.134(h)(1). We have created the following cleaning
                schedule(s) to be used for each respirator: Respirator issued for the exclusive use of an employee must
                be cleaned and disinfected as often as necessary to be maintained in a sanitary condition.</p>
            <p>* Respirators issued to more than one employee must be cleaned and disinfected before being worn by
                different individuals.</p>
            <p>* Respirators maintained for emergency use must be cleaned and disinfected after each use.</p>
            <p>* Respirators used in fit testing and training must be cleaned and disinfected after each use.</p>
            <p>We ensure that respirators are stored according to 29 CFR 1910.134(h)(2). They are packed or stored in
                employees’ lockers to prevent deformation of the facepiece and exhalation valve.</p>
            <p>We inspect respirators according to the requirements in 29 CFR 1910.134(h)(3). We have created the
                following inspection schedule(s) to be used for each respirator: All types of respirators used in
                routine situations must be inspected before each use and during cleaning.</p>
            <p>* Respirators maintained for use in emergency situations must be inspected at least monthly and in
                accordance with the manufacturer's recommendations, and checked for proper function before and after
                each use.</p>
            <p>* Emergency escape-only respirators must be inspected before being carried into the workplace for
                use.</p>
            <p>See the attached respirator inspection records.</p>
            <p>Respirators that fail an inspection or are otherwise found to be defective are removed from service and
                are discarded or repaired or adjusted according to the procedures in 29 CFR 1910.134(h)(4).</p>
            <p>We use the following discarding procedures: they are discarded immediately.</p>
            <h3>Air Quality Procedures</h3>
            <p>The following detailed procedures ensure adequate air quality, quantity, and flow of breathing air for
                atmosphere-supplying respirators and include coverage of the OSHA requirements for breathing air quality
                and use in 29 CFR 1910.134(I): N/A.</p>
            <h3>Training</h3>
            <p>Employee training is an important part of the respiratory protection program and is essential for correct
                respirator use. Our training program is provided by assigned outside vendors and
                <strong>{{ config('app.name') }}</strong> according to 29 CFR 1910.134(k).</p>
            <p>See attached training curriculum/materials.</p>
            <h3>Program Evaluation</h3>
            <p>At <strong>{{ config('app.name') }}</strong>, program evaluation is performed annually by our body shop
                manager according to 29 CFR 1910.134(l).</p>
            <h3>Appendices</h3>
            <p>The following documents are attached to this Respiratory Protection Program: none</p>
        </div>

        <div id="bloodborne-pathogens">
            <h2>Bloodborne Pathogens Plan</h2>
            <h3>Purpose</h3>
            <p>Our exposure control plan (ECP) is provided to eliminate or minimize occupational exposure to bloodborne
                pathogens in accordance with OSHA standard 29 CFR 1910.1030, "Occupational Exposure to Bloodborne
                Pathogens."</p>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $qi }}</strong>, is responsible for the implementation of the ECP and is responsible for
                maintaining, reviewing, and updating the ECP at least annually. <strong>{{ $qi }}</strong> is
                responsible for maintaining and providing all necessary equipment and supplies and also responsible for
                ensuring that all medical actions are performed and for maintaining appropriate records.
                <strong>{{ $qi }}</strong> is responsible for training and allowing ECP access for appropriate
                personnel.</p>
            <h3>Methods of Implementation and Control</h3>
            <p>The plan indicates job classifications in which some employees at our establishment have occupational
                exposure. Universal Precautions All employees utilize universal precautions</p>
            <p><i>Exposure Control Plan </i></p>
            <p>Covered employees receive an explanation of this ECP during their initial training, and annually.
                Employees may review this plan at any time during their work shifts by contacting
                <strong>{{ $qi }}</strong>. The plan indicates which devices have been identified as candidates for our
                use. <strong>{{ $qi }}</strong> solicits input from non-managerial employees responsible for direct
                patient care in the identification, evaluation, and selection of effective engineering and work practice
                controls. <strong>{{ $qi }}</strong> documents all solicitation in the ECP and indicates the engineering
                and work practice controls identified during solicitation in our annual reviews.</p>
            <p><i>Engineering and Work Practice Controls</i></p>
            <p>The plan indicates which specific engineering controls and work practice controls are used. The controls
                include how sharps disposal containers are maintained. The plan also indicates how we identify the need
                for changes in engineering control and work practices, and evaluates the need for new procedures or new
                products. <strong>{{ $qi }}</strong> is responsible for the effective implementation controls
                recommendations.</p>
            <p><i>Personal Protective Equipment (PPE)</i></p>
            <p>PPE is provided to our employees at no cost to them. <strong>{{ $qi }}</strong> provides appropriate PPE
                training.</p>
            <p><i>Housekeeping</i></p>
            <p>Our plan indicates the steps taken to effectively contain regulated wastes, including sharps, during
                handling.</p>
            <p><i>Labels</i></p>
            <p>The plan indicates which labeling method(s) is used in this facility. <strong>{{ $sm }}</strong>, ensures
                that proper, effective labeling is used. The local health department and
                <strong>{{ config('app.name') }}</strong> provides training to employees on hepatitis B vaccinations,
                addressing the safety, benefits, efficacy, methods of administration, and availability. Personal
                physician provides vaccinations at the physicians’ location.</p>
            <h3>Hepatitis B Vaccination Post-exposure and Evaluation</h3>
            <p>Should an exposure incident occur, employees are to contact <strong>{{ $qi }}</strong>. We provide
                immediate, confidential medical evaluation and follow-up after initial first aid.</p>
            <p><i>Administration of Post-Exposure Evaluation and Follow-up</i></p>
            <p><strong>{{ $qi }}</strong> ensures that the responsible health care professional(s) is given a copy of
                OSHA's bloodborne pathogens standard, and <strong>{{ $qi }}</strong> provides the employee with a copy
                of the evaluating health care professional's written opinion.</p>
            <p><i>Procedures for Evaluating the Circumstances Surrounding an Exposure Incident</i></p>
            <p><strong>{{ $qi }}</strong> reviews the circumstances of all exposure incidents. If necessary,
                <strong>{{ $qi }}</strong> ensures that appropriate revisions are made to this ECP.</p>
            <h3>Employee Training</h3>
            <p><strong>{{ $qi }}</strong> conducts training for employees who have occupational exposure to bloodborne
                pathogens. The plan indicates what topics are covered in the training, and where training materials.</p>
            <h3>Recordkeeping</h3>
            <p><i>Training Records</i></p>
            <p>Training records are kept for at least three years at <strong>{{ $qi }}</strong> office location. The
                plan describes which training records are included.</p>
            <p><i>Medical Records</i></p>
            <p><strong>{{ $qi }}</strong> is responsible for maintaining the required medical records. These records are
                kept in the human resource office for at least the duration of employment plus 30 years.</p>
            <p><i>OSHA Recordkeeping</i></p>
            <p>If an exposure incident occurs, it is evaluated, and <strong>{{ $qi }}</strong> determines if the case
                meets OSHA's Recordkeeping Requirements.</p>
        </div>

        <div id="ppe">
            <h2>Personal Protective Equipment</h2>
            <h3>Purpose</h3>
            <p>The purpose of this Personal Protective Equipment (PPE) Program is to document the hazard assessment,
                protective measures in place, and PPE in use at this company.</p>
            <p>While OSHA's Personal Protective Equipment regulation, found at 29 CFR 1910.132-.140 (Subpart I), does
                not explicitly require a written Personal Protective Equipment (PPE) Program,
                <strong>{{ config('app.name') }}</strong> has developed a written PPE program to document and specify
                all information relative to our PPE needs.</p>
            <p>The <strong>{{ $sm }}</strong>, is the program coordinator, acting as the representative of the plant
                manager, who has overall responsibility for the program. The service manager will designate appropriate
                dealership supervisors to assist in training employees and monitoring their use of PPE. This written
                plan is kept in service department office will review and update the program as necessary. Copies of
                this program may be obtained from the service manager’s office.</p>
            <h3>Hazard Assessment</h3>
            <p>In order to assess the need for PPE, the Safety Manager, with other appropriate managers’ and employees
                will help:</p>
            <ul>
                <li>identifies job classifications where exposures occur or could occur, and</li>
                <li>conducts a walk-through survey of workplace areas where hazards exist or may exist to identify
                    sources of hazards to employees.
                </li>
            </ul>
            <p>During the walk-through survey the Safety Manager observes and records the hazards along with PPE
                currently in use (type and purpose). The Safety Manager organizes the data and information for use in
                the assessment of hazards to analyze the hazards and enable proper selection of protective
                equipment.</p>
            <p>The Safety Manager documents the hazard assessment according to 29 CFR 1910.132(d)(2).</p>
            <h3>Selection Guidelines</h3>
            <p>Once any hazards have been identified and evaluated through hazard assessment, protective equipment is
                chosen according to the selection guidelines in Appendix B to Subpart I of 29 CFR 1910.</p>
            <p>It is the responsibility of the Safety Manager to reassess the workplace hazard situation as necessary,
                to identify and evaluate new equipment and processes, to review accident records, and reevaluate the
                suitability of previously selected PPE. This reassessment will take place as needed, but at least every
                quarter during inspection of the facility and work environment.</p>
            <h3>Employee Training</h3>
            <p>The Safety Manager/supervisor provides training, according to 29 CFR 1910.132(f), for each employee who
                is required to use personal protective equipment.</p>
            <p>Because failure to comply with company policy concerning PPE can result in OSHA citations and fines as
                well as employee injury, an employee who does not comply with this program will be disciplined for
                noncompliance according to the following schedule: employee will be subject to disciplinary action up to
                and including termination as determined by the shop foreman and service manager.</p>
            <h3>Cleaning and Maintenance</h3>
            <p>PPE is to be inspected, cleaned, and maintained by employees at regular intervals as part of their normal
                job duties so that the PPE provides the requisite protection.</p>
            <p>Supervisors are responsible for ensuring compliance with cleaning responsibilities by employees.</p>
            <h3>PPE Specific Information</h3>
            <p>Employees in the following designated work areas are required to wear goggles/face shields:</p>
            <p><span class="italic underline">Eye Protection</span> - Work Area: service bay areas and parts department.
            </p>
            <p><span class="italic underline">Safety Shields / Goggles</span> - Work Area Hazard: grinding, welding
                flash, chemical splash, high temperature, splash from molten metal’s, hammering, metal fragments.</p>
            <p>Type of goggles/face shield: covered goggles, direct ventilation, face shields, welding helmets.</p>
            <p>Employees from temporary work agencies and contractors are required to wear goggles/face shields if
                assigned to work in the designated work areas.</p>
            <h3>PPE Specific Information</h3>
            <p><i>Foot Protection Safety Shoes</i></p>
            <p>Employees in the following designated work areas are required to wear OSHA approved safety shoes:</p>
            <p>Work area: service technicians and parts department employees.</p>
            <p>Hazard: falling objects from cars and shelves in the parts department</p>
            <p>Type of safety shoe: Rubber heeled boots with Nitrile or Neoprene boots soles to protect against slipping
                on wet or oily floors. Also protects against chemical exposure. Also will have steel-toed shoes to
                protect against falling objects.</p>
            <p>Employees from temporary work agencies and contractors are required to wear safety shoes if assigned to
                work in the designated work areas.</p>
            <p>Members of the Emergency Response Team are required to wear safety footwear when responding to fire
                emergency situations.</p>
            <p>All employees who work in designated work areas and/or job assignments are responsible for purchasing and
                wearing safety shoes to comply with this policy. Purchase of shoes is done by Employees needing to
                purchase their own safety shoes through a local merchant as a condition of employment.</p>
            <h3>PPE Specific Information</h3>
            <p><i>Hand Protection Gloves</i></p>
            <p>Employees in the following designated work areas are required to wear protective gloves:</p>
            <p>Work area: service technicians and parts department employees.</p>
            <p>Hazard: working in and around car repair, moving boxes and other parts around in the parts department,
                utilizing gloves for welding.</p>
            <p>Type of glove: gloves will be used and assessed based on the type of job function being employed. Safety
                suppliers can help examine the attributes of the various types of gloves and advise accordingly.</p>
            <p>Employees from temporary work agencies and contractors are required to wear protective gloves if
                Employees in the following designated work areas are required to wear protective gloves:</p>
            <p>Work area: service technicians and parts department employees. </p>
            <p>Hazard: working in and around car repair, moving boxes and other parts around in the parts department,
                utilizing gloves for welding. </p>
            <p>Type of glove: gloves will be used and assessed based on type of job function being employed. Safety
                suppliers can help examine the attributes of the various types of gloves and advise accordingly.</p>
            <p>Employees from temporary work agencies and contractors are required to wear protective gloves if assigned
                to work in the designated work areas.</p>
            <h3>PPE Specific Information</h3>
            <p><i>Head Protection – Hard Hats</i></p>
            <p>Employees in the following designated work areas are required to wear hard hats:</p>
            <p>Work area: service technicians and parts department employees. </p>
            <p>Hazard: hair from oil, grease, water, dirt and sparks protect the head from hot exhaust systems, hot oil,
                sharp protruding objects and falling pipes, mufflers or other vehicle parts. They easily adapt for the
                wearing of eye goggles and safety glasses. Parts department employees can have parts and equipment fall
                off storage shelves when removing or storing such items.</p>
            <p>Type of hard hat: bump caps which will protect the employees from the items mentioned above.</p>
            <p>Employees from temporary work agencies and contractors are required to wear hard hats if assigned to work
                in the designated work areas.</p>
        </div>

        <div id="compressed-gas">
            <h2>Compressed Gas Plan</h2>
            <h3>Purpose</h3>
            <p>It is the policy of <strong>{{ config('app.name') }}</strong> to permit only trained and authorized
                employees to handle, store,
                use, and inspect compressed gases and equipment at any time.</p>
            <h3>Administrative Duties</h3>
            <p>The service manager is responsible for developing and maintaining this written Compressed
                Gas Plan. This written Compressed Gas Plan is kept on the dealership’s compliance
                dashboard.</p>
            <h3>List of Compressed Gases and Equipment</h3>
            <p>The compressed gases used at this company include the following: acetylene, oxygen,
                compressed air, propane, helium, propane, butane.</p>
            <p>The compressed gas equipment used at this company includes the following: compressed gas
                cylinders, portable tanks, standing tanks.</p>
            <h3>Inspection Procedures</h3>
            <p>The service manager and licensed compressed gas dealers are responsible for determining if
                compressed gas cylinders at the company are in a safe condition to the extent that can be
                determined by visual inspection. Inspections of cylinders are conducted according to the
                following schedule: quarterly.</p>
            <p><span class="italic underline">Handling Procedures</span>- We follow the safe handling procedures found
                in the CGA pamphlet
                series, including the P-1-1991 pamphlet.</p>
            <p><span class="italic underline">Storage Procedures</span> - We follow the safe storage procedures found in
                the CGA pamphlet series,
                including the P-1-1991 pamphlet.</p>
            <p><span class="italic underline">Usage Procedures</span> - We follow the safe storage procedures found in
                the CGA pamphlet series,
                including the P-1-1991 pamphlet.</p>
            <h3>Training Program</h3>
            <p>The service manager is responsible for training personnel who will handle, store, or use a
                compressed gas. The service and parts manager will be responsible for identifying employees
                and arranging with department management to schedule the instruction.</p>
            <h3>Recordkeeping</h3>
            <p>The service manager is responsible for maintaining records of cylinder inspections and
                maintenance. These records are kept in the service manager’s office.</p>
            <p>The service manager is responsible for maintaining records of individuals trained and certified
                for handling, storage, and use of compressed gases and equipment. These records are also
                kept in the service manager’s office.</p>
            <h3>Program</h3>
            <p>The service manager is responsible for evaluating and updating this written plan, and
                conducting periodic reviews to determine the effectiveness of the program.</p>
        </div>

        <div id="welding-and-cutting">
            <h2>Welding &amp; Cutting Procedures</h2>
            <h3>Purpose</h3>
            <p>To establish guidelines for employees who work with welding and cutting equipment at this
                company. Also, to establish uniform requirements designed to ensure that welding and cutting
                safety training, operation, and maintenance practices are communicated to and understood by
                the affected employees.</p>
            <h3>Administrative Duties</h3>
            <p>The service manager is responsible for developing and maintaining the written Welding &amp;
                Cutting Procedures. These procedures are kept at the following location: shop foreman&#39;s office.</p>
            <h3>Welding and Cutting Equipment</h3>
            <p>Our company uses welding and cutting equipment according to the table in the full plan.</p>
            <h3>Training</h3>
            <p>It is the policy of <strong>{{ config('app.name') }}</strong> to permit only trained and authorized
                personnel to operate
                welding and cutting equipment. The service manager will identify all new employees in the
                employee orientation program and make arrangements with department management to
                schedule training. The following person(s) will conduct initial training and evaluation:
                <strong>{{ $sm }}</strong>.</p>
            <h3>Operating Proceeds</h3>
            <p>We have created a set of operating procedures for all employees who work with welding and
                cutting equipment at this company.</p>
            <h3>Inspections</h3>
            <p>Following is a list of possible inspection items to be aware of before welding or cutting:</p>
            <ul>
                <li>Are only authorized and trained personnel permitted to use welding, cutting or brazing
                    equipment? 29 CFR 1910.252(a)(2)(xiii)(C)
                </li>
                <li>Does each operator have a copy of the appropriate operating instructions and are they
                    directed to follow them? 29 CFR 1910.253(a)(4), (d)(6), (f)(7)(A)
                </li>
                <li>Are pressure-reducing regulators used only for the gas and pressures for which they are
                    intended? 29 CFR 1910.253(e)(6)(i)
                </li>
                <li>Is grounding of the machine frame and safety ground connections of portable machines
                    checked periodically? 29 CFR 1910.254(d)(3); 255(b)(9), (c)(6)
                </li>
                <li>Are only approved apparatus (torches, regulators, pressure-reducing valves, acetylene
                    generators, manifolds) used? 29 CFR 1910.253(a)(3)
                </li>
                <li>Is a check made for adequate ventilation in and where welding or cutting is performed?
                    29 CFR 1910.252(c)(1)(iii), (2)(i)
                </li>
                <li>When working in confined places, are environmental monitoring tests taken and means
                    provided for quick removal of welders in case of an emergency? 29 CFR 1910.252(c)(4)
                </li>
            </ul>
            <p>WELDING EQUIPMENT</p>
            <ul>
                <li>Is necessary personal protective equipment available? 29 CFR 1910.252(b)(2)</li>
                <li>Are only approved apparatus (torches, regulators, pressure-reducing valves, acetylene
                    generators, manifolds) used? 29 CFR 1910.253(a)(3)
                </li>
                <li>Is open circuit (No Load) voltage of arc welding and cutting machines as low as possible
                    and not in excess of the recommended limits? 29 CFR 1910.254(b)(3)(i)-(iv)
                </li>
                <li>Is grounding of the welding machine frame and safety ground connections of portable
                    machines checked periodically? 29 CFR 1910.254(d)(3); .255(b)(9), (c)(6)
                </li>
            </ul>
            <p>EQUIPMENT MARKINGS</p>
            <ul>
                <li>Is red used to identify acetylene (and other fuel-gas) hose, green for oxygen hose, and
                    black for inert gas and air hose? 29 CFR 1910.253(e)(5)(i)
                </li>
                <li>Are empty compressed gas cylinders appropriately marked and their valves closed? 29
                    CFR 1910.101(b); .253(b)(1)(ii), (2)(iii), (5)(ii)(H)
                </li>
            </ul>
            <p>COMPRESSED GAS CYLINDER MANAGEMENT</p>
            <ul>
                <li>Are compressed gas cylinders regularly examined for obvious signs of defects, deep
                    rusting, or leakage? 29 CFR 1910.254(d)(4); 255(e)
                </li>
                <li>Is care used in handling and storage of cylinders, safety valves, relief valves, etc., to
                    prevent damage? 29 CFR 1910.253 (b)(2)(ii), (5)(iii)(B)
                </li>
                <li>Are liquefied gases stored and shipped valve-end up with valve covers in place? 29 CFR
                    1910.253(b)(5)(iii)(A)
                </li>
                <li>Before a regulator is removed, is the valve closed and gas released
                    from the regulator? 29 CFR 1910.253(b)(5)(iii)(D)
                </li>
                <li>Are cylinders, cylinder valves, couplings, regulators, hoses, and apparatus kept free of
                    oily or greasy substances? 29 CFR 1910.253(b)(5)(i)
                </li>
                <li>Are the cylinders kept away from elevators, stairs, or gangways? 29 CFR
                    1910.253(b)(2)(ii)
                </li>
                <li>Is it prohibited to use cylinders as rollers or supports? 29 CFR 1910.253(b)(5)(ii)(K)</li>
                <li>Is care taken not to drop or strike cylinders? 29 CFR 1910.253(b)(5)(ii)(B)</li>
                <li>Unless secured on special trucks, are regulators removed and valve-protection caps put
                    in place before moving cylinders? 29 CFR 1910.253(b)(5)(ii)(D)
                </li>
                <li>Do cylinders without fixed hand wheels have keys, handles, or non-adjustable wrenches
                    on stem valves when in service? 29 CFR 1910.253(b)(5)(ii)(E)
                </li>
                <li>Are empty compressed gas cylinders appropriately marked and their valves closed? 29
                    CFR 1910.253(b)(1)(ii), (2)(iii), (5)(ii)(H)
                </li>
                <li>Are fuel gas cylinders and oxygen cylinders separated by distance, fire resistant barriers,
                    etc., while in storage? 29 CFR 1910.253(b)(4)(iii)
                </li>
            </ul>
            <p>PERSONAL PROTECTIVE EQUIPMENT</p>
            <ul>
                <li>Are all employees required to use personal protective equipment (PPE) as needed? 29
                    CFR 1910.132(a)
                </li>
                <li>Is PPE functional and in good repair? Does it have ANSI or ASTM specifications marked
                    on it? 29 CFR 1910.132(e)
                </li>
                <li>Are employees exposed to the hazards created by welding, cutting, or brazing operations
                    protected with personal protective equipment and clothing? 29 CFR 1910.252(b)(3)
                </li>
                <li>Is personal protective equipment provided and are all employees required to use PPE as
                    needed to protect against eye and face injury? 29 CFR 1910.132(a); .133(a)(1)
                </li>
                <li>Are protective goggles or face shields provided and worn where there is any danger of
                    flying particles or corrosive materials? 29 CFR 1910.133(a)(1)
                </li>
                <li>Are approved safety glasses required to be worn at all times in areas where there is a
                    risk of eye injuries such as punctures, abrasions, contusions, or burns? 29 CFR 1910.133(a)(2)
                </li>
                <li>Are appropriate safety glasses, face shields, etc., used while using hand tools or
                    equipment which might produce flying materials or be subject to breakage? 29 CFR
                    1910.133(a)(1)
                </li>
                <li>Are employees who need corrective lenses (glasses or contacts) in working
                    environments having harmful exposures required to wear only approved safety glasses,
                    protective goggles, or use other medically approved precautionary procedures? 29 CFR
                    1910.133(a)(3)
                </li>
                <li>Is appropriate foot protection required where there is the risk of foot injury? 29 CFR
                    1910.132(a); .136(a)
                </li>
                <li>Is appropriate hand protection required where there is the risk of hand injury? 29 CFR
                    1910.132(a); .138(a)
                </li>
                <li>Are hard hats provided and worn where danger of falling objects exists? 29 CFR
                    1910.135(a)(1)
                </li>
                <li>Are hard hats inspected periodically for damage to the shell and suspension system? 29
                    CFR 1910.135(b)
                </li>
                <li>If welding creates hazardous air emissions, is the welding area appropriately marked to
                    indicate this? 29 CFR 1910.252(c)(iv)(A)-(C)
                </li>
                <li>If welding creates hazardous air emissions, have ventilation or local exhaust systems
                    been provided to keep fumes below the maximum allowable concentrations? 29 CFR
                    1910.252(c)(iii)
                </li>
            </ul>
            <p>FIRE PREVENTION</p>
            <ul>
                <li>Are precautions taken to prevent the mixture of air or oxygen with flammable gases,
                    except at a burner or in a standard torch? 29 CFR 1910.253(a)(1)
                </li>
                <li>Are signs reading DANGER NO SMOKING, MATCHES, OR OPEN LIGHTS or the
                    equivalent, posted in welding areas?
                </li>
                <li>Are provisions made to never crack a fuel-gas cylinder valve near sources of ignition? 29
                    CFR 1910.253(b)(5)(iii)(C)
                </li>
                <li>When welding is done on metal walls, are precautions taken to protect combustibles on
                    the other side? 29 CFR 1910.252(a)(2)(x)
                </li>
                <li>Before hot work is begun, are used drums, barrels, tanks, and other containers so
                    thoroughly cleaned that no substances remain that could explode, ignite, or produce toxic
                    vapors? 29 CFR 1910.252(a)(3)(i)
                </li>
                <li>If welding gases are stored, are oxygen and acetylene separated by a 5-foot
                    noncombustible barrier? 29 CFR 1910.253(b)(4)(i)-(iii)
                </li>
                <li>Are compressed gas cylinders kept away from sources of heat? 29 CFR
                    1910.253(b)(2)(i)
                </li>
                <li>Is combustible scrap, debris, and waste stored safely and removed from the work site
                    promptly? 29 CFR 1910.252 (a)(2)(i), (vii), (xiv)(C)(2)
                </li>
                <li>Are fire watchers assigned when welding or cutting is performed in locations where a
                    serious fire might develop? 29 CFR 1910.252(a)(2)(iii)(A)
                </li>
                <li>Are provisions made for personnel to perform fire watch duties under appropriate
                    circumstances? 29 CFR 1910.252(d)(4)(iv)
                </li>
            </ul>
            <p>FIRE ALARM SYSTEMS</p>
            <ul>
                <li>If you have a non-supervised fire alarm system, is it tested bimonthly? 29 CFR
                    1910.165(d)(2)
                </li>
                <li>If you have a supervised employee alarm system (that is, does the alarm have a device
                    that indicates system malfunction), is it tested yearly? 29 CFR 1910.165(d)(4)
                </li>
            </ul>
            <p>PORTABLE FIRE EXTINGUISHERS</p>
            <ul>
                <li>Are appropriate fire extinguishers mounted, located, and identified so that they are
                    readily accessible to employees? 29 CFR 1910.157(c)(1)
                </li>
                <li>Are all fire extinguishers inspected and recharged regularly, and noted on the inspection
                    tag? 29 CFR 1910.157(e)
                </li>
                <li>Are portable fire extinguishers provided in adequate number and type? 29 CFR
                    1910.157(d)
                </li>
            </ul>
            <p>AISLES</p>
            <ul>
                <li>Are aisles marked? 29 CFR 1910.22(b)(2)</li>
                <li>Are aisle widths maintained? 29 CFR 1910.22(b)(1)</li>
                <li>Are aisles in good condition? 29 CFR 1910.22(b)(1)</li>
                <li>Are aisles and passageways properly illuminated? 29 CFR 1910.22</li>
                <li>Are aisles kept clean and free of obstructions? 29 CFR 1910.22(b)(1)</li>
            </ul>
            <h3>Maintenance</h3>
            <p><strong>{{ $pm }}</strong>, <strong>titlex3</strong> complete(s) a receiving or delivery inspection
                whenever our company
                purchases welding and cutting equipment.
                The service and parts manager follow(s) the manufacturer’s operator instruction manual for
                daily or weekly maintenance.</p>
            <h3>Signs and Labels</h3>
            <p>Our company posts signs as follows: 29 CFR 1910.252 General requirements for welding,
                cutting, and brazing--- (b)(2)(ii)(G) Lenses shall bear some permanent distinctive marking by
                which the source and shade may be readily identified.</p>
            <p>(b)(4)(vii) Warning sign. After welding operations are completed, the welder shall mark the hot
                metal or provide some other means of warning other workers.</p>
            <p>(c)(1)(iv) Precautionary labels. A number of potentially hazardous materials are employed in fluxes,
                coatings, coverings, and filler metals used in welding and cutting or are released to the
                atmosphere during welding and cutting. These include but are not limited to the materials
                itemized in paragraphs (c)(5) through (c)(12) of this section. The suppliers of welding materials
                shall determine the hazard, if any, associated with the use of their materials in welding, cutting,
                etc.</p>
            <p>(c)(1)(iv)(A) All filler metals and fusible granular materials shall carry the following notice, as a
                minimum, on tags, boxes, or other containers:</p>
            <p>CAUTION</p>
            <p>Welding may produce fumes and gases hazardous to health. Avoid breathing these fumes and
                gases. Use adequate ventilation. See ANSI Z49.1-1967 Safety in Welding and Cutting
                published by the American Welding Society.</p>
            <p>We use the following labels: Low-Pressure Manifold</p>
            <p>Do Not Connect High-pressure Cylinder</p>
            <p>Maximum Pressure--250 psig (1.7 MPa)</p>
            <p>(d)(4)(ii) Aboveground piping systems shall be marked in accordance with the American
                National Standard Scheme for the Identification of Piping systems, ANSI A13.1-1956, which is
                incorporated by reference as specified in 29 CFR 1910.6. 06-01-96</p>
            <p>(d)(4)(iii) Station outlets shall be marked to indicate the name of the gas.</p>
            <p>(e)(6)(iii) Gages on oxygen regulators shall be marked USE NO OIL.</p>
            <h3>Recordkeeping</h3>
            <p><strong>{{ $sm }}</strong>, <strong>titlex2</strong> is responsible for maintaining the following
                records: any service or
                maintenance records. These records are maintained in shop foreman&#39;s office for 3 years.</p>
            <h3>Appendix A</h3>
            <p>Company-specific hazards of our welding and cutting equipment and our workplace are shown
                in the table in the full plan.</p>
            <h3>Appendix B</h3>
            <p>We have attached the following documents to these written Welding and Cutting Procedures:
                Possible attachments include, but are not limited to:</p>
            <ul>
                <li>List of welding and cutting equipment;</li>
                <li>Outside training company information and training material;</li>
                <li>In-house training material/curriculum;</li>
                <li>List of employees trained in welding and cutting;</li>
                <li>Welding and cutting inspection checklist;</li>
                <li>The manufacturer’s operator instruction manual(s) for each piece of welding or cutting
                    equipment;
                </li>
                <li>Various ANSI, API, ASTM, AWS, CGA, NEMA, NFPA standards as applicable;</li>
                <li>Various related OSHA, DOT, and NIOSH regulations as applicable;</li>
                <li>Related plans (i.e., confined space, personal protective equipment, fire prevention, emergency
                    action, electrical safety, toxic and hazardous substances, hazard communication, etc.); and
                </li>
                <li>Hot work permit forms</li>
            </ul>
        </div>

        <div id="fpp">
            <h2>Fire Prevention Plan</h2>
            <h3>Purpose</h3>
            <p>OSHA&#39;s Fire Prevention Plan regulation, found at 29 CFR 1910.38(b), requires
                <strong>{{ config('app.name') }}</strong>, to
                have a written fire prevention plan (FPP). This plan applies to all operations in our company
                where employees may encounter a fire.</p>
            <p>This Fire Prevention Plan (FPP) is in place at this company to control and reduce the possibility
                of fire and to specify the type of equipment to use in case of fire. This plan addresses the
                following issues:</p>
            <ul>
                <li>Major workplace fire hazards and their proper handling and storage procedures.</li>
                <li>Potential ignition sources for fires and their control procedures.</li>
                <li>The type of fire protection equipment or systems which can control a fire involving them.</li>
                <li>Regular job titles of personnel responsible for maintenance of equipment and systems
                    installed to prevent or control ignition of fires and for control of fuel source hazards.
                </li>
            </ul>
            <p>Under this plan, our employees will be informed of the plan&#39;s purpose, preferred means of
                reporting fires and other emergencies, types of evacuations to be used in various emergency
                situations, and the alarm system. The plan is closely tied to our Emergency Action Plan where
                procedures are described for emergency escape procedures and route assignments,
                procedures to account for all employees after emergency evacuation has been completed, and
                rescue and medical duties for those employees who perform them. Please see the Emergency
                Action Plan for this information.</p>
            <p><strong>{{ $qi }}</strong>, is the Plan Coordinator, acting as the representative of the Facility
                Manager, who has overall responsibility for the plan. The written plan is kept in Qualified
                Individual’s office and or online compliance dashboard. <strong>{{ $qi }}</strong>, will review and
                update the plan as necessary. Copies of this plan may be obtained online in the dealership’s
                compliance dashboard.</p>
            <p>The FPP communicates to employees, policies and procedures to follow when fires erupt. This
                written plan is available, upon request, to employees, their designated representatives, and any
                OSHA officials who ask to see it.</p>
            <p>If after reading this plan, you find that improvements can be made, please contact the Plan
                Coordinator, <strong>{{ $qi }}</strong>. We encourage all suggestions because we are committed
                to the success of our Fire Prevention Plan. We strive for clear understanding, safe behavior, and
                involvement in the plan from every level of the company.</p>
            <h3>Plan Coordinator Responsibilities</h3>
            <p>Here at <strong>{{ config('app.name') }}</strong>, the Plan Coordinator, <strong>{{ $qi }}</strong>, or
                designee, is responsible
                for the following activities. He or she must:</p>
            <ol>
                <li>Develop a written Fire Prevention Plan for regular and after-hours work conditions.</li>
                <li>Immediately notify the Fire Department, police departments, and the building
                    owner/superintendent in the event of a fire affecting the facility.
                </li>
                <li>Integrate the FPP with the existing general emergency plan covering the building
                    occupied.
                </li>
                <li>Distribute procedures for reporting a fire, the location of fire exits, and evacuation routes
                    to each employee.
                </li>
                <li>Conduct drills to acquaint the employees with fire procedures, and to judge their
                    effectiveness.
                </li>
                <li>Satisfy all local fire codes and regulations as specified.</li>
                <li>Train designated employees in the use of fire extinguishers and the application of
                    medical first-aid techniques.
                </li>
                <li>Keep key management personnel home telephone numbers in a safe place in the facility
                    for immediate use in the event of a fire. Distribute a copy of the list to key persons to be
                    retained in their homes for use in communicating a fire occurring during non-work hours.
                </li>
                <li>Decide to have employees and non-employees remain in or evacuate the facility in the
                    event of a fire.
                </li>
                <li>If evacuation is deemed necessary, the Plan Coordinator ensures that:
                    <ul>
                        <li>All employees are notified and evacuated and a head count is taken to confirm total
                            evacuation of all employees.
                        </li>
                        <li>When practical, equipment is placed and locked in storage rooms or desks for
                            protection.
                        </li>
                        <li>The building owner/superintendent is contacted, informed of the action taken, and asked
                            to assist in coordinating security protection.
                        </li>
                        <li>In locations where the building owner/superintendent is not available, security measures
                            to protect employee records and property are arranged as necessary.
                        </li>
                    </ul>
                </li>
            </ol>
            <p>In addition, the Plan Coordinator is responsible for duties unique to this facility. Storage of used
                oil drums outside of service department, storage of cars and truck on site, extra ordinary amount
                of gasoline on site due automobiles stored on site.</p>
            <h3>Fire Hazards</h3>
            <p>Fire can be represented by a simple equation: Fire = Ignition Source + Fuel + Oxygen. Without
                any one of these three elements, a fire cannot start. Likewise, during a fire, if you take away any
                one of these three elements, you can successfully put out a fire. It is our company&#39;s intent to
                prevent these three elements from reacting to produce a fire.</p>
            <p>Common industrial fuel sources include flammable and combustible liquids and gases and
                reactive metals, as well as paper, cardboard, rubbish, and oily rags which can spontaneously
                combust. You may want to check your material safety data sheets for flammable and
                combustible or reactive chemicals in your facility.</p>
            <p>Fire prevention measures have been developed for all fire hazards found. These include:</p>
            <p>Employees are to transfer flammable liquids to approved containers and watch for spills. Oil-
                soaked rags must be treated differently than general paper trash in office areas and disposed of
                in proper steel can receptacles to prevent from being ignited.</p>
            <p>Fuel is used throughout the facility as an energy source for various systems or equipment. This
                fuel can be a significant fire hazard and must be monitored and controlled.</p>
            <p>The service and parts manager along with, <strong>{{ $qi }}</strong>, will be responsible for the
                overall state of facility and the reduction of fuel hazards in all areas of the facility and be
                responsible for oversight of housekeeping duties that reduce and control fuel source hazards
                such as accumulation of flammable and combustible materials like trash, oily rags, or any other
                fire hazards. Your parts manager will be responsible for control of fuel source hazards in the
                loading dock area and be responsible for control of fuel source hazards in the distribution area.</p>
            <p><i>Potential Ignition Sources</i></p>
            <p>Flammable or combustible materials and other fuel sources may not ignite on their own without
                an external source of ignition. The following procedures are used to control known ignition
                sources at this company: electrical, heating, and welding/cutting equipment; open flames;
                sparks; smoking; hot surfaces like boilers and furnaces; hot substances like molten metal;
                sparks and static; friction; and bombs and arson. Other ignition sources include lightning, static,
                spontaneous ignition, heat-producing chemical reactions, and radiant heat.</p>
            <h3>Fire Protection Equipment</h3>
            <p>Fire protection equipment, selected and purchased by service managerx, in use at this
                company includes the following extinguishers:</p>
            <p>The National Fire Protection Association (NFPA) has classified fires into four types:</p>
            <ul>
                <li>Class A—This common fire involves ordinary materials like wood, paper, rubber, and plastics.
                    The extinguishing agent is water or dry chemicals.
                </li>
                <li>Class B—Flammable liquids, gases, and greases make up this class, and the extinguishing
                    agent is carbon dioxide or dry chemicals.
                </li>
                <li>Class C—This is an electrical fire. Carbon dioxide or dry chemicals extinguish this fire.</li>
                <li>Class D—This fire is caused by combustible metals. Special techniques rather than fire
                    extinguishers put this fire out.
                </li>
            </ul>
            <p><strong><i>At this location the use of ABC class fire extinguishers are utilized along with class
                        A</i></strong></p>
            <p>In addition, Portable fire suppression equipment including standpipe and hose systems;</p>
            <ul>
                <li>Fixed fire suppression equipment including automatic sprinkler systems and fixed
                    extinguishing systems;
                </li>
                <li>Fire detection systems; and</li>
                <li>Employee alarm systems are also present to control fires. Fire protection equipment and
                    systems are indicated on the building floor plan in the appendix.
                </li>
            </ul>
            <h3>Maintenance of Fire Protection Equipment</h3>
            <p>Once hazards are evaluated and equipment is installed to control them, the equipment must be
                inspected on a regular basis to make sure it continues to function properly. The following
                personnel are responsible for maintaining equipment and systems installed to prevent or control
                fires: <strong>{{ $sm }}</strong>.</p>
            <p>Our guidelines for maintaining the equipment are as follows:</p>
            <p>All fire equipment is checked and certified annually through out dealership.</p>
            <h3>Housekeeping Procedures</h3>
            <p>Our company controls accumulations of flammable and combustible waste materials and
                residues so that they do not contribute to a fire. We have identified the following potential
                hazards in our facility:</p>
            <p>Electrical fire from equipment and cords, equipment motor burn outs etc.</p>
            <p>The following procedures have been developed to eliminate or minimize the risk of fire due to
                improperly stored or disposed of materials.</p>
            <p>Keeping the floors free of paper or saw dust, storing oily rags in specially designed containers,
                storing all flammables in fire cabinets when not in use, etc.</p>
            <h3>Training</h3>
            <p><i>Fire Prevention Plan</i></p>
            <p>At the time of a fire, employees should know what type of evacuation is necessary and what
                their role is in carrying out the plan. In cases where the fire is large, total and immediate
                evacuation of all employees is necessary. In smaller fires, a partial evacuation of nonessential
                employees with a delayed evacuation of others may be necessary for continued operation. We
                must be sure that employees know what is expected of them during a fire to assure their safety.</p>
            <p>Training, conducted on initial assignment, includes:</p>
            <ul>
                <li>What to do if employee discovers a fire</li>
                <li>Demonstration of alarm, if more than one type exists</li>
                <li>How to recognize fire exits</li>
                <li>Evacuation routes</li>
                <li>Assisting employees with disabilities</li>
                <li>Measures to contain fire (e.g., closing office doors, windows, etc. in immediate vicinity)</li>
                <li>Head count procedures (see EAP for details)</li>
                <li>Return to building after the &quot;all-clear&quot; signal</li>
            </ul>
            <p>Specific training topics might include, but is not limited to:</p>
            <ul>
                <li>Employee roles and responsibilities,</li>
                <li>Fire threats, hazards, and protective actions,</li>
                <li>What to do if employee discovers a fire,</li>
                <li>Notification, warning, and communication procedures,</li>
                <li>Demonstration of alarm, if more than one type exists,</li>
                <li>How to recognize fire exits,</li>
                <li>Evacuation routes,</li>
                <li>Assisting employees with disabilities and non-employees,</li>
                <li>Measures to contain fire (e.g., closing office doors, windows, etc. in immediate vicinity),</li>
                <li>Head count procedures (see EAP for details),</li>
                <li>Emergency shutdown procedures,</li>
                <li>Return to building after the &quot;all-clear&quot; signal,</li>
            </ul>
            <p>Any employee who does not comply with this plan will be disciplined.</p>
            <p><i>Fire Protection Equipment</i></p>
            <p>The Plan Coordinator provides training for each employee who is required to use fire protection
                equipment. Employees shall not use fire protection equipment without appropriate training.
                Training, before an individual is assigned responsibility to fight a fire, includes:</p>
            <ul>
                <li>Types of fires</li>
                <li>Types of fire prevention equipment</li>
                <li>Location of fire prevention equipment</li>
                <li>How to use fire prevention equipment</li>
                <li>Limitations of fire prevention equipment</li>
                <li>Proper care and maintenance of assigned fire prevention equipment and</li>
                <li>Training might include, but is not limited to:
                    <ul>
                        <li>Types of fires,</li>
                        <li>Types of fire protection equipment,</li>
                        <li>Location of fire protection equipment,</li>
                        <li>How to use fire protection equipment,</li>
                        <li>Limitations of fire protection equipment,</li>
                        <li>Proper care and maintenance of assigned fire protection equipment, and</li>
                        <li>Other topics i.e., fire extinguisher training activation etc.</li>
                    </ul>
                </li>
            </ul>
            <p>Employees must demonstrate an understanding of the training and the ability to use the
                equipment properly before they are allowed to perform work requiring the use of the equipment.</p>
            <p>If the Plan Coordinator has reason to believe an employee does not have the understanding or
                skill required, the employee must be retrained and ensures that the employee has received and
                understands the fire protection equipment training</p>
            <h3>Appendix</h3>
            <p>We have attached the following documents to this plan to ensure better understanding of our
                written plan: Floor plans</p>
        </div>

        <div id="machine-equipment">
            <h2>Machine Equipment Safety/Guarding</h2>
            <h3>Purpose</h3>
            <p>It is the policy of this company to permit only trained and authorized employees to operate
                machinery, tools, or equipment at any time. This policy is applicable to:</p>
            <ul>
                <li>Daily operators of machinery, tools, and equipment; and</li>
                <li>Those who only occasionally have cause to use machinery, tools, or equipment.</li>
            </ul>
            <p>This written Machine/Equipment Safety and Guarding Plan describes methods and practices for
                care and use of machines, equipment, and tools that can be read and understood by all
                managers, supervisors, and employees at dealershipx. This written plan is intended to be used
                to:</p>
            <ul>
                <li>Create an awareness of the hazards among our workforce,</li>
                <li>Standardize procedures for use and care of the equipment,</li>
                <li>Provide a consistent format for training employees on the proper procedures to be used,</li>
                <li>Minimize the possibility of injury or harm to our employees, and</li>
                <li>Demonstrate <strong>{{ config('app.name') }}&#39;s</strong> compliance with machine safety and
                    equipment usage
                    requirements for general industry in Subpart O and P of 29 CFR 1910.
                </li>
            </ul>
            <h3>Administrative Duties</h3>
            <p><strong>{{ $sm }}</strong>, our company&#39;s <strong>titlex2</strong>, is responsible for developing and
                maintaining this
                written Machine/Equipment Safety and Guarding Plan. This person is solely responsible for all
                facets of the plan and has full authority to make necessary decisions to ensure the success of
                this plan. The service manager is also qualified, by appropriate training and experience that is
                commensurate with the complexity of the plan, to administer or oversee our machine/equipment
                safety program and conduct the required evaluations.</p>
            <p>This written Machine/Equipment Safety and Guarding Plan is kept at the following location:
                Dealerships online compliance dashboard.</p>
            <p>If, after reading this plan, you find that improvements can be made, please contact your
                immediate supervisor. We encourage all suggestions because we are committed to creating a
                safe workplace for all our employees and a safe and effective machine/equipment safety and
                guarding program is an important component of our overall safety plan. We strive for clear
                understanding, safe work practices, and involvement in the program from every level of the
                company.</p>
            <h3>List of Machinery, Tools, and Equipment</h3>
            <p>The machinery, tools, and equipment used at this company includes the following:</p>
            <div class="grid grid-cols-2">
                <p class="mr-6">
                    <strong class="block">Department</strong>
                    Service Department
                </p>
                <p>
                    <strong class="block">Machinery, Tools, or Equipment Present</strong>
                    pliers, hammers, screwdrivers, drills, presses, wrenches, tire mounting
                    machines, hydraulic lifts, sheer presses, pipe benders, brake lathes, engine
                    fans, air compressors, motor or engine drive belts, and forklifts.</p>
            </div>
            <h3>Pre-Operational Procedures</h3>
            <p>Hand tools must be inspected prior to use to ensure that:</p>
            <ul>
                <li>For tools with jaws, jaws are not sprung to the point of slippage.</li>
                <li>For impact tools, they are free of mushroom heads.</li>
                <li>For tools with wooden handles, the handles are free of splinters or cracks and are tight
                    in the tool.
                </li>
                <li>The tool is otherwise safe for use.</li>
            </ul>
            <p>Any machine or power-operated tool, function, or process which may cause injury will be
                guarded. All permanent guards are securely attached in good working order and all removable
                guards are in place on the machine or equipment before starting use. Guards meet these
                minimum general requirements:</p>
            <ul>
                <li>Prevent contact - The guards prevent hands, arms, or any part of an employee&#39;s body or
                    clothing from making contact with dangerous moving parts.
                </li>
                <li>Secure - Guards are not easy to remove or alter. Guards and safety devices are made of
                    durable material that will withstand the conditions of normal use. They are firmly secured
                    to the machine.
                </li>
                <li>Protect from falling objects - The guards ensure that no objects can fall into moving
                    parts.
                </li>
                <li>Create no new hazards - If a guard creates a hazard of its own such as shear point, a
                    jagged edge, or an unfinished surface which can cause a laceration, then employees
                    must not use the piece of machinery or equipment.
                </li>
            </ul>
            <p>If a guard is defective, damaged, or in any way does not meet the requirements of these
                procedures, employees may not use the machine, and must immediately notify your direct
                supervisor</p>
            <p>Where the operation of a machine or accidental contact with it can injure employees in the
                vicinity, the hazard is either controlled or eliminated.</p>
            <p>Employees must locate and put on necessary and appropriate personal protective equipment
                (PPE) for use with the machinery or equipment before beginning use. PPE can be obtained
                from the service manager’s or designated supervisor’s office.</p>
            <p>Employees must make sure that work areas are well-lit, dry, and clean before beginning work.
                Sawdust, paper and oily rags are a fire hazard and can damage machinery and equipment.</p>
            <p>Employees must change clothing and take off jewelry that could become entangled in the
                machinery or equipment they are to use.</p>
            <p>Only qualified personnel may install or repair equipment. Employees must notify management if
                machinery or equipment is in need of any type of repair.</p>
            <p>If a lock or tag is in place on a piece of machinery or equipment, it may not be removed and the
                machinery or equipment may not be used.</p>
            <h3>Operating Procedures</h3>
            <p>Employees may not remove a guard for any reason while operating any piece of machinery or
                equipment.</p>
            <p>All necessary personal protective equipment (PPE) is worn while the machinery or equipment is
                running.</p>
            <p>If an employee is distracted or unable to focus on the work with the machinery or equipment,
                they must stop work with that machinery or equipment.</p>
            <p>Upon finishing with a piece of equipment, tool, or machine, basic maintenance must be
                performed. It should be kept sharp, oiled, and stored properly, as appropriate.</p>
            <p>Problem equipment must be immediately reported to immediate supervisor so it can be repaired
                or replaced.</p>
            <p>Employees must always use the proper piece of machinery or equipment for the job.</p>
            <p>Electric cables and cords are kept clean and free from kinks. Equipment may never be carried
                by its cord.</p>
            <h3>Training Program</h3>
            <p>Under no circumstances will an employee operate a piece of machinery or equipment until
                he/she has successfully completed this company&#39;s machinery and equipment training program.
                This includes all new operators or users of machinery and equipment, regardless of claimed
                previous experience.</p>
            <p>The company training program includes classroom instruction and operational training on each
                specific piece of machinery and equipment to be utilized by the employee in the assigned work
                area.</p>
            <p>The following individuals receive training: All fixed operations employees/service technicians’
                will receive training regarding their work space area and any other equipment that is needed to
                perform their job functions.</p>
            <p><strong>{{ $qi }}</strong> will identify all new employees in the employee Orientation Program and
                make arrangements with department management to schedule the classroom instruction for
                those employees previously identified in this section as needing training.</p>
            <p>Classroom training consists of:</p>
            <ul>
                <li>Review of these written procedures by employee.</li>
                <li>Review general safety training utilizing dealerships web base training solutions.</li>
                <li>Successful completion of examination.</li>
            </ul>
            <p>Operational training consists of:</p>
            <ul>
                <li>Pre-operational procedures.</li>
                <li>Basic maintenance for machinery and equipment.</li>
                <li>Operational review of each piece of machinery, tool, or equipment the employee is
                    expected to operate.
                </li>
            </ul>
            <p>Department management is responsible for scheduling the employee with the Department
                Operations Trainer to complete the operational training program after successful completion of
                the classroom training or re-training segment.</p>
            <h3>New Equipment Start-up Inspection Procedures</h3>
            <p>The procedures in this section are required at the following times:</p>
            <ul>
                <li>During and after the installation of new equipment,</li>
                <li>During and after the rearrangement of existing equipment into a new layout, and</li>
                <li>During the relocation of existing equipment.</li>
            </ul>
            <p>While work is in progress on installation of new equipment, the following departments, in charge
                of specific expertise, must be involved from the beginning to the end of the installation process:
                Service and Parts departments</p>
            <p>Corrections that need implementation during the installation should be done as needed.</p>
            <p>Before operation of the equipment in the workplace, all specialty departments must signify that
                the equipment meets all expectations in their area of concern.</p>
            <p><strong>{{ $sm }}</strong>, and assigned supervisors are accountable for all phases of installation and
                for making sure equipment is safe and efficient to run before letting employees operate it.</p>
            <p>Once service manager and assigned supervisors has verified completion, the equipment can be
                put into service.</p>
            <h3>Inspections</h3>
            <p>Machinery, tools, and equipment will be inspected regularly to ensure safety and serviceability.
                Management Supervisors and all service technicians working with the machinery inspects all
                machinery, equipment, cords and accessories according to the following schedule: Quarterly.</p>
            <h3>Recordkeeping</h3>
            <p>Management is responsible for maintaining records of inspections of machinery, tools, and
                equipment. These records are kept in Service Manager’s office.</p>
            <p>Service, parts and body shop managers’ will maintain records in employee safety files of
                individuals trained and certified for machinery and equipment.</p>
            <h3>Program Evaluation</h3>
            <p>Although we may not be able to eliminate all problems, we try to eliminate as many as possible
                to improve employee protection and encourage employee safe practices. Therefore,
                <strong>{{ $sm }}</strong>, is responsible for evaluating and updating this written plan. The evaluation
                will
                include a review of reported accidents, as well as near misses, to identify areas where
                additional safety measures need to be taken.</p>
            <p>The service manager will also conduct a periodic review to determine the effectiveness of the
                program. This review may include:</p>
            <ul>
                <li>A walk-through of the facility, and</li>
                <li>Interviews with employees to determine whether they are familiar with the requirements
                    of this program and if safety measures are being practiced.
                </li>
            </ul>
        </div>
    </div>
</div>
