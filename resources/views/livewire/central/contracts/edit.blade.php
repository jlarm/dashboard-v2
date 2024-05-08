<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <div class="col-span-2 border rounded-md p-5">
        <form wire:submit.prevent="update" class="space-y-12">
            <!-- Contract Information -->
            <div class="border-b pb-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerName" :value="__('Dealership Name')" />
                        <x-text-input wire:model.defer="dealerName" id="dealerName" class="block mt-1 w-full" type="text" name="dealerName" :value="old('dealerName')" required />
                        @error('dealerName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="agreementDate" :value="__('Agreement Date')" />
                        <x-text-input wire:model.defer="agreementDate" id="agreementDate" class="block mt-1 w-full" type="date" name="agreementDate" :value="old('agreementDate')" required />
                        @error('agreementDate')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <x-input-label for="commenceDate" :value="__('Commencement Date')" />
                        <x-text-input wire:model.defer="commenceDate" id="commenceDate" class="block mt-1 w-full" type="date" name="commenceDate" :value="old('commenceDate')" required />
                        @error('commenceDate')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <x-input-label for="yearlyInspectionTotal" :value="__('Total Number of Yearly Inspections')" />
                        <x-text-input wire:model.defer="yearlyInspectionTotal" id="yearlyInspectionTotal" class="block mt-1 w-full" type="number" name="yearlyInspectionTotal" :value="old('yearlyInspectionTotal')" required />
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
                            <x-text-input x-mask:dynamic="$money($input)" wire:model.defer="initialFee" id="initialFee" class="block mt-1 w-full pl-7" type="text" name="initialFee" :value="old('initialFee')" placeholder="0.00" required />
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
                            <x-text-input x-mask:dynamic="$money($input)" wire:model.defer="monthlyFee" id="monthlyFee" class="block mt-1 w-full pl-7" type="text" name="monthlyFee" :value="old('monthlyFee')" placeholder="0.00" required />
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
                        <x-text-input wire:model.defer="dealerPhysicalAddress" id="dealerPhysicalAddress" class="block mt-1 w-full" type="text" name="dealerPhysicalAddress" :value="old('dealerPhysicalAddress')" required />
                        @error('dealerPhysicalAddress')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalCity" :value="__('City')" />
                        <x-text-input wire:model.defer="dealerPhysicalCity" id="dealerPhysicalCity" class="block mt-1 w-full" type="text" name="dealerPhysicalCity" :value="old('dealerPhysicalCity')" required />
                        @error('dealerPhysicalCity')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalState" :value="__('State')" />
                        <x-text-input wire:model.defer="dealerPhysicalState" id="dealerPhysicalState" class="block mt-1 w-full" type="text" name="dealerPhysicalState" :value="old('dealerPhysicalState')" required />
                        @error('dealerPhysicalState')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerPhysicalZip" :value="__('Zip Code')" />
                        <x-text-input wire:model.defer="dealerPhysicalZip" id="dealerPhysicalZip" class="block mt-1 w-full" type="text" name="dealerPhysicalZip" :value="old('dealerPhysicalZip')" required />
                        @error('dealerPhysicalZip')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerPhone" :value="__('Phone Number')" />
                        <x-text-input x-mask="999-999-9999" wire:model.defer="dealerPhone" id="dealerPhone" class="block mt-1 w-full" type="tel" name="dealerPhone" :value="old('dealerPhone')" required />
                        @error('dealerPhone')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-3">
                        <x-input-label for="dealerQiName" :value="__('Qualified Individual Name')" />
                        <x-text-input wire:model.defer="dealerQiName" id="dealerQiName" class="block mt-1 w-full" type="text" name="dealerQiName" :value="old('dealerQiName')" required />
                        @error('dealerQiName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-3">
                        <x-input-label for="dealerQiEmail" :value="__('Qualified Individual Email Address')" />
                        <x-text-input wire:model.defer="dealerQiEmail" id="dealerQiEmail" class="block mt-1 w-full" type="text" name="dealerQiEmail" :value="old('dealerQiEmail')" required />
                        @error('dealerQiEmail')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Dealership Billing Address -->
            <div class="{{ $this->contract->dealer_signature ? 'border-b pb-12' : '' }}">
                <h2 class="text-base font-semibold leading-7">Dealership Billing Address</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <x-input-label for="dealerBillingAddress" :value="__('Address')" />
                        <x-text-input wire:model.defer="dealerBillingAddress" id="dealerBillingAddress" class="block mt-1 w-full" type="text" name="dealerBillingAddress" :value="old('dealerBillingAddress')" required />
                        @error('dealerBillingAddress')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingCity" :value="__('City')" />
                        <x-text-input wire:model.defer="dealerBillingCity" id="dealerBillingCity" class="block mt-1 w-full" type="text" name="dealerBillingCity" :value="old('dealerBillingCity')" required />
                        @error('dealerBillingCity')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingState" :value="__('State')" />
                        <x-text-input wire:model.defer="dealerBillingState" id="dealerBillingState" class="block mt-1 w-full" type="text" name="dealerBillingState" :value="old('dealerBillingState')" required />
                        @error('dealerBillingState')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingZip" :value="__('Zip Code')" />
                        <x-text-input wire:model.defer="dealerBillingZip" id="dealerBillingZip" class="block mt-1 w-full" type="text" name="dealerBillingZip" :value="old('dealerBillingZip')" required />
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
                        <x-text-input wire:model.defer="dealerBillingContactName" id="dealerBillingContactName" class="block mt-1 w-full" type="text" name="dealerBillingContactName" :value="old('dealerBillingContactName')" required />
                        @error('dealerBillingContactName')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingContactTitle" :value="__('Other Contact Title')" />
                        <x-text-input wire:model.defer="dealerBillingContactTitle" id="dealerBillingContactTitle" class="block mt-1 w-full" type="text" name="dealerBillingContactTitle" :value="old('dealerBillingContactTitle')" required />
                        @error('dealerBillingContactTitle')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="dealerBillingContactEmail" :value="__('Other Contact Email Address')" />
                        <x-text-input wire:model.defer="dealerBillingContactEmail" id="dealerBillingContactEmail" class="block mt-1 w-full" type="text" name="dealerBillingContactEmail" :value="old('dealerBillingContactEmail')" required />
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
                            <img class="border w-96 h-auto" src="{{ global_asset($contract->armp_signature) }}" alt="">
                        @else
                            <x-signature-pad wire:model.defer="armpSignature" id="armpSignature" class="block mt-1 w-full" name="armpSignature" />
                        @endif
                    </div>
                </div>

            </div>
            @endif

            @if(!$this->contract->armp_signature)
                <button type="submit" class="bg-arm-blue-800 hover:bg-arm-blue-700 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Update
                </button>
            @else
                <p class="text-gray-400 italic">*Contract cannot be updated after both parties have signed the contract.</p>
            @endif
        </form>
    </div>
    <div class="space-y-5">
        <div class="border rounded-md p-3 max-h-[300px] overflow-y-auto">
            <h2 class="text-sm font-semibold leading-6 text-gray-900">Activity</h2>
            <ul role="list" class="space-y-6 mt-2">
                @foreach($progress as $a)
                    <li class="relative flex gap-x-4">
                        @if(!$loop->last)
                            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                <div class="w-px bg-gray-200"></div>
                            </div>
                        @endif
                        <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                            <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                        </div>
                        <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                            <span class="font-medium text-gray-900">{{ $a->name }}</span>
                            {{ $a->status }}.
                        </p>
                        <time class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $a->created_at->diffForHumans() }}</time>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="border rounded-md p-3">
            <h2 class="text-sm font-semibold leading-6 text-gray-900">Checklist</h2>
            <ul class="divide-y divide-gray-100">
                <li class="flex justify-between gap-x-6 py-3">
                    <div class="flex items-center gap-x-3">
                        @if(in_array(1, $this->progress()))
                            <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @else
                            <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @endif
                        <h2 class="min-w-0 text-sm leading-6">
                            Create Contract
                        </h2>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-3">
                    <div class="flex items-center gap-x-3">
                        @if(in_array(2, $this->progress()))
                            <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @else
                            <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @endif
                        <h2 class="min-w-0 text-sm leading-6">
                            Contract sent for review
                        </h2>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-3">
                    <div class="flex items-center gap-x-3">
                        @if(in_array(3, $this->progress()))
                            <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @else
                            <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @endif
                        <h2 class="min-w-0 text-sm leading-6">
                            Contract signed by Dealer
                        </h2>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-3">
                    <div class="flex items-center gap-x-3">
                        @if(in_array(4, $this->progress()))
                            <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @else
                            <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @endif
                        <h2 class="min-w-0 text-sm leading-6">
                            Contract signed by ARMP
                        </h2>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-3">
                    <div class="flex items-center gap-x-3">
                        @if(in_array(5, $this->progress()))
                            <span>🎉</span>
                        @else
                            <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                                <div class="h-2 w-2 rounded-full bg-current"></div>
                            </div>
                        @endif
                        <h2 class="min-w-0 text-sm leading-6">
                            Contract approved and completed
                        </h2>
                    </div>
                </li>
            </ul>
        </div>

        @if(!$this->contract->dealer_signature)
        <livewire:central.contracts.send-contract :contract="$this->contract" :key="$this->contract->id" />
        @endif

        @if($this->contract->dealer_signature && $this->contract->armp_signature)
            <livewire:central.contracts.send-contract-pdf :contract="$this->contract" :key="$this->contract->id" />
        @endif
    </div>
</div>
