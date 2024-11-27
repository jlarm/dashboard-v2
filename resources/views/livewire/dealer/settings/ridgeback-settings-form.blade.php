<div class="max-w-xl mx-auto">
    <form wire:submit.prevent="update" class="space-y-5">
        <div class="flex items-center h-5">
            <input wire:model="active"
                   id="active"
                   type="checkbox" class="hidden peer">
            <label for="active"
                   class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.active]:border-arm-blue-500 peer-checked:[&_.active]:bg-arm-blue-500 select-none flex items-center space-x-2">
                <span
                    class="flex items-center justify-center w-5 h-5 border-2 rounded active text-neutral-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="3"
                         stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                  </svg>
                </span>
                <span>Active</span>
            </label>
        </div>
        <div class="w-full">
            <x-input-label for="ipAddress" :value="__('IP Address')"/>
            <x-text-input
                wire:model.defer="ipAddress"
                id="ipAddress"
                class="block mt-1 w-full"
                type="text"
                placeholder="127.0.0.1"
                :value="old('ipAddress')"
            />
            <x-input-error :messages="$errors->get('ipAddress')" class="mt-2"/>
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
</div>
