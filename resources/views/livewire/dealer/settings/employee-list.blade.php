<div class="bg-white px-4 py-5 sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Employee Information</h3>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
            <form wire:submit.prevent="update">
                <div class="pb-10 space-y-6">
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="qi" class="block text-sm font-medium text-gray-700">Qualified Individual
                                Name</label>
                            <div class="mt-1">
                                <input wire:model="qualified_individual_name" type="text" name="qi" id="qi"
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
                                <input wire:model="qualified_individual_phone" type="tel" name="qip" id="qip"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('qip')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="service_manager_name" class="block text-sm font-medium text-gray-700">Service
                                Manager</label>
                            <div class="mt-1">
                                <input wire:model="service_manager_name" type="text" name="sm" id="sm"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('sm')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="service_manager_phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label>
                            <div class="mt-1">
                                <input wire:model="service_manager_phone" type="tel" name="smp" id="smp"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('service_manager_phone')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="parts_manager_name" class="block text-sm font-medium text-gray-700">Parts
                                Manager</label>
                            <div class="mt-1">
                                <input wire:model="parts_manager_name" type="text" name="pm" id="pm"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('parts_manager_name')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="parts_manager_phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label>
                            <div class="mt-1">
                                <input wire:model="parts_manager_phone" type="tel" name="parts_manager_phone"
                                       id="parts_manager_phone"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('parts_manager_phone')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="body_shop_manager_name" class="block text-sm font-medium text-gray-700">Body
                                Shop
                                Manager</label>
                            <div class="mt-1">
                                <input wire:model="body_shop_manager_name" type="text" name="body_shop_manager_name"
                                       id="body_shop_manager_name"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('body_shop_manager_name')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="body_shop_manager_phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label>
                            <div class="mt-1">
                                <input wire:model="body_shop_manager_phone" type="tel" name="body_shop_manager_phone"
                                       id="body_shop_manager_phone"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('body_shop_manager_phone')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="general_manager_name" class="block text-sm font-medium text-gray-700">General
                                Manager</label>
                            <div class="mt-1">
                                <input wire:model="general_manager_name" type="text" name="general_manager_name"
                                       id="general_manager_name"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('general_manager_name')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="general_manager_phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label>
                            <div class="mt-1">
                                <input wire:model="general_manager_phone" type="tel" name="general_manager_phone"
                                       id="general_manager_phone"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('general_manager_phone')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner</label>
                            <div class="mt-1">
                                <input wire:model="owner_name" type="text" name="owner_name" id="owner_name"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('owner_name')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="owner_phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label>
                            <div class="mt-1">
                                <input wire:model="owner_phone" type="tel" name="owner_phone" id="owner_phone"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                                @error('owner_phone')
                                <p class="mt-2 text-sm text-red-600">This field is required.</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3 text-right">
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
