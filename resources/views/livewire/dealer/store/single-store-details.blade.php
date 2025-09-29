<div>
    <div class="mt-5 space-y-6 md:mt-0">
        <form wire:submit.prevent="update" x-data>
            <div class="py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">General</label>
                    </div>
                    <div class="col-span-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Dealership Name')"/>
                            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name')"
                                          required autofocus/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                        <div>
                            <x-input-label for="address" :value="__('Address')"/>
                            <x-text-input wire:model.defer="address" id="address" class="block mt-1 w-full" type="text"
                                          address="address"
                                          :value="old('address')"
                                          required autofocus/>
                            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="city" :value="__('City')"/>
                                <x-text-input wire:model.defer="city" id="city" class="block mt-1 w-full" type="text"
                                              :value="old('city')"
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                            </div>
                            <div>
                                <x-input-label for="state" :value="__('State')"/>
                                <x-text-input wire:model.defer="state" id="state" class="block mt-1 w-full" type="text"
                                              :value="old('state')"
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('state')" class="mt-2"/>
                            </div>
                            <div>
                                <x-input-label for="postal_code" :value="__('Zip Code')"/>
                                <x-text-input wire:model.defer="postal_code" id="postal_code" class="block mt-1 w-full"
                                              type="text"
                                              :value="old('postal_code')"
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')"/>
                                <x-text-input wire:model.defer="phone" id="phone" class="block mt-1 w-full" type="text"
                                              x-mask="999-999-9999"
                                              :value="old('phone')"
                                              required autofocus/>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('Website URL')"/>
                                <x-text-input wire:model.defer="website" id="website" class="block mt-1 w-full" type="text"
                                              :value="old('website')"
                                              autofocus/>
                                <x-input-error :messages="$errors->get('website')" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">Logo</label>
                    </div>
                    <div class="col-span-6" x-data="{photoName: null, photoPreview: null}">
                        <x-media-library-collection
                            multiple max-items="1"
                            rules="mimes:png,jpeg"
                            name="logo"
                            :model="$store"
                            collection="logo"
                        />
                    </div>
                </div>
            </div>
            @can('create-dealerships')
                <div class="border-t py-6">
                    <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                        <div class="col-span-2">
                            <label class="sm:mt-2.5 inline-block text-sm text-gray-500">SOC Monitoring</label>
                        </div>
                        <div class="col-span-6">
                            <div class="flex items-start mb-6">
                                <div class="flex items-center h-5">
                                    <input wire:model="active_monitoring"
                                           id="custom-checkbox"
                                           type="checkbox" class="hidden peer">
                                    <label for="custom-checkbox"
                                           class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-arm-blue-500 peer-checked:[&_.custom-checkbox]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded custom-checkbox text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                        <span>Active</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="flex">
                                    <x-input-label for="monitoring_start_date" :value="__('Start Date')"/>
                                    @if($active_monitoring)
                                        <span class="text-sm text-red-600">*</span>
                                    @endif
                                </div>
                                <x-text-input
                                    wire:model.defer="monitoring_start_date"
                                    id="monitoring_start_date"
                                    class="block mt-1 w-full"
                                    type="date"
                                    name="monitoring_start_date"
                                />
                                <x-input-error :messages="$errors->get('monitoring_start_date')" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @role('super-admin')
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">Phishing Simulations</label>
                    </div>
                    <div class="col-span-6">
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input wire:model="phishing_active"
                                       id="phishing-sim"
                                       type="checkbox" class="hidden peer">
                                <label for="phishing-sim"
                                       class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.phishing-sim]:border-arm-blue-500 peer-checked:[&_.phishing-sim]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded phishing-sim text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                    <span>Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div class="w-full">
                                <x-input-label for="phishing_token" :value="__('Token')"/>
                                <x-text-input wire:model.defer="phishing_token" id="phishing_token" class="block mt-1 w-full" type="text"
                                              :value="old('phishing_token')"
                                              autofocus/>
                                <x-input-error :messages="$errors->get('phishing_token')" class="mt-2"/>
                            </div>
                            <div class="w-full">
                                <x-input-label for="phishing_ip" :value="__('IP Address')"/>
                                <x-text-input wire:model.defer="phishing_ip" id="phishing_ip" class="block mt-1 w-full" type="text"
                                              :value="old('phishing_ip')"
                                              autofocus/>
                                <x-input-error :messages="$errors->get('phishing_ip')" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">Course Notifications</label>
                    </div>
                    <div class="col-span-6">
                        <div class="flex items-center mt-2.5">
                            <input wire:model="notifications"
                                   id="notifications"
                                   type="checkbox" class="hidden peer">
                            <label for="notifications"
                                   class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.notifications]:border-arm-blue-500 peer-checked:[&_.notifications]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded notifications text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                <span>Active</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">Video Training</label>
                    </div>
                    <div class="col-span-6">
                        <div class="flex items-center mt-2.5">
                            <input wire:model="videos" id="videos" type="checkbox" class="hidden peer">
                            <label for="videos" class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.videos]:border-arm-blue-500 peer-checked:[&_.videos]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                <span
                                    class="flex items-center justify-center w-5 h-5 border-2 rounded videos text-neutral-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="3"
                                         stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                  </svg>
                                </span>
                                <span>Active</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 inline-block text-sm text-gray-500">Remediations</label>
                    </div>
                    <div class="col-span-6">
                        <div class="flex items-center mt-2.5">
                            <input wire:model="remediations"
                                   id="remediations"
                                   type="checkbox" class="hidden peer">
                            <label for="remediations"
                                   class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.remediations]:border-arm-blue-500 peer-checked:[&_.remediations]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded remediations text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                <span>Active</span>
                            </label>
                        </div>
                        @if($remediations)
                            <div>
                                <div class="flex items-center mt-2.5">
                                    <input wire:model="remediationNotifications"
                                           id="remediationNotifications"
                                           type="checkbox" class="hidden peer">
                                    <label for="remediationNotifications"
                                           class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.remediationNotifications]:border-arm-blue-500 peer-checked:[&_.remediationNotifications]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded remediationNotifications text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                        <span>Enable Notifications</span>
                                    </label>
                                </div>
                                @if($remediationNotifications)
                                    <select wire:model.defer="frequency" class="py-1.5 px-3 pe-9 mt-2.5 block w-full border-gray-200 rounded-lg text-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                        <option value="" selected>Select the notification frequency</option>
                                        @foreach(\App\Enums\Frequency::cases() as $frequency)
                                            <option value="{{ $frequency->value }}">{{ $frequency->label() }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('frequency')" class="mt-2"/>
                                @endif
                            </div>
                            @if($remediationNotifications)
                            @if (!empty($selectedRemediationReminderUsers))
                                <div class="mt-6">
                                    <p class="mt-1 text-sm text-gray-600">The following employees are configured to receive reminders based on audit types. When the audit has been completed, the employee will receive a notification. The employee will then receive two more notifications based on the frequency selected if all violations have not been remediated. </p>

                                    <div class="mt-4 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-3">
                                            @foreach ($selectedRemediationReminderUsers as $auditType => $users)
                                                <div>
                                                    <h4 class="text-md font-medium text-gray-800">{{ Str::title(str_replace('_', ' ', $auditType)) }}</h4>
                                                    @if (count($users) > 0)
                                                        <ul class="mt-2 text-sm text-gray-700 space-y-1">
                                                            @foreach ($users as $user)
                                                                <li>
                                                                    <a href="{{ route('dealer.employees.show', $user['slug']) }}" class="text-arm-blue-600 hover:text-arm-blue-500">{{ $user['name'] }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-2 text-sm text-gray-500">No employees selected for this audit type.</p>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-6">
                                    <p class="mt-1 text-sm text-gray-600">No employees are currently configured to receive remediation reminders.</p>
                                </div>
                            @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @can('create-dealerships')
            <div class="border-t py-6">
                <div class="grid grid-cols-12 gap-y-1.5 gap-x-6">
                    <div class="col-span-2">
                        <label class="sm:mt-2.5 flex items-center text-sm text-gray-500">
                            Reset Courses
                            <x-tooltip content="This will reset all courses for all employees." class="size-4 text-gray-400 hover:text-gray-600 ml-1" />
                        </label>
                    </div>
                    <div class="col-span-6">
                        <livewire:dealer.course.reset :store="$store" />
                    </div>
                </div>
            </div>
            @endcan
            <div class="py-3 text-right">
                <x-primary-button wire:loading.attr="disabled">Update</x-primary-button>
            </div>
        </form>
    </div>
</div>
