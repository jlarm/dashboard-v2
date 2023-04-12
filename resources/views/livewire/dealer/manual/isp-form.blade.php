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
