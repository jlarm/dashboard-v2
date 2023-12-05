<div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Compliance Information</h3>
            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what
                you share.</p>
            <x-primary-button>Download form</x-primary-button>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
            <form wire:submit.prevent="save" class="space-y-5">

                <!-- Firewall Company -->
                <div>
                    <x-input-label for="firewall_company" value="Firewall Company"/>
                    <div class="mt-2">
                        <input wire:model.defer="firewall_company" type="text" name="firewall_company"
                               id="firewall_company"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('firewall_company')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- External IP's -->
                <div class="space-y-3">
                    <x-input-label for="name" value="External IP Addresses"/>
                    @foreach($ip_addresses ?? [] as $key => $value)
                        <div class="block" wire:key="ip_addresses.{{$key}}">
                            <div class="w-full flex space-x-3">
                                <input
                                    wire:model.defer="ip_addresses.{{$key}}"
                                    type="text"
                                    name="ip_addresses"
                                    placeholder="127.0.0.1"
                                    id="ip_addresses"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                />
                                <button wire:click.prevent="removeIp({{$key}})" type="button"
                                        class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </button>
                                @error('ip_addresses.{{$key}}')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                    <button wire:click.prevent="addIp" type="button"
                            class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        Add IP Address
                    </button>
                </div>

                <!-- MFA -->
                <div>
                    <x-input-label for="vulnerability"
                                   value="Multi-Factor Authentication (MFA) - Do you have it installed and being utilized?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="mfa-y" name="mfa" type="radio" wire:model.defer="mfa" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="mfa-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="mfa-n" name="mfa" type="radio" wire:model.defer="mfa" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="mfa-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('mfa')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Vulnerability -->
                <div>
                    <x-input-label for="vulnerability" value="Are IT Vulnerability scans currently being completed?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="vul-y" name="vul" type="radio" wire:model.defer="vulnerability" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="vul-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="vul-n" name="vul" type="radio" wire:model.defer="vulnerability" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="vul-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('vulnerability')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Currently Monitoring -->
                <div>
                    <x-input-label for="currently_monitoring"
                                   value="Are you currently Monitoring & Logging User Activity at your dealership?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="currently_monitoring-y" name="currently_monitoring" type="radio"
                                       wire:model.defer="currently_monitoring" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="currently_monitoring-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="currently_monitoring-n" name="currently_monitoring" type="radio"
                                       wire:model.defer="currently_monitoring" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="currently_monitoring-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('currently_monitoring')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Virus Software -->
                <div>
                    <x-input-label for="virus_software" value="Anti-Virus Software"/>
                    <div class="mt-2">
                        <input wire:model.defer="antivirus_software" type="text" name="antivirus_software"
                               id="antivirus_software"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('antivirus_software')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Anti Virus Applied -->
                <div>
                    <x-input-label value="Anti-Virus Applied on individual computers or through server?"/>
                    <div class="mt-2">
                        <input wire:model.defer="antivirus_computers" type="text" name="antivirus_computers"
                               id="antivirus_computers"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('antivirus_computers')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Anti Virus Minutes -->
                <div>
                    <x-input-label value="How many minutes are the monitors set for screen saver activation?"/>
                    <div class="mt-2">
                        <input wire:model.defer="antivirus_minutes" type="text" name="antivirus_minutes"
                               id="antivirus_minutes"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('antivirus_minutes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- DMS Provider -->
                <div>
                    <x-input-label value="Who is your Dealership Management System Provider (DMS)"/>
                    <div class="mt-2">
                        <input wire:model.defer="dms_provider" type="text" name="dms_provider" id="dms_provider"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('dms_provider')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Backups -->
                <div>
                    <x-input-label value="Where and how are backups being stored?"/>
                    <div class="mt-2">
                        <input wire:model.defer="backups" type="text" name="backups" id="backups"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('backups')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Website URLs -->
                <div class="space-y-3">
                    <x-input-label for="urls" value="URL’s/Web Sites"/>
                    @foreach($website_urls ?? [] as $key => $value)
                        <div class="flex space-x-3">
                            <input wire:model.defer="website_urls.{{$key}}" type="text" name="website_urls"
                                   id="website_urls"
                                   placeholder="http://google.com"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                            <button wire:click.prevent="removeUrl({{$key}})" type="button"
                                    class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                    <button wire:click.prevent="addUrl({{$u}})" type="button"
                            class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        Add URL
                    </button>
                </div>

                <!-- Red Flag Coordinator -->
                <div>
                    <x-input-label value="Who is your designated Red Flag Coordinator?"/>
                    <div class="mt-2">
                        <input wire:model.defer="designated_red_flag_coordinator" type="text"
                               name="designated_red_flag_coordinator" id="designated_red_flag_coordinator"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @error('designated_red_flag_coordinator')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Document Shredding -->
                <div>
                    <x-input-label for="document_shredding"
                                   value="Do you use a document Shredding Company?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="document_shredding-y" name="document_shredding" type="radio"
                                       wire:model.defer="document_shredding" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="document_shredding-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="document_shredding-n" name="document_shredding" type="radio"
                                       wire:model.defer="document_shredding" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="document_shredding-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('document_shredding')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Service Provider Agreements -->
                <div>
                    <x-input-label for="service_provider_agreements"
                                   value="Are Service Provider Agreements & Risk Assessments on file with your dealership?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="service_provider_agreements-y" name="service_provider_agreements"
                                       type="radio"
                                       wire:model.defer="service_provider_agreements" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="service_provider_agreements-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="service_provider_agreements-n" name="service_provider_agreements"
                                       type="radio"
                                       wire:model.defer="service_provider_agreements" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="service_provider_agreements-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('service_provider_agreements')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Offsite Storage -->
                <div>
                    <x-input-label for="offsite_storage"
                                   value="Does your dealership store any customer information at offsite locations?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="offsite_storage-y" name="offsite_storage"
                                       type="radio"
                                       wire:model.defer="offsite_storage" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="offsite_storage-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="offsite_storage-n" name="offsite_storage"
                                       type="radio"
                                       wire:model.defer="offsite_storage" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="offsite_storage-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('offsite_storage')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Other Business -->
                <div>
                    <x-input-label for="other_business"
                                   value="Does your dealership have an affiliation with any other business where he/she has a financial interest of more than 25%?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="other_business-y" name="other_business"
                                       type="radio"
                                       wire:model.defer="other_business" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="other_business-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="other_business-n" name="other_business"
                                       type="radio"
                                       wire:model.defer="other_business" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="other_business-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('other_business')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Vendor Access -->
                <div>
                    <x-input-label for="vendor_access"
                                   value="Are there any vendors that have after hour access to your dealership and other buildings storing customer information?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="vendor_access-y" name="vendor_access"
                                       type="radio"
                                       wire:model.defer="vendor_access" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="vendor_access-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="vendor_access-n" name="vendor_access"
                                       type="radio"
                                       wire:model.defer="vendor_access" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="vendor_access-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('vendor_access')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Personal Devices -->
                <div>
                    <x-input-label for="personal_devices"
                                   value="Are there any persons that have customers access on their personal PC or that maintain a customer data base on their personal device of any kind?"/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="personal_devices-y" name="personal_devices"
                                       type="radio"
                                       wire:model.defer="personal_devices" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="personal_devices-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="personal_devices-n" name="personal_devices"
                                       type="radio"
                                       wire:model.defer="personal_devices" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="personal_devices-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('personal_devices')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <!-- Compliance Issues -->
                <div>
                    <x-input-label for="compliance_issues"
                                   value="Have there been any compliance related issues that Automotive Risk Management Partners should be made aware of i.e. Information being compromised, fraud attempted on the dealership etc."/>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="compliance_issues-y" name="compliance_issues"
                                       type="radio"
                                       wire:model.defer="compliance_issues" value="1"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="compliance_issues-y"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>

                            <div class="flex items-center">
                                <input id="compliance_issues-n" name="compliance_issues"
                                       type="radio"
                                       wire:model.defer="compliance_issues" value="0"
                                       class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                <label for="compliance_issues-n"
                                       class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            @error('compliance_issues')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <div class="py-3 text-right">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        type="submit">
                        Save
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
