<form method="POST" wire:submit.prevent="submit">
    <div class="space-y-5">
        <!-- 1 Oil Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Oil Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q1_answer"
                                value="1"
                                name="osha_q1_answer"
                                id="osha_q1_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q1_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q1_answer"
                                value="2"
                                name="osha_q1_answer"
                                id="osha_q1_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q1_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q1_answer"
                                value="3"
                                name="osha_q1_answer"
                                id="osha_q1_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q1_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q1_comment" id="osha_q1_comment" name="osha_q1_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q1_images"/>
        </div>
        <!-- 2 Battery Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Battery Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q2_answer"
                                value="1"
                                name="osha_q2_answer"
                                id="osha_q2_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q2_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q2_answer"
                                value="2"
                                name="osha_q2_answer"
                                id="osha_q2_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q2_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q2_answer"
                                value="3"
                                name="osha_q2_answer"
                                id="osha_q2_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q2_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q2_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q2_images"/>
        </div>
        <!-- 3 Tire Manifest -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Tire Manifest</label>
                <fieldset class="mt-4">
                    <legend class="sr-only">Notification method</legend>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q3_answer"
                                value="1"
                                name="osha_q3_answer"
                                id="osha_q3_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q3_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q3_answer"
                                value="2"
                                name="osha_q3_answer"
                                id="osha_q3_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q3_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q3_answer"
                                value="3"
                                name="osha_q3_answer"
                                id="osha_q3_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q3_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q3_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q3_images"/>
        </div>
        <!-- 4 Forklift Operators certifications -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Forklift Operators certifications</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q4_answer"
                                value="1"
                                name="osha_q4_answer"
                                id="osha_q4_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q4_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q4_answer"
                                value="2"
                                name="osha_q4_answer"
                                id="osha_q4_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q4_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q4_answer"
                                value="3"
                                name="osha_q4_answer"
                                id="osha_q4_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q4_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q4_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q4_images"/>
        </div>
        <!-- 5 Review OSHA 300 -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Review OSHA 300 & was OSHA 300A
                    - Annual Summary posted and up-loaded</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q5_answer"
                                value="1"
                                name="osha_q5_answer"
                                id="osha_q5_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q5_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q5_answer"
                                value="2"
                                name="osha_q5_answer"
                                id="osha_q5_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q5_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q5_answer"
                                value="3"
                                name="osha_q5_answer"
                                id="osha_q5_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q5_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q5_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q5_images"/>
        </div>
        <!-- 6 Hybrid - Vehicle Training -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid - Vehicle Training Certification
                    –up-load</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q6_answer"
                                value="1"
                                name="osha_q6_answer"
                                id="osha_q6_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q6_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q6_answer"
                                value="2"
                                name="osha_q6_answer"
                                id="osha_q6_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q6_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q6_answer"
                                value="3"
                                name="osha_q6_answer"
                                id="osha_q6_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q6_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q6_images"/>
        </div>
        <!-- 7 Hybrid - Handling of “High-Voltage Batteries” -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid - Handling of “High-Voltage
                    Batteries”</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q7_answer"
                                value="1"
                                name="osha_q7_answer"
                                id="osha_q7_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q7_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q7_answer"
                                value="2"
                                name="osha_q7_answer"
                                id="osha_q7_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q7_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q7_answer"
                                value="3"
                                name="osha_q7_answer"
                                id="osha_q7_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q7_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q7_images"/>
        </div>
        <!-- 8 SPCC filing -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">SPCC filing</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q8_answer"
                                value="1"
                                name="osha_q8_answer"
                                id="osha_q8_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q8_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q8_answer"
                                value="2"
                                name="osha_q8_answer"
                                id="osha_q8_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q8_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q8_answer"
                                value="3"
                                name="osha_q8_answer"
                                id="osha_q8_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q8_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q8_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q8_images"/>
        </div>
        <!-- 9 Any other State or Local EPA filings to upload? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Any other State or Local EPA filings to
                    upload</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q9_answer"
                                value="1"
                                name="osha_q9_answer"
                                id="osha_q9_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q9_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q9_answer"
                                value="2"
                                name="osha_q9_answer"
                                id="osha_q9_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q9_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q9_answer"
                                value="3"
                                name="osha_q9_answer"
                                id="osha_q9_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q9_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q9_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q9_images"/>
        </div>
        <!-- 10 Do all employees know how to access SDS’s? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do all employees know how to access SDS’s?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q10_answer"
                                value="1"
                                name="osha_q10_answer"
                                id="osha_q10_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q10_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q10_answer"
                                value="2"
                                name="osha_q10_answer"
                                id="osha_q10_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q10_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q10_answer"
                                value="3"
                                name="osha_q10_answer"
                                id="osha_q10_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q10_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q10_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q10_images"/>
        </div>
        <!-- 11 Has there been any employee exposed to a spill of a chemical since last visit? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has there been any employee exposed to a spill of a
                    chemical since last visit?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q11_answer"
                                value="1"
                                name="osha_q11_answer"
                                id="osha_q11_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q11_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q11_answer"
                                value="2"
                                name="osha_q11_answer"
                                id="osha_q11_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q11_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q11_answer"
                                value="3"
                                name="osha_q11_answer"
                                id="osha_q11_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q11_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q11_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q11_images"/>
        </div>
        <!-- 12 Are all products that are in containers other than the original properly labeled with product NAME, MFG, and appropriate hazard warning? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all products that are in containers other than
                    the original properly labeled with product NAME, MFG, and appropriate hazard warning? </label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q12_answer"
                                value="1"
                                name="osha_q12_answer"
                                id="osha_q12_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q12_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q12_answer"
                                value="2"
                                name="osha_q12_answer"
                                id="osha_q12_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q12_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q12_answer"
                                value="3"
                                name="osha_q12_answer"
                                id="osha_q12_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q12_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q12_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q12_images"/>
        </div>
        <!-- 13 Have there been any accidents since last visit? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have there been any accidents since last
                    visit?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q13_answer"
                                value="1"
                                name="osha_q13_answer"
                                id="osha_q13_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q13_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q13_answer"
                                value="2"
                                name="osha_q13_answer"
                                id="osha_q13_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q13_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q13_answer"
                                value="3"
                                name="osha_q13_answer"
                                id="osha_q13_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q13_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q13_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q13_images"/>
        </div>
        <!-- 14 Is the eye wash equipment readily accessible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the eye wash equipment readily
                    accessible?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q14_answer"
                                value="1"
                                name="osha_q14_answer"
                                id="osha_q14_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q14_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q14_answer"
                                value="2"
                                name="osha_q14_answer"
                                id="osha_q14_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q14_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q14_answer"
                                value="3"
                                name="osha_q14_answer"
                                id="osha_q14_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q14_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q14_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q14_images"/>
        </div>
        <!-- 15 Has the eye wash equipment been tested and cleaned and documented weekly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has the eye wash equipment been tested and cleaned
                    and documented weekly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q15_answer"
                                value="1"
                                name="osha_q15_answer"
                                id="osha_q15_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q15_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q15_answer"
                                value="2"
                                name="osha_q15_answer"
                                id="osha_q15_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q15_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q15_answer"
                                value="3"
                                name="osha_q15_answer"
                                id="osha_q15_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q15_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q15_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q15_images"/>
        </div>
        <!-- 16 How often is the water/solution changed and documented in the eye wash equipment? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">How often is the water/solution changed and
                    documented in the eye wash equipment?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q16_answer"
                                value="1"
                                name="osha_q16_answer"
                                id="osha_q16_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q16_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q16_answer"
                                value="2"
                                name="osha_q16_answer"
                                id="osha_q16_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q16_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q16_answer"
                                value="3"
                                name="osha_q16_answer"
                                id="osha_q16_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q16_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q16_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q16_images"/>
        </div>
        <!-- 17 DOT certification - Is the person responsible for Hazardous material shipping current on his/her? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">DOT certification - Is the person responsible for
                    Hazardous material shipping current on his/her?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q17_answer"
                                value="1"
                                name="osha_q17_answer"
                                id="osha_q17_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q17_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q17_answer"
                                value="2"
                                name="osha_q17_answer"
                                id="osha_q17_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q17_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q17_answer"
                                value="3"
                                name="osha_q17_answer"
                                id="osha_q17_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q17_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q17_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q17_images"/>
        </div>
        <!-- 18 Are all the Fire Extinguishers easily accessible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">DOT certification - Is the person responsible for
                    Hazardous material shipping current on his/her?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q18_answer"
                                value="1"
                                name="osha_q18_answer"
                                id="osha_q18_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q18_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q18_answer"
                                value="2"
                                name="osha_q18_answer"
                                id="osha_q18_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q18_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q18_answer"
                                value="3"
                                name="osha_q18_answer"
                                id="osha_q18_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q18_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q18_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q18_images"/>
        </div>
        <!-- 19 Have the fire extinguishers had their annual inspection and are they properly identified and fully charged? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have the fire extinguishers had their annual
                    inspection and are they properly identified and fully charged?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q19_answer"
                                value="1"
                                name="osha_q19_answer"
                                id="osha_q19_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q19_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q19_answer"
                                value="2"
                                name="osha_q19_answer"
                                id="osha_q19_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q19_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q19_answer"
                                value="3"
                                name="osha_q19_answer"
                                id="osha_q19_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q19_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q19_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q19_images"/>
        </div>
        <!-- 20 Are extinguishers mounted properly? (36”-60”) -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are extinguishers mounted properly?
                    (36”-60”) </label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q20_answer"
                                value="1"
                                name="osha_q20_answer"
                                id="osha_q20_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q20_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q20_answer"
                                value="2"
                                name="osha_q20_answer"
                                id="osha_q20_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q20_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q20_answer"
                                value="3"
                                name="osha_q20_answer"
                                id="osha_q20_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q20_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q20_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q20_images"/>
        </div>
        <!-- 21 Are Signs posted properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are Signs posted properly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q21_answer"
                                value="1"
                                name="osha_q21_answer"
                                id="osha_q21_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q21_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q21_answer"
                                value="2"
                                name="osha_q21_answer"
                                id="osha_q21_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q21_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q21_answer"
                                value="3"
                                name="osha_q21_answer"
                                id="osha_q21_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q21_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q21_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q21_images"/>
        </div>
        <!-- 22 Are all hoses and cutting tips for the welder / cutting torches in good condition without any cracks or breaks? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all hoses and cutting tips for the welder /
                    cutting torches in good condition without any cracks or breaks?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q22_answer"
                                value="1"
                                name="osha_q22_answer"
                                id="osha_q22_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q22_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q22_answer"
                                value="2"
                                name="osha_q22_answer"
                                id="osha_q22_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q22_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q22_answer"
                                value="3"
                                name="osha_q22_answer"
                                id="osha_q22_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q22_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q22_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q22_images"/>
        </div>
        <!-- 23 Do you have any forklift(s)? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do you have any forklift(s)?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q23_answer"
                                value="1"
                                name="osha_q23_answer"
                                id="osha_q23_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q23_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q23_answer"
                                value="2"
                                name="osha_q23_answer"
                                id="osha_q23_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q23_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q23_answer"
                                value="3"
                                name="osha_q23_answer"
                                id="osha_q23_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q23_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q23_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q23_images"/>
        </div>
        <!-- 24 If you have a forklift, has the person(s) responsible for operating it been properly trained on safety and signed off as such? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">If you have a forklift, has the person(s)
                    responsible for operating it been properly trained on safety and signed off as such?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q24_answer"
                                value="1"
                                name="osha_q24_answer"
                                id="osha_q24_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q24_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q24_answer"
                                value="2"
                                name="osha_q24_answer"
                                id="osha_q24_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q24_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q24_answer"
                                value="3"
                                name="osha_q24_answer"
                                id="osha_q24_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q24_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q24_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q24_images"/>
        </div>
        <!-- 25 Do you have forklift training certificates of completed training class(es)? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do you have forklift training certificates of
                    completed training class(es)?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q25_answer"
                                value="1"
                                name="osha_q25_answer"
                                id="osha_q25_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q25_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q25_answer"
                                value="2"
                                name="osha_q25_answer"
                                id="osha_q25_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q25_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q25_answer"
                                value="3"
                                name="osha_q25_answer"
                                id="osha_q25_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q25_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q25_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q25_images"/>
        </div>
        <!-- 26 Do forklifts have a seat belt/safety harness? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do forklifts have a seat belt/safety
                    harness?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q26_answer"
                                value="1"
                                name="osha_q26_answer"
                                id="osha_q26_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q26_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q26_answer"
                                value="2"
                                name="osha_q26_answer"
                                id="osha_q26_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q26_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q26_answer"
                                value="3"
                                name="osha_q26_answer"
                                id="osha_q26_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q26_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q26_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q26_images"/>
        </div>
        <!-- 27 Does the forklift have legible labels?   i.e., ANSI, serial #, maximum lift capacity -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Does the forklift have legible labels?
                    i.e., ANSI, serial #, maximum lift capacity</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q27_answer"
                                value="1"
                                name="osha_q27_answer"
                                id="osha_q27_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q27_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q27_answer"
                                value="2"
                                name="osha_q27_answer"
                                id="osha_q27_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q27_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q27_answer"
                                value="3"
                                name="osha_q27_answer"
                                id="osha_q27_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q27_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q27_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q27_images"/>
        </div>
        <!-- 28 Are all exits properly marked? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Does the forklift have legible labels?
                    i.e., ANSI, serial #, maximum lift capacity</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q28_answer"
                                value="1"
                                name="osha_q28_answer"
                                id="osha_q28_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q28_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q28_answer"
                                value="2"
                                name="osha_q28_answer"
                                id="osha_q28_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q28_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q28_answer"
                                value="3"
                                name="osha_q28_answer"
                                id="osha_q28_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q28_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q28_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q28_images"/>
        </div>
        <!-- 29 Are pathways to exits clear of obstructions? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are pathways to exits clear of
                    obstructions?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q29_answer"
                                value="1"
                                name="osha_q29_answer"
                                id="osha_q29_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q29_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q29_answer"
                                value="2"
                                name="osha_q29_answer"
                                id="osha_q29_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q29_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q29_answer"
                                value="3"
                                name="osha_q29_answer"
                                id="osha_q29_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q29_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q29_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q29_images"/>
        </div>
        <!-- 30 Are all aisles/pathways, stairways and landings free from obstructions? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all aisles/pathways, stairways and landings
                    free from obstructions?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q30_answer"
                                value="1"
                                name="osha_q30_answer"
                                id="osha_q30_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q30_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q30_answer"
                                value="2"
                                name="osha_q30_answer"
                                id="osha_q30_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q30_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q30_answer"
                                value="3"
                                name="osha_q30_answer"
                                id="osha_q30_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q30_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q30_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q30_images"/>
        </div>
        <!-- 31 Are any doorways that are nonfunctioning or blocked marked by a sign stating “NO EXIT”? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are any doorways that are nonfunctioning or blocked
                    marked by a sign stating “NO EXIT”?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q31_answer"
                                value="1"
                                name="osha_q31_answer"
                                id="osha_q31_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q31_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q31_answer"
                                value="2"
                                name="osha_q31_answer"
                                id="osha_q31_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q31_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q31_answer"
                                value="3"
                                name="osha_q31_answer"
                                id="osha_q31_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q31_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q31_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q31_images"/>
        </div>
        <!-- 32 Are the shop areas kept clean and orderly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the shop areas kept clean and orderly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q32_answer"
                                value="1"
                                name="osha_q32_answer"
                                id="osha_q32_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q32_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q32_answer"
                                value="2"
                                name="osha_q32_answer"
                                id="osha_q32_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q32_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q32_answer"
                                value="3"
                                name="osha_q32_answer"
                                id="osha_q32_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q32_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q32_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q32_images"/>
        </div>
        <!-- 33 Are all flammable materials (oily shop rags) properly stored? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all flammable materials (oily shop rags)
                    properly stored?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q33_answer"
                                value="1"
                                name="osha_q33_answer"
                                id="osha_q33_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q33_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q33_answer"
                                value="2"
                                name="osha_q33_answer"
                                id="osha_q33_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q33_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q33_answer"
                                value="3"
                                name="osha_q33_answer"
                                id="osha_q33_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q33_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q33_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q33_images"/>
        </div>
        <!-- 34 Are floors in good repair and free from obstruction and debris and slippery conditions? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are floors in good repair and free from obstruction
                    and debris and slippery conditions?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q34_answer"
                                value="1"
                                name="osha_q34_answer"
                                id="osha_q34_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q34_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q34_answer"
                                value="2"
                                name="osha_q34_answer"
                                id="osha_q34_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q34_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q34_answer"
                                value="3"
                                name="osha_q34_answer"
                                id="osha_q34_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q34_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q34_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q34_images"/>
        </div>
        <!-- 35 Are floor openings in excess of 2.25” wide covered with hinged flaps? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are floor openings in excess of 2.25” wide covered
                    with hinged flaps?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q35_answer"
                                value="1"
                                name="osha_q35_answer"
                                id="osha_q35_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q35_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q35_answer"
                                value="2"
                                name="osha_q35_answer"
                                id="osha_q35_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q35_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q35_answer"
                                value="3"
                                name="osha_q35_answer"
                                id="osha_q35_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q35_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q35_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q35_images"/>
        </div>
        <!-- 36 Are employees properly maintaining their hoist controls and not bypassing any automatic safety features? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are employees properly maintaining their hoist
                    controls and not bypassing any automatic safety features? </label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q36_answer"
                                value="1"
                                name="osha_q36_answer"
                                id="osha_q36_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q36_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q36_answer"
                                value="2"
                                name="osha_q36_answer"
                                id="osha_q36_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q36_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q36_answer"
                                value="3"
                                name="osha_q36_answer"
                                id="osha_q36_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q36_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q36_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q36_images"/>
        </div>
        <!-- 37 Are hoists maintained within mfg. specs, and inspected and serviced AND documented under the mfg. suggested frequency? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are hoists maintained within mfg. specs, and
                    inspected and serviced AND documented under the mfg. suggested frequency?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q37_answer"
                                value="1"
                                name="osha_q37_answer"
                                id="osha_q37_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q37_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q37_answer"
                                value="2"
                                name="osha_q37_answer"
                                id="osha_q37_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q37_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q37_answer"
                                value="3"
                                name="osha_q37_answer"
                                id="osha_q37_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q37_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q37_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q37_images"/>
        </div>
        <!-- 38 Are used batteries stored on a leak proof container? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are used batteries stored on a leak proof
                    container?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q38_answer"
                                value="1"
                                name="osha_q38_answer"
                                id="osha_q38_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q38_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q38_answer"
                                value="2"
                                name="osha_q38_answer"
                                id="osha_q38_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q38_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q38_answer"
                                value="3"
                                name="osha_q38_answer"
                                id="osha_q38_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q38_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q38_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q38_images"/>
        </div>
        <!-- 39 Are any batteries stored outside? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are any batteries stored outside?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q39_answer"
                                value="1"
                                name="osha_q39_answer"
                                id="osha_q39_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q39_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q39_answer"
                                value="2"
                                name="osha_q39_answer"
                                id="osha_q39_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q39_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q39_answer"
                                value="3"
                                name="osha_q39_answer"
                                id="osha_q39_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q39_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q39_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q39_images"/>
        </div>
        <!-- 40 Do automatic sprinkler heads have an 18” clearance? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do automatic sprinkler heads have an 18”
                    clearance?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q40_answer"
                                value="1"
                                name="osha_q40_answer"
                                id="osha_q40_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q40_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q40_answer"
                                value="2"
                                name="osha_q40_answer"
                                id="osha_q40_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q40_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q40_answer"
                                value="3"
                                name="osha_q40_answer"
                                id="osha_q40_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q40_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q40_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q40_images"/>
        </div>
        <!-- 41 Are all portable gas containers UL of FM approved? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all portable gas containers UL of FM
                    approved?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q41_answer"
                                value="1"
                                name="osha_q41_answer"
                                id="osha_q41_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q41_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q41_answer"
                                value="2"
                                name="osha_q41_answer"
                                id="osha_q41_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q41_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q41_answer"
                                value="3"
                                name="osha_q41_answer"
                                id="osha_q41_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q41_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q41_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q41_images"/>
        </div>
        <!-- 42 Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair) working condition? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are compressed air hoses in safe (no frays, cuts,
                    tape or clamps for repair) working condition?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q42_answer"
                                value="1"
                                name="osha_q42_answer"
                                id="osha_q42_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q42_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q42_answer"
                                value="2"
                                name="osha_q42_answer"
                                id="osha_q42_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q42_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q42_answer"
                                value="3"
                                name="osha_q42_answer"
                                id="osha_q42_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q42_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q42_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q42_images"/>
        </div>
        <!-- 43 Are all gas cylinders stored properly tied down? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all gas cylinders stored properly tied
                    down?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q43_answer"
                                value="1"
                                name="osha_q43_answer"
                                id="osha_q43_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q43_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q43_answer"
                                value="2"
                                name="osha_q43_answer"
                                id="osha_q43_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q43_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q43_answer"
                                value="3"
                                name="osha_q43_answer"
                                id="osha_q43_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q43_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q43_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q43_images"/>
        </div>
        <!-- 44 Are gas cylinders stored away from sources of heat or electricity and at least 20’ away from combustible materials? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are gas cylinders stored away from sources of heat
                    or electricity and at least 20’ away from combustible materials?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q44_answer"
                                value="1"
                                name="osha_q44_answer"
                                id="osha_q44_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q44_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q44_answer"
                                value="2"
                                name="osha_q44_answer"
                                id="osha_q44_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q44_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q44_answer"
                                value="3"
                                name="osha_q44_answer"
                                id="osha_q44_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q44_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q44_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q44_images"/>
        </div>
        <!-- 45 Are goggles or face shields always worn when grinding? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are goggles or face shields always worn when
                    grinding?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q45_answer"
                                value="1"
                                name="osha_q45_answer"
                                id="osha_q45_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q45_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q45_answer"
                                value="2"
                                name="osha_q45_answer"
                                id="osha_q45_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q45_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q45_answer"
                                value="3"
                                name="osha_q45_answer"
                                id="osha_q45_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q45_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q45_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q45_images"/>
        </div>
        <!-- 46 Is there proper spacing on grinders; -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there proper spacing on grinders; Tool rest 1/8”
                    from grinding wheel. Tongue plate 1/4” from grinding wheel.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q46_answer"
                                value="1"
                                name="osha_q46_answer"
                                id="osha_q46_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q46_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q46_answer"
                                value="2"
                                name="osha_q46_answer"
                                id="osha_q46_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q46_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q46_answer"
                                value="3"
                                name="osha_q46_answer"
                                id="osha_q46_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q46_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q46_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q46_images"/>
        </div>
        <!-- 47 Is there proper signage about not smoking in the appropriate areas? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there proper signage about not smoking in the
                    appropriate areas?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q47_answer"
                                value="1"
                                name="osha_q47_answer"
                                id="osha_q47_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q47_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q47_answer"
                                value="2"
                                name="osha_q47_answer"
                                id="osha_q47_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q47_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q47_answer"
                                value="3"
                                name="osha_q47_answer"
                                id="osha_q47_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q47_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q47_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q47_images"/>
        </div>
        <!-- 48 Are the no smoking areas being enforced? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the no smoking areas being enforced?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q48_answer"
                                value="1"
                                name="osha_q48_answer"
                                id="osha_q48_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q48_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q48_answer"
                                value="2"
                                name="osha_q48_answer"
                                id="osha_q48_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q48_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q48_answer"
                                value="3"
                                name="osha_q48_answer"
                                id="osha_q48_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q48_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q48_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q48_images"/>
        </div>
        <!-- 49 Air compressors marked with Automatic on/off signage? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Air compressors marked with Automatic on/off
                    signage?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q49_answer"
                                value="1"
                                name="osha_q49_answer"
                                id="osha_q49_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q49_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q49_answer"
                                value="2"
                                name="osha_q49_answer"
                                id="osha_q49_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q49_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q49_answer"
                                value="3"
                                name="osha_q49_answer"
                                id="osha_q49_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q49_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q49_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q49_images"/>
        </div>
        <!-- 50 Are all tanks holding flammable material properly grounded? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all tanks holding flammable material properly
                    grounded?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q50_answer"
                                value="1"
                                name="osha_q50_answer"
                                id="osha_q50_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q50_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q50_answer"
                                value="2"
                                name="osha_q50_answer"
                                id="osha_q50_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q50_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q50_answer"
                                value="3"
                                name="osha_q50_answer"
                                id="osha_q50_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q50_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q50_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q50_images"/>
        </div>
        <!-- 51 Is there clear access of at least 36” to all electrical panels? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there clear access of at least 36” to all
                    electrical panels?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q51_answer"
                                value="1"
                                name="osha_q51_answer"
                                id="osha_q51_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q51_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q51_answer"
                                value="2"
                                name="osha_q51_answer"
                                id="osha_q51_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q51_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q51_answer"
                                value="3"
                                name="osha_q51_answer"
                                id="osha_q51_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q51_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q51_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q51_images"/>
        </div>
        <!-- 52 Are all the breakers properly labeled? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all the breakers properly labeled?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q52_answer"
                                value="1"
                                name="osha_q52_answer"
                                id="osha_q52_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q52_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q52_answer"
                                value="2"
                                name="osha_q52_answer"
                                id="osha_q52_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q52_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q52_answer"
                                value="3"
                                name="osha_q52_answer"
                                id="osha_q52_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q52_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q52_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q52_images"/>
        </div>
        <!-- 53 Are there any extension cords being used improperly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are there any extension cords being used
                    improperly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q53_answer"
                                value="1"
                                name="osha_q53_answer"
                                id="osha_q53_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q53_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q53_answer"
                                value="2"
                                name="osha_q53_answer"
                                id="osha_q53_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q53_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q53_answer"
                                value="3"
                                name="osha_q53_answer"
                                id="osha_q53_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q53_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q53_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q53_images"/>
        </div>
        <!-- 54 Are any electrical cords frayed, cracked, taped, or spliced or ground missing on 3 prong plugs? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are any electrical cords frayed, cracked, taped, or
                    spliced or ground missing on 3 prong plugs?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q54_answer"
                                value="1"
                                name="osha_q54_answer"
                                id="osha_q54_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q54_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q54_answer"
                                value="2"
                                name="osha_q54_answer"
                                id="osha_q54_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q54_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q54_answer"
                                value="3"
                                name="osha_q54_answer"
                                id="osha_q54_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q54_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q54_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q54_images"/>
        </div>
        <!-- 55 Are the fluorescent tubes stored properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the fluorescent tubes stored properly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q55_answer"
                                value="1"
                                name="osha_q55_answer"
                                id="osha_q55_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q55_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q55_answer"
                                value="2"
                                name="osha_q55_answer"
                                id="osha_q55_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q55_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q55_answer"
                                value="3"
                                name="osha_q55_answer"
                                id="osha_q55_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q55_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q55_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q55_images"/>
        </div>
        <!-- 56 Miscellaneous Electrical issues? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Miscellaneous Electrical issues?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q56_answer"
                                value="1"
                                name="osha_q56_answer"
                                id="osha_q56_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q56_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q56_answer"
                                value="2"
                                name="osha_q56_answer"
                                id="osha_q56_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q56_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q56_answer"
                                value="3"
                                name="osha_q56_answer"
                                id="osha_q56_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q56_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q56_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q56_images"/>
        </div>
        <!-- 57 Miscellaneous issues? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Miscellaneous issues?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q57_answer"
                                value="1"
                                name="osha_q57_answer"
                                id="osha_q57_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q57_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q57_answer"
                                value="2"
                                name="osha_q57_answer"
                                id="osha_q57_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q57_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q57_answer"
                                value="3"
                                name="osha_q57_answer"
                                id="osha_q57_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q57_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q57_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q57_images"/>
        </div>
        <!-- 58 Hybrid - Safety Gloves: -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid - Safety Gloves: “Class O Heavy-Duty gloves”
                    rated to withstand 1,000 volts.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q58_answer"
                                value="1"
                                name="osha_q58_answer"
                                id="osha_q58_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q58_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q58_answer"
                                value="2"
                                name="osha_q58_answer"
                                id="osha_q58_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q58_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q58_answer"
                                value="3"
                                name="osha_q58_answer"
                                id="osha_q58_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q58_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q58_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q58_images"/>
        </div>
        <!-- 59 Hybrid - Are the gloves in good condition?  Are there any cracks visible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid - Are the gloves in good condition? Are
                    there any cracks visible?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q59_answer"
                                value="1"
                                name="osha_q59_answer"
                                id="osha_q59_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q59_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q59_answer"
                                value="2"
                                name="osha_q59_answer"
                                id="osha_q59_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q59_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q59_answer"
                                value="3"
                                name="osha_q59_answer"
                                id="osha_q59_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q59_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q59_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q59_images"/>
        </div>
        <!-- 60 Hybrid - Safety Glasses Are safety glasses worn when working on hybrid vehicle? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid - Safety Glasses
                    Are safety glasses worn when working on hybrid vehicle?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q60_answer"
                                value="1"
                                name="osha_q60_answer"
                                id="osha_q60_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q60_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q60_answer"
                                value="2"
                                name="osha_q60_answer"
                                id="osha_q60_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q60_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q60_answer"
                                value="3"
                                name="osha_q60_answer"
                                id="osha_q60_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q60_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q60_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q60_images"/>
        </div>
        <!-- 61 Is the first aid kit identified and accessible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the first aid kit identified and is it stocked
                    with appropriate supplies? i.e., absorbent compress, adhesive bandages, adhesive tape, antiseptic,
                    burn treatment, medical exam gloves, sterile pads, triangular bandages. Recommend that the first aid
                    kits be mounted and visible for all personnel to see.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q61_answer"
                                value="1"
                                name="osha_q61_answer"
                                id="osha_q61_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q61_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q61_answer"
                                value="2"
                                name="osha_q61_answer"
                                id="osha_q61_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q61_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q61_answer"
                                value="3"
                                name="osha_q61_answer"
                                id="osha_q61_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q61_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q61_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q61_images"/>
        </div>
        <!-- 62 Does dealership have elevators? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Does dealership have elevators?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q62_answer"
                                value="1"
                                name="osha_q62_answer"
                                id="osha_q62_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q62_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q62_answer"
                                value="2"
                                name="osha_q62_answer"
                                id="osha_q62_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q62_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q62_answer"
                                value="3"
                                name="osha_q62_answer"
                                id="osha_q62_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q62_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q62_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q62_images"/>
        </div>
        <!-- 63 Has elevator been inspected? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has elevator been inspected?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q63_answer"
                                value="1"
                                name="osha_q63_answer"
                                id="osha_q63_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q63_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q63_answer"
                                value="2"
                                name="osha_q63_answer"
                                id="osha_q63_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q63_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q63_answer"
                                value="3"
                                name="osha_q63_answer"
                                id="osha_q63_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q63_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q63_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q63_images"/>
        </div>
        <!-- 64 When was the last inspection date? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">When was the last inspection date?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q64_answer"
                                value="1"
                                name="osha_q64_answer"
                                id="osha_q64_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q64_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q64_answer"
                                value="2"
                                name="osha_q64_answer"
                                id="osha_q64_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q64_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q64_answer"
                                value="3"
                                name="osha_q64_answer"
                                id="osha_q64_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q64_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q64_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q64_images"/>
        </div>
        <!-- 65 Fluorescent Tubes not being properly stored -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Fluorescent Tubes not being properly stored</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q65_answer"
                                value="1"
                                name="osha_q65_answer"
                                id="osha_q65_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q65_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q65_answer"
                                value="2"
                                name="osha_q65_answer"
                                id="osha_q65_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q65_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q65_answer"
                                value="3"
                                name="osha_q65_answer"
                                id="osha_q65_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q65_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q65_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q65_images"/>
        </div>
        <!-- 66 Electrical panels: (clear access of at least 36”) -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Electrical panels: (clear access of at least
                    36”)</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q66_answer"
                                value="1"
                                name="osha_q66_answer"
                                id="osha_q66_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q66_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q66_answer"
                                value="2"
                                name="osha_q66_answer"
                                id="osha_q66_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q66_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q66_answer"
                                value="3"
                                name="osha_q66_answer"
                                id="osha_q66_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q66_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q66_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q66_images"/>
        </div>
        <!-- 67 Electrical beakers labeling: (clearly labeled) -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Electrical beakers labeling:</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q67_answer"
                                value="1"
                                name="osha_q67_answer"
                                id="osha_q67_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q67_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q67_answer"
                                value="2"
                                name="osha_q67_answer"
                                id="osha_q67_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q67_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q67_answer"
                                value="3"
                                name="osha_q67_answer"
                                id="osha_q67_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q67_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q67_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q67_images"/>
        </div>
        <!-- 68 Miscellaneous Electrical issues: -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Miscellaneous Electrical issues:</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q68_answer"
                                value="1"
                                name="osha_q68_answer"
                                id="osha_q68_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q68_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q68_answer"
                                value="2"
                                name="osha_q68_answer"
                                id="osha_q68_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q68_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="osha_q68_answer"
                                value="3"
                                name="osha_q68_answer"
                                id="osha_q68_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="osha_q68_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="osha_q68_comment" id="about" name="about" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple name="osha_q68_images"/>
        </div>
        <x-primary-button>Submit</x-primary-button>
    </div>
</form>
