<div class="bg-white sm:p-6 border-t">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Compliance Info</h3>
            <p class="my-5 text-sm text-gray-500">This information will be displayed publicly so be careful what
                you share.</p>
<x-primary-button wire:click.prevent="download">
                Download form
                <svg wire:loading class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </x-primary-button>
            @if(!$store->user_submitted)
            <livewire:dealer.settings.send-compliance-email-link :store="$store"/>
            @endif
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0" x-data="{ show: true }">
            <form wire:submit.prevent="update" class="space-y-5">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="pep" :value="__('Police Emergency Phone Number')"/>
                        <x-text-input wire:model.defer="pep" id="pep" class="block mt-1 w-full" type="text" name="pep"
                                      :value="old('pep')"
                                      x-mask="999-999-9999"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('pep')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="pnep" :value="__('Police Non-Emergency Phone Number')"/>
                        <x-text-input x-mask="999-999-9999" wire:model.defer="pnep" id="pnep" class="block mt-1 w-full"
                                      type="text" name="pnep"
                                      :value="old('pnep')"
                                      x-mask="999-999-9999"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('pnep')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="fep" :value="__('Fire Emergency Phone Number')"/>
                        <x-text-input wire:model.defer="fep" id="fep" class="block mt-1 w-full" type="text" name="fep"
                                      :value="old('fep')"
                                      x-mask="999-999-9999"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('fep')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="fnep" :value="__('Fire Non-Emergency Phone Number')"/>
                        <x-text-input wire:model.defer="fnep" id="fnep" class="block mt-1 w-full" type="text"
                                      name="fnep"
                                      :value="old('fnep')"
                                      x-mask="999-999-9999"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('fnep')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="fireAlarm" :value="__('What type of fire alarm System do you use?')"/>
                        <x-text-input wire:model.defer="fireAlarm" id="fireAlarm" class="block mt-1 w-full" type="text"
                                      name="fireAlarm"
                                      :value="old('fireAlarm')"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('fireAlarm')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="burglarAlarm" :value="__('What type of Burglar Alarm System do you use?')"/>
                        <x-text-input wire:model.defer="burglarAlarm" id="burglarAlarm" class="block mt-1 w-full"
                                      type="text" name="burglarAlarm"
                                      :value="old('burglarAlarm')"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('burglarAlarm')" class="mt-2"/>
                    </div>
                </div>
                <div>
                    <x-input-label for="firewallCompany" :value="__('Firewall Company')"/>
                    <x-text-input wire:model.defer="firewallCompany" id="firewallCompany" class="block mt-1 w-full"
                                  type="text" name="firewallCompany"
                                  :value="old('firewallCompany')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('firewallCompany')" class="mt-2"/>
                </div>
                <div class="space-y-1">
                    <x-input-label for="name" :value="__('IP Addresses')"/>
                    @foreach($ipAddresses as $key => $input)
                        <div class="flex flex-wrap items-end justify-between sm:flex-nowrap">
                            <div class="flex-1">
                                <x-text-input
                                    id="input_{{$key}}_ip"
                                    wire:model.defer="ipAddresses.{{$key}}.ipAddress"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="off"
                                    placeholder="IP Address"
                                />
                                @error('ipAddresses.'.$key.'.ipAddress') <span
                                    class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <x-danger-button type="button" wire:click="removeIpAddress({{$key}})"
                                             class="flex-shrink-0 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </x-danger-button>
                        </div>
                    @endforeach
                    <x-secondary-button type="button" wire:click="addIpAddress">Add IP Address</x-secondary-button>
                </div>
                <div>
                    <x-input-label for="mfa"
                                   :value="__('Multi-Factor Authentication (MFA) - Do you have it installed and being utilized?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="mfa" value="1" id="mfa_1" aria-describedby="mfa-description"
                                       name="mfa" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="mfa_1" id="mfa" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="mfa" value="0" id="mfa_0" aria-describedby="mfa" name="mfa"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="mfa_0" id="mfa" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="vulnerability"
                                   :value="__('Are IT Vulnerability scans currently being completed?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="vulnerability" value="1" id="vulnerability_1"
                                       aria-describedby="vulnerability-description" name="vulnerability" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="vulnerability_1" id="mfa" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="vulnerability" value="0" id="vulnerability_0"
                                       aria-describedby="vulnerability-description" name="vulnerability" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="vulnerability_0" id="mfa" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="monitoring"
                                   :value="__('Are you currently Monitoring & Logging User Activity at your dealership?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="monitoring" value="1" id="monitoring_1"
                                       aria-describedby="monitoring-description" name="monitoring" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="monitoring_1" id="monitoring" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="monitoring" value="0" id="monitoring_0"
                                       aria-describedby="monitoring-description" name="monitoring" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="monitoring_0" id="monitoring" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="antivirus" :value="__('Antivirus Software')"/>
                    <x-text-input wire:model.defer="antivirus" id="antivirus" class="block mt-1 w-full" type="text"
                                  name="antivirus"
                                  :value="old('antivirus')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('antivirus')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="antivirusComputers"
                                   :value="__('Anti-Virus Applied on individual computers or through server?')"/>
                    <x-text-input wire:model.defer="antivirusComputers" id="antivirusComputers"
                                  class="block mt-1 w-full" type="text" name="antivirusComputers"
                                  :value="old('antivirusComputers')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('antivirusComputers')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="screensaverMinutes"
                                   :value="__('How many minutes are the monitors set for screen saver activation?')"/>
                    <x-text-input wire:model.defer="screensaverMinutes" id="screensaverMinutes"
                                  class="block mt-1 w-full" type="number" name="screensaverMinutes"
                                  :value="old('screensaverMinutes')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('screensaverMinutes')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="dmsProvider"
                                   :value="__('Who is your Dealership Management System Provider (DMS)')"/>
                    <x-text-input wire:model.defer="dmsProvider" id="dmsProvider" class="block mt-1 w-full" type="text"
                                  name="dmsProvider"
                                  :value="old('dmsProvider')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('dmsProvider')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="backups" :value="__('Where and how are backups being stored?')"/>
                    <x-text-input wire:model.defer="backups" id="backups" class="block mt-1 w-full" type="text"
                                  name="backups"
                                  :value="old('backups')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('backups')" class="mt-2"/>
                </div>
                <div class="space-y-1">
                    <x-input-label for="name" :value="__('Website URL\'s')"/>
                    @foreach($websiteUrls as $urlKey => $urlInput)
                        <div class="flex flex-wrap items-end justify-between sm:flex-nowrap">
                            <div class="flex-1">
                                <x-text-input
                                    id="urlInput_{{$urlKey}}_url"
                                    wire:model.defer="websiteUrls.{{$urlKey}}.websiteUrl"
                                    type="url"
                                    class="mt-1 block w-full"
                                    autocomplete="off"
                                />
                                @error('url.'.$urlKey.'.url') <span
                                    class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <x-danger-button type="button" wire:click="removeWebsiteUrl({{$urlKey}})"
                                             class="flex-shrink-0 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </x-danger-button>

                        </div>
                    @endforeach
                    <x-secondary-button type="button" wire:click="addWebsiteUrl">Add Website URL</x-secondary-button>
                </div>
                <div>
                    <x-input-label for="designatedRedFlagCoordinator"
                                   :value="__('Who is your designated Red Flag Coordinator?')"/>
                    <x-text-input wire:model.defer="designatedRedFlagCoordinator" id="designatedRedFlagCoordinator"
                                  class="block mt-1 w-full" type="text" name="designatedRedFlagCoordinator"
                                  :value="old('designatedRedFlagCoordinator')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('designatedRedFlagCoordinator')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="documentShredding" :value="__('Do you use a document Shredding Company?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="documentShredding" value="1" id="documentShredding_1"
                                       aria-describedby="documentShredding-description" name="documentShredding"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="documentShredding_1" id="documentShredding"
                                       class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="documentShredding" value="0" id="documentShredding_0"
                                       aria-describedby="documentShredding-description" name="documentShredding"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="documentShredding_0" id="documentShredding" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="serviceProviderAgreements"
                                   :value="__('Are Service Provider Agreements & Risk Assessments on file with your dealership?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="serviceProviderAgreements" value="1"
                                       id="serviceProviderAgreements_1"
                                       aria-describedby="serviceProviderAgreements-description"
                                       name="serviceProviderAgreements" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="serviceProviderAgreements_1" id="serviceProviderAgreements"
                                       class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="serviceProviderAgreements" value="0"
                                       id="serviceProviderAgreements_0"
                                       aria-describedby="serviceProviderAgreements-description"
                                       name="serviceProviderAgreements" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="serviceProviderAgreements_0" id="serviceProviderAgreements"
                                       class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="offsiteStorage"
                                   :value="__('Does your dealership store any customer information at offsite locations?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="offsiteStorage" value="1" id="offsiteStorage_1"
                                       aria-describedby="offsiteStorage-description" name="offsiteStorage" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="offsiteStorage_1" id="offsiteStorage" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="offsiteStorage" value="0" id="offsiteStorage_0"
                                       aria-describedby="offsiteStorage-description" name="offsiteStorage" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="offsiteStorage_0" id="offsiteStorage" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="otherBusiness"
                                   :value="__('Does your dealership have an affiliation with any other business where he/she has a financial interest of more than 25%?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="otherBusiness" value="1" id="otherBusiness_1"
                                       aria-describedby="otherBusiness-description" name="otherBusiness" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="otherBusiness_1" id="otherBusiness" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="otherBusiness" value="0" id="otherBusiness_0"
                                       aria-describedby="otherBusiness-description" name="otherBusiness" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="otherBusiness_0" id="otherBusiness" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="vendorAccess"
                                   :value="__('Are there any vendors that have after hour access to your dealership and other buildings storing customer information?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="vendorAccess" value="1" id="vendorAccess_1"
                                       aria-describedby="vendorAccess-description" name="vendorAccess" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="vendorAccess_1" id="vendorAccess" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="vendorAccess" value="0" id="vendorAccess_0"
                                       aria-describedby="vendorAccess-description" name="vendorAccess" type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="vendorAccess_0" id="vendorAccess" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="personalDevices"
                                   :value="__('Are there any persons that have customers access on their personal PC or that maintain a customer data base on their personal device of any kind?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="personalDevices" value="1" id="personalDevices_1"
                                       aria-describedby="personalDevices-description" name="personalDevices"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="personalDevices_1" id="personalDevices" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="personalDevices" value="0" id="personalDevices_0"
                                       aria-describedby="personalDevices-description" name="personalDevices"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="personalDevices_0" id="personalDevices" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="complianceIssues"
                                   :value="__('Have there been any compliance related issues that Automotive Risk Management Partners should be made aware of i.e. Information being compromised, fraud attempted on the dealership etc.')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="complianceIssues" value="1" id="complianceIssues_1"
                                       aria-describedby="complianceIssues-description" name="complianceIssues"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="complianceIssues_1" id="complianceIssues" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="complianceIssues" value="1" id="complianceIssues_0"
                                       aria-describedby="complianceIssues-description" name="complianceIssues"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="complianceIssues_0" id="complianceIssues" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="fi_products_sold" :value="__('What F&I products are sold in the F&I Department?')"/>
                    <x-text-input wire:model.defer="fi_products_sold" id="fi_products_sold" class="block mt-1 w-full" type="text"
                                  name="fi_products_sold"
                                  :value="old('fi_products_sold')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('fi_products_sold')" class="mt-2"/>
                </div>

                <div class="space-y-1">
                    <x-input-label for="name" :value="__('Service Contracts: New and Used')"/>
                    @foreach($service_contracts as $contractKey => $contractInput)
                        <div class="flex flex-wrap items-end justify-between sm:flex-nowrap">
                            <div class="flex-1">
                                <x-text-input
                                    id="service_contractsInput_{{$contractKey}}_service_contract"
                                    wire:model.defer="service_contracts.{{$contractKey}}.serviceContract"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="off"
                                />
                                @error('service_contracts.'.$contractKey.'.contract') <span
                                    class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <x-danger-button type="button" wire:click="removeServiceContract({{$contractKey}})"
                                             class="flex-shrink-0 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </x-danger-button>

                        </div>
                    @endforeach
                    <x-secondary-button type="button" wire:click="addServiceContract">Add Contract</x-secondary-button>
                </div>

                <div class="space-y-1">
                    <x-input-label for="name" :value="__('Combo/Tire and Wheel')"/>
                    @foreach($tire_wheel as $twKey => $twInput)
                        <div class="flex flex-wrap items-end justify-between sm:flex-nowrap">
                            <div class="flex-1">
                                <x-text-input
                                    id="tire_wheelsInput_{{$twKey}}_tw"
                                    wire:model.defer="tire_wheel.{{$twKey}}.tireWheel"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="off"
                                />
                                @error('$tire_wheel.'.$twKey.'.tw') <span
                                    class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <x-danger-button type="button" wire:click="removeTireWheel({{$twKey}})"
                                             class="flex-shrink-0 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </x-danger-button>

                        </div>
                    @endforeach
                    <x-secondary-button type="button" wire:click="addTireWheel">Add</x-secondary-button>
                </div>

                <div class="space-y-1">
                    <x-input-label for="name" :value="__('Other ie: Etch, Security Systems, GPS')"/>
                    @foreach($other_fi as $fiKey => $fiInput)
                        <div class="flex flex-wrap items-end justify-between sm:flex-nowrap">
                            <div class="flex-1">
                                <x-text-input
                                    id="other_fiInput_{{$fiKey}}_fi"
                                    wire:model.defer="other_fi.{{$fiKey}}.otherFi"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="off"
                                />
                                @error('other_fi.'.$fiKey.'.fi') <span
                                    class="text-xs text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <x-danger-button type="button" wire:click="removeOtherFi({{$fiKey}})"
                                             class="flex-shrink-0 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </x-danger-button>

                        </div>
                    @endforeach
                    <x-secondary-button type="button" wire:click="addOtherFi">Add</x-secondary-button>
                </div>

                <div>
                    <x-input-label for="fi_products_sold" :value="__('What F&I System do you use? IE: Reynolds, Stone Eagle, Dealer Track')"/>
                    <x-text-input wire:model.defer="fi_system" id="fi_system" class="block mt-1 w-full" type="text"
                                  name="fi_products_sold"
                                  :value="old('fi_system')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('fi_system')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="fi_products_sold" :value="__('Where is their appearance protection products sold? Sales floor-Separate dept-F&I')"/>
                    <x-text-input wire:model.defer="appearance_protection_sold" id="appearance_protection_sold" class="block mt-1 w-full" type="text"
                                  name="fi_products_sold"
                                  :value="old('appearance_protection_sold')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('appearance_protection_sold')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="reinsurance"
                                   :value="__('Does the dealer have a reinsurance company formed?')"/>
                    <div class="flex space-x-5">
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="reinsurance" value="1" id="reinsurance_1"
                                       aria-describedby="reinsurance-description" name="reinsurance"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="reinsurance_1" id="reinsurance" class="text-gray-500">Yes</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input wire:model.defer="reinsurance" value="0" id="reinsurance_0"
                                       aria-describedby="reinsurance-description" name="reinsurance"
                                       type="radio"
                                       class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="reinsurance_0" id="reinsurance" class="text-gray-500">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="admin_name" :value="__('Who is the administrator?')"/>
                    <x-text-input wire:model.defer="admin_name" id="admin_name" class="block mt-1 w-full" type="text"
                                  name="fi_products_sold"
                                  :value="old('admin_name')"
                                  autofocus/>
                    <x-input-error :messages="$errors->get('admin_name')" class="mt-2"/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="fi_username" :value="__('F&I Logs Username')"/>
                        <x-text-input wire:model.defer="fi_username" id="fi_username" class="block mt-1 w-full" type="text"
                                      name="fi_username"
                                      :value="old('fi_username')"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('fi_username')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="fi_password" :value="__('F&I Logs Password')"/>
                        <div class="relative">
                            <input
                                wire:model.defer="fi_password"
                                id="fi_password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none  text-base" :type="show ? 'password' : 'text'" name="password" id="password" autocomplete="off" type="password">
                            <div class="absolute top-1/2 right-4 cursor-pointer" style="transform: translateY(-50%);">
                                <svg class="h-4 text-gray-700 block" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                    </path>
                                </svg>

                                <svg class="h-4 text-gray-700 hidden" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('fi_password')" class="mt-2"/>
                    </div>
                </div>

                <div class="py-3 text-right">
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
