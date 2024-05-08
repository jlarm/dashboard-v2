<div class="w-full max-w-2xl mx-auto">
    <form wire:submit.prevent="create" class="space-y-12">

        <!-- Contract Information -->
        <div class="border-b pb-12">
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <x-input-label for="dealerName" :value="__('Dealership Name *')" />
                    <x-text-input wire:model.defer="dealerName" id="dealerName" class="block mt-1 w-full" type="text" name="dealerName" :value="old('dealerName')" />
                    @error('dealerName')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <x-input-label for="agreementDate" :value="__('Agreement Date *')" />
                    <x-text-input wire:model.defer="agreementDate" id="agreementDate" class="block mt-1 w-full" type="date" name="agreementDate" :value="old('agreementDate')" />
                    @error('agreementDate')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <x-input-label for="commenceDate" :value="__('Commencement Date *')" />
                    <x-text-input wire:model.defer="commenceDate" id="commenceDate" class="block mt-1 w-full" type="date" name="commenceDate" :value="old('commenceDate')" />
                    @error('commenceDate')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <x-input-label for="yearlyInspectionTotal" :value="__('Total Number of Yearly Inspections *')" />
                    <x-text-input wire:model.defer="yearlyInspectionTotal" id="yearlyInspectionTotal" class="block mt-1 w-full" type="number" name="yearlyInspectionTotal" :value="old('yearlyInspectionTotal')" />
                    @error('yearlyInspectionTotal')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <x-input-label for="initialFee" :value="__('Initial Fee *')" />
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
                    <x-input-label for="monthlyFee" :value="__('Monthly Fee *')" />
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
                    <x-input-label for="agreementDate" :value="__('Services *')" />
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
                    @error('services')
                    <div class="text-red-500 text-sm mt-2">
                        {{ __('At least one service is required.') }}
                    </div>
                    @enderror
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

        <!-- Dealership Billing Address -->
        <div>
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
                    <x-text-input x-mask="999-999-9999" wire:model.defer="dealerBillingFax" id="dealerBillingFax" class="block mt-1 w-full" type="text" name="dealerBillingFax" :value="old('dealerBillingFax')" />
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

        <x-primary-button>Submit</x-primary-button>
    </form>
</div>
