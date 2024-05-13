<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <div class="col-span-2 border rounded-md p-5">
        <form wire:submit.prevent="update" class="space-y-12">

            <!-- Contract Type -->
            <div>
                <label for="contract_type" class="block text-sm font-medium leading-6 text-gray-900">Contract Type</label>
                <select wire:model.defer="contractType" id="contract_type" name="contract_type" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                    <option value="yearly">Yearly</option>
                    <option value="monthly">Month to Month</option>
                </select>
            </div>

            <!-- Contract Information -->
            <div class="border-b pb-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerName" :value="__('Dealership Name')" />
                        <x-text-input wire:model.defer="dealerName" id="dealerName" class="block mt-1 w-full" type="text" name="dealerName" :value="old('dealerName')" />
                        @error('dealerName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="agreementDate" :value="__('Agreement Date')" />
                        <x-text-input wire:model.defer="agreementDate" id="agreementDate" class="block mt-1 w-full" type="date" name="agreementDate" :value="old('agreementDate')" />
                        @error('agreementDate')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="commenceDate" :value="__('Commencement Date')" />
                        <x-text-input wire:model.defer="commenceDate" id="commenceDate" class="block mt-1 w-full" type="date" name="commenceDate" :value="old('commenceDate')" />
                        @error('commenceDate')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <x-input-label for="yearlyInspectionTotal" :value="__('Total Number of Yearly Inspections')" />
                        <x-text-input wire:model.defer="yearlyInspectionTotal" id="yearlyInspectionTotal" class="block mt-1 w-full" type="number" name="yearlyInspectionTotal" :value="old('yearlyInspectionTotal')" />
                        @error('yearlyInspectionTotal')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="initialFee" :value="__('Initial Fee')" />
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <x-text-input x-mask:dynamic="$money($input)" wire:model.defer="initialFee" id="initialFee" class="block mt-1 w-full pl-7" type="text" name="initialFee" :value="old('initialFee')" placeholder="0.00" />
                        </div>
                        @error('initialFee')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="monthlyFee" :value="__('Monthly Fee')" />
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <x-text-input x-mask:dynamic="$money($input)" wire:model.defer="monthlyFee" id="monthlyFee" class="block mt-1 w-full pl-7" type="text" name="monthlyFee" :value="old('monthlyFee')" placeholder="0.00" />
                        </div>
                        @error('monthlyFee')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <x-input-label for="agreementDate" :value="__('Services')" />
                        <fieldset class="mt-1">
                            <legend class="sr-only">Services</legend>
                            <div class="space-y-2">
                                @foreach(\App\Enums\Service::cases() as $service)
                                    <div class="relative flex items-start">
                                        <div class="flex h-6 items-center">
                                            <input wire:model.defer="services" id="{{ $service }}" value="{{ $service }}"  type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                        </div>
                                        <div class="ml-3 text-sm leading-6">
                                            <label for="{{ $service }}" class="text-gray-500">{{ $service->label() }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                </div>
            </div>

            <!-- Dealership Physical Address -->
            <div class="border-b pb-12">
                <h2 class="text-base font-semibold leading-7">Dealership Physical Address</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerName" :value="__('Address')" />
                        <x-text-input wire:model.defer="dealerPhysicalAddress" id="dealerPhysicalAddress" class="block mt-1 w-full" type="text" name="dealerPhysicalAddress" :value="old('dealerPhysicalAddress')" />
                        @error('dealerPhysicalAddress')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalCity" :value="__('City')" />
                        <x-text-input wire:model.defer="dealerPhysicalCity" id="dealerPhysicalCity" class="block mt-1 w-full" type="text" name="dealerPhysicalCity" :value="old('dealerPhysicalCity')" />
                        @error('dealerPhysicalCity')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalState" :value="__('State')" />
                        <x-text-input wire:model.defer="dealerPhysicalState" id="dealerPhysicalState" class="block mt-1 w-full" type="text" name="dealerPhysicalState" :value="old('dealerPhysicalState')" />
                        @error('dealerPhysicalState')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalZip" :value="__('Zip Code')" />
                        <x-text-input wire:model.defer="dealerPhysicalZip" id="dealerPhysicalZip" class="block mt-1 w-full" type="text" name="dealerPhysicalZip" :value="old('dealerPhysicalZip')" />
                        @error('dealerPhysicalZip')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerPhone" :value="__('Phone Number')" />
                        <x-text-input x-mask="999-999-9999" wire:model.defer="dealerPhone" id="dealerPhone" class="block mt-1 w-full" type="tel" name="dealerPhone" :value="old('dealerPhone')" />
                        @error('dealerPhone')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-3">
                        <x-input-label for="dealerQiName" :value="__('Qualified Individual Name')" />
                        <x-text-input wire:model.defer="dealerQiName" id="dealerQiName" class="block mt-1 w-full" type="text" name="dealerQiName" :value="old('dealerQiName')" />
                        @error('dealerQiName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-3">
                        <x-input-label for="dealerQiEmail" :value="__('Qualified Individual Email Address')" />
                        <x-text-input wire:model.defer="dealerQiEmail" id="dealerQiEmail" class="block mt-1 w-full" type="text" name="dealerQiEmail" :value="old('dealerQiEmail')" />
                        @error('dealerQiEmail')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Locations -->
            <div class="space-y-4">
                @if($additionalLocations)
                    <div class="space-y-8">
                        @foreach($additionalLocations as $key => $location)
                            <div>
                                <div class="flex justify-between items-center">
                                    <h2 class="text-base font-semibold leading-7">Additional Location {{ $key +1 }}</h2>
                                    <button class="text-sm text-red-500 hover:text-red-700" wire:click.prevent="removeLocation({{ $key }})">Remove</button>
                                </div>
                                <div class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <x-input-label for="additionalDealerName" :value="__('Dealership Name')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.name" id="additionalDealerName" class="block mt-1 w-full" type="text" name="additionalDealerName" />
                                        @error('additionalLocations.'.$key.'.name')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ __('*Required') }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-6">
                                        <x-input-label for="additionalDealerAddress" :value="__('Address')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.address" id="additionalDealerAddress" class="block mt-1 w-full" type="text" name="additionalDealerAddress" />
                                        @error('additionalLocations.'.$key.'.address')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ __('*Required') }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerCity" :value="__('City')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.city" id="additionalDealerCity" class="block mt-1 w-full" type="text" name="additionalDealerCity" />
                                        @error('additionalLocations.'.$key.'.city')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ __('*Required') }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerState" :value="__('State')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.state" id="additionalDealerState" class="block mt-1 w-full" type="text" name="additionalDealerState" />
                                        @error('additionalLocations.'.$key.'.state')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ __('*Required') }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerZip" :value="__('Zip Code')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.zip" id="additionalDealerZip" class="block mt-1 w-full" type="text" name="additionalDealerZip" />
                                        @error('dealerPhysicalZip')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ __('*Required') }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerContactName" :value="__('Contact Name')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.contact_name" id="additionalDealerContactName" class="block mt-1 w-full" type="text" name="additionalDealerContactName" :value="old('dealerBillingContactName')" />
                                        @error('dealerBillingContactName')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerContactTitle" :value="__('Contact Title')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.contact_title" id="additionalDealerContactTitle" class="block mt-1 w-full" type="text" name="additionalDealerContactTitle" :value="old('dealerBillingContactTitle')" />
                                        @error('dealerBillingContactTitle')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="additionalDealerContactEmail" :value="__('Contact Email Address')" />
                                        <x-text-input wire:key="location-{{ $key }}" wire:model.defer="additionalLocations.{{ $key }}.contact_email" id="additionalDealerContactEmail" class="block mt-1 w-full" type="text" name="additionalDealerContactEmail" :value="old('dealerBillingContactEmail')" />
                                        @error('dealerBillingContactEmail')
                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <x-primary-button wire:click.prevent="addLocation">Add Location</x-primary-button>
            </div>

            <!-- Dealership Billing Address -->
            <div class="{{ $this->contract->dealer_signature ? 'border-b pb-12' : '' }}">
                <h2 class="text-base font-semibold leading-7">Dealership Billing Address</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerBillingAddress" :value="__('Address')" />
                        <x-text-input wire:model.defer="dealerBillingAddress" id="dealerBillingAddress" class="block mt-1 w-full" type="text" name="dealerBillingAddress" :value="old('dealerBillingAddress')" />
                        @error('dealerBillingAddress')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingCity" :value="__('City')" />
                        <x-text-input wire:model.defer="dealerBillingCity" id="dealerBillingCity" class="block mt-1 w-full" type="text" name="dealerBillingCity" :value="old('dealerBillingCity')" />
                        @error('dealerBillingCity')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingState" :value="__('State')" />
                        <x-text-input wire:model.defer="dealerBillingState" id="dealerBillingState" class="block mt-1 w-full" type="text" name="dealerBillingState" :value="old('dealerBillingState')" />
                        @error('dealerBillingState')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingZip" :value="__('Zip Code')" />
                        <x-text-input wire:model.defer="dealerBillingZip" id="dealerBillingZip" class="block mt-1 w-full" type="text" name="dealerBillingZip" :value="old('dealerBillingZip')" />
                        @error('dealerBillingZip')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerBillingFax" :value="__('Fax Number')" />
                        <x-text-input wire:model.defer="dealerBillingFax" id="dealerBillingFax" class="block mt-1 w-full" type="text" name="dealerBillingFax" :value="old('dealerBillingFax')" />
                        @error('dealerBillingFax')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingContactName" :value="__('Other Contact Name')" />
                        <x-text-input wire:model.defer="dealerBillingContactName" id="dealerBillingContactName" class="block mt-1 w-full" type="text" name="dealerBillingContactName" :value="old('dealerBillingContactName')" />
                        @error('dealerBillingContactName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingContactTitle" :value="__('Other Contact Title')" />
                        <x-text-input wire:model.defer="dealerBillingContactTitle" id="dealerBillingContactTitle" class="block mt-1 w-full" type="text" name="dealerBillingContactTitle" :value="old('dealerBillingContactTitle')" />
                        @error('dealerBillingContactTitle')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingContactEmail" :value="__('Other Contact Email Address')" />
                        <x-text-input wire:model.defer="dealerBillingContactEmail" id="dealerBillingContactEmail" class="block mt-1 w-full" type="text" name="dealerBillingContactEmail" :value="old('dealerBillingContactEmail')" />
                        @error('dealerBillingContactEmail')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ARMP Signature -->
            @if($this->contract->dealer_signature)
            <div>
                <h2 class="text-base font-semibold leading-7">ARMP Signature</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <x-input-label for="armpPrintedName" :value="__('Name')" />
                        <x-text-input wire:model.defer="armpPrintedName" id="armpPrintedName" class="block mt-1 w-full" type="text" name="armpPrintedName" :value="old('armpPrintedName')" />
                        @error('armpPrintedName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-3">
                    </div>
                    <div class="sm:col-span-3">
                        @if($contract->armp_signature)
                            <img class="border w-auto h-32" src="{{ Storage::disk('armpcon')->temporaryUrl($contract->armp_signature, now()->addMinutes(5)) }}" alt="">
                        @else
                            <x-signature-pad wire:model.defer="armpSignature" id="armpSignature" class="block mt-1 w-full" name="armpSignature" />
                        @endif
                    </div>
                </div>

            </div>
            @endif

            @if(!$this->contract->armp_signature)
                <div class="flex gap-3 items-center">
                    <x-primary-button wire:loading.attr="disabled">Update</x-primary-button>
                    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            @else
                <p class="text-gray-400 italic">* The Contract cannot be updated after both parties have signed.</p>
            @endif
        </form>
    </div>
    <div class="space-y-5">
        <livewire:central.contracts.activity :contract="$this->contract" />

        <livewire:central.contracts.checklist :contract="$this->contract" />

        @if(!$this->contract->dealer_signature)
            <livewire:central.contracts.send-contract :contract="$this->contract" />
        @endif

        @if($this->contract->armp_signature && !$this->contract->pdf_path)
            <livewire:central.contracts.generate-pdf :contract="$this->contract" />
        @endif

        @if($this->contract->pdf_path)
            <livewire:central.contracts.send-contract-pdf :contract="$this->contract" />
            <livewire:central.contracts.download-pdf :contract="$this->contract" />
        @endif
    </div>
</div>
