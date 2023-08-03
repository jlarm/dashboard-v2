<x-wire-elements-pro::tailwind.modal on-submit="create" :content-padding="true">
    <x-slot name="title">Create New Event</x-slot>

    <div class="space-y-5">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Event Name*')"/>
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <!-- Start Date -->
            <div>
                <x-input-label for="startDate" :value="__('Start Date*')"/>
                <x-text-input wire:model.defer="startDate" id="startDate" class="block mt-1 w-full" type="date"
                              name="startDate"
                              :value="old('startDate')" required/>
                <x-input-error :messages="$errors->get('startDate')" class="mt-2"/>
            </div>
            <!-- End Date -->
            <div>
                <x-input-label for="endDate" :value="__('End Date*')"/>
                <x-text-input wire:model.defer="endDate" id="endDate" class="block mt-1 w-full" type="date"
                              name="endDate"
                              :value="old('endDate')" required/>
                <x-input-error :messages="$errors->get('endDate')" class="mt-2"/>
            </div>
        </div>

        <!-- Location Name -->
        <div>
            <x-input-label for="locationName" :value="__('Location Name')"/>
            <x-text-input wire:model.defer="locationName" id="locationName" class="block mt-1 w-full" type="text"
                          name="locationName"
                          :value="old('locationName')"/>
            <x-input-error :messages="$errors->get('locationName')" class="mt-2"/>
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')"/>
            <x-text-input wire:model.defer="address" id="address" class="block mt-1 w-full" type="text"
                          name="address"
                          :value="old('address')"/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div>
                <x-input-label for="city" :value="__('City')"/>
                <x-text-input wire:model.defer="city" id="city" class="block mt-1 w-full" type="text"
                              name="city"
                              :value="old('city')"/>
                <x-input-error :messages="$errors->get('city')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="state" :value="__('State')"/>
                <x-text-input wire:model.defer="state" id="state" class="block mt-1 w-full" type="text"
                              name="state"
                              :value="old('state')"/>
                <x-input-error :messages="$errors->get('state')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="zipCode" :value="__('Zip Code')"/>
                <x-text-input wire:model.defer="zipCode" id="zipCode" class="block mt-1 w-full" type="text"
                              name="zipCode"
                              :value="old('zipCode')"/>
                <x-input-error :messages="$errors->get('zipCode')" class="mt-2"/>
            </div>
        </div>

        <div>
            <x-input-label for="link" :value="__('Link')"/>
            <x-text-input wire:model.defer="link" id="link" class="block mt-1 w-full" type="url"
                          placeholder="https://www.example.com"
                          name="link"
                          :value="old('link')"/>
            <x-input-error :messages="$errors->get('link')" class="mt-2"/>
        </div>

    </div>

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Submit
        </button>
        <button
            type="button"
            wire:click="$emit('modal.close')"
            class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
