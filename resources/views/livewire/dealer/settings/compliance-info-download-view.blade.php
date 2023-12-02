<div>
    <div class="flex justify-between items-end mb-20 border-b pb-5">
        <x-application-logo class="h-6" />
        <span class="text-right text-xs text-arm-blue-800">{{ $store->name }} <br />Compliance Information</span>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div class="mt-5 page-break">
            <x-input-label :value="__('Qualified Individual Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->qualified_individual_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Qualified Individual Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->qualified_individual_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Service Manager Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->service_manager_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Service Manager Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->service_manager_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Parts Manager Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->parts_manager_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Parts Manager Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->parts_manager_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Body Shop Manager Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->body_shop_manager_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Body Shop Manager Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->body_shop_manager_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('General Manager Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->general_manager_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('General Manager Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->general_manager_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Owner Name')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->owner_name ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Owner Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $managers->owner_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Police Emergency Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->police_emergency_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Police Non-Emergency Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->police_non_emergency_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Fire Emergency Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->fire_emergency_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('Fire Non-Emergency Phone Number')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->fire_non_emergency_phone ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('What type of fire alarm System do you use?')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->fire_alarm_type ?? '' }}
            </div>
        </div>
        <div class="mt-5 page-break">
            <x-input-label :value="__('What type of Burglar Alarm System do you use?')"/>
            <div class="w-full h-6 border-b mt-3 text-xs">
                {{ $store->burglar_alarm_type ?? '' }}
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Firewall Company')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->firewall_company ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('IP Addresses')"/>
        @if($store->ip_addresses)
        <div class="w-full mt-3">
            @foreach($store->ip_addresses as $ip)
                <div class="text-xs">{{ $ip }}</div>
            @endforeach
        </div>
        @endif
        <div class="w-full h-32 border px-3 mt-3">
            <span class="text-gray-200 text-xs">Add any additional IP Addresses</span>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="mfa"
                       :value="__('Multi-Factor Authentication (MFA) - Do you have it installed and being utilized?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="mfa_1" aria-describedby="mfa-description"
                           {{ $store->mfa == 1 ? 'checked' : '' }}
                           name="mfa" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="mfa_1" id="mfa" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="mfa_0" aria-describedby="mfa" name="mfa"
                            {{ $store->mfa == 0 ? 'checked' : '' }}
                           type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="mfa_0" id="mfa" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="vulnerability"
                       :value="__('Are IT Vulnerability scans currently being completed?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="vulnerability_1"
                            {{ $store->vulnerability == 1 ? 'checked' : '' }}
                           aria-describedby="vulnerability-description" name="vulnerability" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="vulnerability_1" id="mfa" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="vulnerability_0"
                            {{ $store->vulnerability == 0 ? 'checked' : '' }}
                           aria-describedby="vulnerability-description" name="vulnerability" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="vulnerability_0" id="mfa" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="monitoring"
                       :value="__('Are you currently Monitoring & Logging User Activity at your dealership?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="monitoring_1"
                            {{ $store->monitoring == 1 ? 'checked' : '' }}
                           aria-describedby="monitoring-description" name="monitoring" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="monitoring_1" id="monitoring" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="monitoring_0"
                            {{ $store->monitoring == 0 ? 'checked' : '' }}
                           aria-describedby="monitoring-description" name="monitoring" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="monitoring_0" id="monitoring" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Antivirus Software')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->antivirus_software ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="antivirusComputers"
                       :value="__('Anti-Virus Applied on individual computers or through server?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->antivirus_computers ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="screensaverMinutes"
                       :value="__('How many minutes are the monitors set for screen saver activation?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->screensaver_minutes ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="dmsProvider"
                       :value="__('Who is your Dealership Management System Provider (DMS)')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->dms_provider ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="backups" :value="__('Where and how are backups being stored?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->backups ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Website URL\'s')"/>
        @if($store->website_urls)
        <div class="w-full mt-3">
            @foreach($store->website_urls as $url)
                <div class="text-xs">{{ $url }}</div>
            @endforeach
        </div>
        @endif
        <div class="w-full h-32 border px-3 mt-3">
            <span class="text-gray-200 text-xs">Add any additional Website Url's</span>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label
                       :value="__('Who is your designated Red Flag Coordinator?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->designated_red_flag_coordinator ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="document_shredding"
                       :value="__('Do you use a document Shredding Company?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="document_shredding_1"
                           {{ $store->document_shredding == 1 ? 'checked' : '' }}
                           aria-describedby="document_shredding-description" name="document_shredding" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="document_shredding_1" id="document_shredding" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="document_shredding_0"
                           {{ $store->document_shredding == 0 ? 'checked' : '' }}
                           aria-describedby="document_shredding-description" name="document_shredding" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="document_shredding_0" id="document_shredding" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="service_provider_agreements"
                       :value="__('Are Service Provider Agreements & Risk Assessments on file with your dealership?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="service_provider_agreements_1"
                           {{ $store->service_provider_agreements ==1 ? 'checked' : '' }}
                           aria-describedby="service_provider_agreements-description" name="service_provider_agreements" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="service_provider_agreements_1" id="service_provider_agreements" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="service_provider_agreements_0"
                           {{ $store->service_provider_agreements == 0 ? 'checked' : '' }}
                           aria-describedby="service_provider_agreements-description" name="service_provider_agreements" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="service_provider_agreements_0" id="service_provider_agreements" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="offsite_storage"
                       :value="__('Does your dealership store any customer information at offsite locations?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="offsite_storage_1"
                           {{ $store->service_provider_agreements ==1 ? 'checked' : '' }}
                           aria-describedby="offsite_storage-description" name="offsite_storage" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="offsite_storage_1" id="offsite_storage" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="offsite_storage_0"
                           {{ $store->offsite_storage == 0 ? 'checked' : '' }}
                           aria-describedby="offsite_storage-description" name="offsite_storage" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="offsite_storage_0" id="offsite_storage" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="other_business"
                       :value="__('Does your dealership have an affiliation with any other business where he/she has a financial interest of more than 25%?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="other_business_1"
                           {{ $store->service_provider_agreements ==1 ? 'checked' : '' }}
                           aria-describedby="other_business-description" name="other_business" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="other_business_1" id="other_business" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="other_business_0"
                           {{ $store->other_business == 0 ? 'checked' : '' }}
                           aria-describedby="other_business-description" name="other_business" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="other_business_0" id="other_business" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="vendor_access"
                       :value="__('Are there any vendors that have after hour access to your dealership and other buildings storing customer information?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="vendor_access_1"
                           {{ $store->service_provider_agreements ==1 ? 'checked' : '' }}
                           aria-describedby="vendor_access-description" name="vendor_access" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="vendor_access_1" id="vendor_access" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="vendor_access_0"
                           {{ $store->vendor_access == 0 ? 'checked' : '' }}
                           aria-describedby="vendor_access-description" name="vendor_access" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="vendor_access_0" id="vendor_access" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="personal_devices"
                       :value="__('Are there any persons that have customers access on their personal PC or that maintain a customer data base on their personal device of any kind?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="personal_devices_1"
                           {{ $store->personal_devices ==1 ? 'checked' : '' }}
                           aria-describedby="personal_devices-description" name="personal_devices" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="personal_devices_1" id="personal_devices" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="personal_devices_0"
                           {{ $store->personal_devices == 0 ? 'checked' : '' }}
                           aria-describedby="personal_devices-description" name="personal_devices" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="personal_devices_0" id="personal_devices" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="compliance_issues"
                       :value="__('Have there been any compliance related issues that Automotive Risk Management Partners should be made aware of i.e. Information being compromised, fraud attempted on the dealership etc.')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="compliance_issues_1"
                           {{ $store->compliance_issues ==1 ? 'checked' : '' }}
                           aria-describedby="compliance_issues-description" name="compliance_issues" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="compliance_issues_1" id="compliance_issues" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="compliance_issues_0"
                           {{ $store->compliance_issues == 0 ? 'checked' : '' }}
                           aria-describedby="compliance_issues-description" name="compliance_issues" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="compliance_issues_0" id="compliance_issues" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('What F&I products are sold in the F&I Department?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->fi_products_sold ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Service Contracts: New and Used')"/>
        @if($store->service_contracts)
        <div class="w-full mt-3">
            @foreach($store->service_contracts as $contract)
                <div class="text-xs">{{ $contract }}</div>
            @endforeach
        </div>
        @endif
        <div class="w-full h-32 border px-3 mt-3">
            <span class="text-gray-200 text-xs">Add any additional Service Contracts</span>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Combo/Tire and Wheel')"/>
        @if($store->tire_wheel)
        <div class="w-full mt-3">
            @foreach($store->tire_wheel as $tire)
                <div class="text-xs">{{ $tire }}</div>
            @endforeach
        </div>
        @endif
        <div class="w-full h-32 border px-3 mt-3">
            <span class="text-gray-200 text-xs">Add any additional Combo/Tire and Wheel</span>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Other ie: Etch, Security Systems, GPS')"/>
        @if($store->other_fi)
        <div class="w-full mt-3">
            @foreach($store->other_fi as $other)
                <div class="text-xs">{{ $other }}</div>
            @endforeach
        </div>
        @endif
        <div class="w-full h-32 border px-3 mt-3">
            <span class="text-gray-200 text-xs">Add any additional to Other</span>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('What F&I System do you use? IE: Reynolds, Stone Eagle, Dealer Track')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->fi_system ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Where is their appearance protection products sold? Sales floor-Separate dept-F&I')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->appearance_protection_sold ?? '' }}
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label for="reinsurance"
                       :value="__('Does the dealer have a reinsurance company formed?')"/>
        <div class="flex space-x-5">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="1" id="reinsurance_1"
                           {{ $store->reinsurance ==1 ? 'checked' : '' }}
                           aria-describedby="reinsurance-description" name="reinsurance" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="reinsurance_1" id="reinsurance" class="text-gray-500">Yes</label>
                </div>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input value="0" id="reinsurance_0"
                           {{ $store->reinsurance == 0 ? 'checked' : '' }}
                           aria-describedby="reinsurance-description" name="reinsurance" type="radio"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="reinsurance_0" id="reinsurance" class="text-gray-500">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 page-break">
        <x-input-label :value="__('Who is the administrator?')"/>
        <div class="w-full h-6 border-b mt-3 text-xs">
            {{ $store->admin_name ?? '' }}
        </div>
    </div>
</div>
