<div class="max-w-4xl mx-auto">
    <form wire:submit.prevent="update"><div>
            <div class="pt-5">
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input wire:model="phishing_active"
                               id="phishing-sim"
                               type="checkbox" class="hidden peer">
                        <label for="phishing-sim"
                               class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.phishing-sim]:border-arm-blue-500 peer-checked:[&_.phishing-sim]:bg-arm-blue-500 select-none flex items-center space-x-2">
                    <span
                        class="flex items-center justify-center w-5 h-5 border-2 rounded phishing-sim text-neutral-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="3"
                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                      </svg>
                    </span>
                            <span>Phishing Simulations</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="w-full">
                        <x-input-label for="phishing_token" :value="__('Token')"/>
                        <x-text-input wire:model.defer="phishing_token" id="phishing_token" class="block mt-1 w-full" type="text"
                                      :value="old('phishing_token')"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('phishing_token')" class="mt-2"/>
                    </div>
                    <div class="w-full">
                        <x-input-label for="phishing_ip" :value="__('IP Address')"/>
                        <x-text-input wire:model.defer="phishing_ip" id="phishing_ip" class="block mt-1 w-full" type="text"
                                      :value="old('phishing_ip')"
                                      autofocus/>
                        <x-input-error :messages="$errors->get('phishing_ip')" class="mt-2"/>
                    </div>
                </div>
            </div>
            <div class="py-3 text-right">
                <x-primary-button wire:loading.attr="disabled">Update</x-primary-button>
            </div>
        </div>
    </form>
</div>
