<form wire:submit.prevent="submit" class="max-w-3xl mx-auto space-y-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <div wire:ignore>
                <x-date-picker wire:model.lazy="auditDate" label="Audit Date" required />
            </div>
            @error('auditDate')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <div wire:ignore>
                <x-date-picker wire:model.lazy="dateOfDealJacket" label="Date of Deal Jacket" required />
            </div>
            @error('dateOfDealJacket')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input label="Customer Name" type="text" wire:model.defer="customerName" required />
            @error('customerName')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input label="Customer Deal Number" type="text" wire:model.defer="customerDealNumber" required />
            @error('customerDealNumber')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-select label="Finance Manager" wire:model.defer="financeManager" required>
                <option value="">Choose manager...</option>
                @foreach($this->managers() as $manager)
                    <option value="{{ $manager['id'] }}">{{ $manager['name'] }}</option>
                @endforeach
                <option value="house">House</option>
            </x-select>
            @error('financeManager')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input label="Mileage" type="text" wire:model.defer="mileage" required />
            @error('mileage')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <x-select label="Purchase Type" wire:model.lazy="purchaseType" placeholder="Choose purchase type..." required>
                <option></option>
                <option value="cash">Cash</option>
                <option value="finance">Finance</option>
                <option value="lease">Lease</option>
            </x-select>
            @error('purchaseType')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-select label="Vehicle Type" wire:model.lazy="vehicleType" placeholder="Choose vehicle type..." required>
                <option></option>
                <option value="new">New</option>
                <option value="used">Used</option>
            </x-select>
            @error('vehicleType')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="space-y-5">
        @foreach($questions as $question)
            <div class="border p-3 rounded-xl text-sm shadow-sm" x-data="{ answer: '{{ $responses[$loop->index]['answer'] ?? '' }}' }">
                <p>{{ $loop->index + 1 }}. {{ $question['question'] }}</p>
                <div class="flex justify-between items-center mt-4">
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input wire:model.defer="responses.{{ $loop->index }}.high_risk" id="question_{{ $loop->index }}_high_risk" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="question_{{ $loop->index }}_high_risk" class="font-medium text-red-500">Flag as high risk</label>
                        </div>
                    </div>
                    <fieldset>
                        <div class="flex items-center space-x-5">
                            <div class="flex items-center">
                                <input wire:model.defer="responses.{{ $loop->index }}.answer" value="yes" name="question_{{ $loop->index }}_answer" id="question_{{ $loop->index }}_yes" type="radio" class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600" x-model="answer">
                                <label for="question_{{ $loop->index }}_yes" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input wire:model.defer="responses.{{ $loop->index }}.answer" value="no" name="question_{{ $loop->index }}_answer" id="question_{{ $loop->index }}_no" type="radio" class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600" x-model="answer">
                                <label for="question_{{ $loop->index }}_no" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                            <div class="flex items-center">
                                <input wire:model.defer="responses.{{ $loop->index }}.answer" value="na" name="question_{{ $loop->index }}_answer" id="question_{{ $loop->index }}_na" type="radio" class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600" x-model="answer">
                                <label for="question_{{ $loop->index }}_na" class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div x-show="answer === 'no'" x-cloak>
                    <x-textarea class="mt-4" wire:model.defer="responses.{{ $loop->index }}.comment" placeholder="Enter your comment" />
                </div>
                @error('responses.' . $loop->index . '.answer')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
    </div>
    <x-button type="submit" variant="primary">{{ $dealJacket?->exists ? 'Update' : 'Create' }}</x-button>
    <x-button :href="tenant('locations') ? route('dealer.stores.audits.deal-jackets.show', [$store, $dealJacketGroup]) : route('dealer.audit.deal-jackets.show', $dealJacketGroup)">
        Cancel
    </x-button>
</form>
