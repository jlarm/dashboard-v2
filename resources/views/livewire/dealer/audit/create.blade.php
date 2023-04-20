<form method="POST" wire:submit.prevent="submit">
    <div class="space-y-5">
        <!-- Oil Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Oil Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input id="email" name="notification-method" type="radio" checked
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="email"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="sms" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="sms" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input id="push" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="push" class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            {{--            <x-media-library-attachment multiple name="media"/>--}}
        </div>
        <!-- Battery Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Battery Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input id="email" name="notification-method" type="radio" checked
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="email"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="sms" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="sms" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input id="push" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="push" class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            {{--            <x-media-library-attachment multiple name="media"/>--}}
        </div>
        <!-- Tire Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Tire Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input id="email" name="notification-method" type="radio" checked
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="email"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="sms" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="sms" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input id="push" name="notification-method" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            <label for="push" class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            {{--            <x-media-library-attachment multiple name="media"/>--}}
        </div>
        <x-primary-button>Submit</x-primary-button>
    </div>
</form>
