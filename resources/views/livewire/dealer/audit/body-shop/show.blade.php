<form method="POST" wire:submit.prevent="submit">
    <div class="space-y-5">
        <!-- 1 Is a Filtration Log being completed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is a Filtration Log being completed?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q1_answer"
                                value="1"
                                name="body_shop_q1_answer"
                                id="body_shop_q1_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q1_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q1_answer"
                                value="2"
                                name="body_shop_q1_answer"
                                id="body_shop_q1_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q1_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q1_answer"
                                value="3"
                                name="body_shop_q1_answer"
                                id="body_shop_q1_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q1_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q1_comment" id="body_shop_q1_comment" name="body_shop_q1_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q1_images"/>
        </div>
        <!-- 2 Do all employees know how to -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do all employees know how to access SDS’s?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q2_answer"
                                value="1"
                                name="body_shop_q2_answer"
                                id="body_shop_q2_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q2_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q2_answer"
                                value="2"
                                name="body_shop_q2_answer"
                                id="body_shop_q2_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q2_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q2_answer"
                                value="3"
                                name="body_shop_q2_answer"
                                id="body_shop_q2_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q2_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q2_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q2_images"/>
        </div>
        <!-- 3 Has annual fit test for all employees been performed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has annual fit test for all employees been
                    performed?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q3_answer"
                                value="1"
                                name="body_shop_q3_answer"
                                id="body_shop_q3_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q3_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q3_answer"
                                value="2"
                                name="body_shop_q3_answer"
                                id="body_shop_q3_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q3_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q3_answer"
                                value="3"
                                name="body_shop_q3_answer"
                                id="body_shop_q3_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q3_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q3_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q3_images"/>
        </div>
        <!-- 4 Medical Questionnaire issued to employees utilizing respirators? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Medical Questionnaire issued to employees utilizing
                    respirators?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q4_answer"
                                value="1"
                                name="body_shop_q4_answer"
                                id="body_shop_q4_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q4_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q4_answer"
                                value="2"
                                name="body_shop_q4_answer"
                                id="body_shop_q4_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q4_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q4_answer"
                                value="3"
                                name="body_shop_q4_answer"
                                id="body_shop_q4_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q4_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q4_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q4_images"/>
        </div>
        <!-- 5 Are respirators stored properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are respirators stored properly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q5_answer"
                                value="1"
                                name="body_shop_q5_answer"
                                id="body_shop_q5_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q5_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q5_answer"
                                value="2"
                                name="body_shop_q5_answer"
                                id="body_shop_q5_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q5_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q5_answer"
                                value="3"
                                name="body_shop_q5_answer"
                                id="body_shop_q5_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q5_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q5_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q5_images"/>
        </div>
        <!-- 6 Hybrid - Do respirators have NIOSH certification? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do respirators have NIOSH certification?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q6_answer"
                                value="1"
                                name="body_shop_q6_answer"
                                id="body_shop_q6_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q6_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q6_answer"
                                value="2"
                                name="body_shop_q6_answer"
                                id="body_shop_q6_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q6_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q6_answer"
                                value="3"
                                name="body_shop_q6_answer"
                                id="body_shop_q6_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q6_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q6_images"/>
        </div>
        <!-- 7 Is PPE equipment available and is it in good condition? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is PPE equipment available and is it in good
                    condition?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q7_answer"
                                value="1"
                                name="body_shop_q7_answer"
                                id="body_shop_q7_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q7_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q7_answer"
                                value="2"
                                name="body_shop_q7_answer"
                                id="body_shop_q7_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q7_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q7_answer"
                                value="3"
                                name="body_shop_q7_answer"
                                id="body_shop_q7_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q7_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q7_images"/>
        </div>
        <!-- 8 Are paint booths free from any flammable material? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are paint booths free from any flammable
                    material?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q8_answer"
                                value="1"
                                name="body_shop_q8_answer"
                                id="body_shop_q8_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q8_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q8_answer"
                                value="2"
                                name="body_shop_q8_answer"
                                id="body_shop_q8_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q8_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q8_answer"
                                value="3"
                                name="body_shop_q8_answer"
                                id="body_shop_q8_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q8_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q8_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q8_images"/>
        </div>
        <!-- 9 Are all the flammable materials stored properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all the flammable materials stored
                    properly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q9_answer"
                                value="1"
                                name="body_shop_q9_answer"
                                id="body_shop_q9_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q9_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q9_answer"
                                value="2"
                                name="body_shop_q9_answer"
                                id="body_shop_q9_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q9_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q9_answer"
                                value="3"
                                name="body_shop_q9_answer"
                                id="body_shop_q9_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q9_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q9_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q9_images"/>
        </div>
        <!-- 10 Are all products that are in containers other than the original properly labeled with product NAME, MFG, and appropriate hazard warning? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all products that are in containers other than
                    the original properly labeled with product NAME, MFG, and appropriate hazard warning?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q10_answer"
                                value="1"
                                name="body_shop_q10_answer"
                                id="body_shop_q10_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q10_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q10_answer"
                                value="2"
                                name="body_shop_q10_answer"
                                id="body_shop_q10_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q10_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q10_answer"
                                value="3"
                                name="body_shop_q10_answer"
                                id="body_shop_q10_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q10_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q10_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q10_images"/>
        </div>
        <!-- 11 Has the eye wash equipment been tested, cleaned and documented weekly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has the eye wash equipment been tested, cleaned and
                    documented weekly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q11_answer"
                                value="1"
                                name="body_shop_q11_answer"
                                id="body_shop_q11_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q11_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q11_answer"
                                value="2"
                                name="body_shop_q11_answer"
                                id="body_shop_q11_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q11_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q11_answer"
                                value="3"
                                name="body_shop_q11_answer"
                                id="body_shop_q11_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q11_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q11_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q11_images"/>
        </div>
        <!-- 12 Is the eye wash equipment readily accessible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the eye wash equipment readily
                    accessible?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q12_answer"
                                value="1"
                                name="body_shop_q12_answer"
                                id="body_shop_q12_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q12_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q12_answer"
                                value="2"
                                name="body_shop_q12_answer"
                                id="body_shop_q12_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q12_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q12_answer"
                                value="3"
                                name="body_shop_q12_answer"
                                id="body_shop_q12_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q12_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q12_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q12_images"/>
        </div>
        <!-- 13 How often is the water/solution changed in the eye wash equipment? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">How often is the water/solution changed in the eye
                    wash equipment?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q13_answer"
                                value="1"
                                name="body_shop_q13_answer"
                                id="body_shop_q13_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q13_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q13_answer"
                                value="2"
                                name="body_shop_q13_answer"
                                id="body_shop_q13_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q13_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q13_answer"
                                value="3"
                                name="body_shop_q13_answer"
                                id="body_shop_q13_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q13_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q13_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q13_images"/>
        </div>
        <!-- 14 Do you have documentation on water/solution change out? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Do you have documentation on water/solution change
                    out?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q14_answer"
                                value="1"
                                name="body_shop_q14_answer"
                                id="body_shop_q14_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q14_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q14_answer"
                                value="2"
                                name="body_shop_q14_answer"
                                id="body_shop_q14_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q14_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q14_answer"
                                value="3"
                                name="body_shop_q14_answer"
                                id="body_shop_q14_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q14_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q14_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q14_images"/>
        </div>
        <!-- 15 Are you following the mfg. specs? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are you following the mfg. specs?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q15_answer"
                                value="1"
                                name="body_shop_q15_answer"
                                id="body_shop_q15_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q15_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q15_answer"
                                value="2"
                                name="body_shop_q15_answer"
                                id="body_shop_q15_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q15_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q15_answer"
                                value="3"
                                name="body_shop_q15_answer"
                                id="body_shop_q15_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q15_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q15_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q15_images"/>
        </div>
        <!-- 16 Have the fire extinguishers had their annual inspection and are they properly identified and fully charged? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have the fire extinguishers had their annual
                    inspection and are they properly identified and fully charged?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q16_answer"
                                value="1"
                                name="body_shop_q16_answer"
                                id="body_shop_q16_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q16_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q16_answer"
                                value="2"
                                name="body_shop_q16_answer"
                                id="body_shop_q16_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q16_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q16_answer"
                                value="3"
                                name="body_shop_q16_answer"
                                id="body_shop_q16_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q16_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900" for="inspection_date">Last Annual Inspection
                    Date</label>
                <input wire:model.defer="body_shop_q16_inspection_date" type="date" id="inspection_date"
                       class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q16_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q16_images"/>
        </div>
        <!-- 17 Are the fire extinguishers easily accessible? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the fire extinguishers easily
                    accessible?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q17_answer"
                                value="1"
                                name="body_shop_q17_answer"
                                id="body_shop_q17_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q17_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q17_answer"
                                value="2"
                                name="body_shop_q17_answer"
                                id="body_shop_q17_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q17_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q17_answer"
                                value="3"
                                name="body_shop_q17_answer"
                                id="body_shop_q17_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q17_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q17_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q17_images"/>
        </div>
        <!-- 18 Are all hoses and cutting tips for the welder/cutting torches in good condition without any cracks or breaks? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all hoses and cutting tips for the
                    welder/cutting torches in good condition without any cracks or breaks?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q18_answer"
                                value="1"
                                name="body_shop_q18_answer"
                                id="body_shop_q18_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q18_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q18_answer"
                                value="2"
                                name="body_shop_q18_answer"
                                id="body_shop_q18_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q18_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q18_answer"
                                value="3"
                                name="body_shop_q18_answer"
                                id="body_shop_q18_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q18_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q18_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q18_images"/>
        </div>
        <!-- 19 Are all exits properly marked? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all exits properly marked?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q19_answer"
                                value="1"
                                name="body_shop_q19_answer"
                                id="body_shop_q19_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q19_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q19_answer"
                                value="2"
                                name="body_shop_q19_answer"
                                id="body_shop_q19_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q19_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q19_answer"
                                value="3"
                                name="body_shop_q19_answer"
                                id="body_shop_q19_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q19_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q19_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q19_images"/>
        </div>
        <!-- 20 Are pathways to exits clear of obstructions? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are pathways to exits clear of
                    obstructions?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q20_answer"
                                value="1"
                                name="body_shop_q20_answer"
                                id="body_shop_q20_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q20_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q20_answer"
                                value="2"
                                name="body_shop_q20_answer"
                                id="body_shop_q20_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q20_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q20_answer"
                                value="3"
                                name="body_shop_q20_answer"
                                id="body_shop_q20_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q20_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q20_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q20_images"/>
        </div>
        <!-- 21 Are all aisles/pathways, stairways and landings free from obstructions and are the shop areas kept clean and orderly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all aisles/pathways, stairways and landings
                    free from obstructions and are the shop areas kept clean and orderly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q21_answer"
                                value="1"
                                name="body_shop_q21_answer"
                                id="body_shop_q21_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q21_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q21_answer"
                                value="2"
                                name="body_shop_q21_answer"
                                id="body_shop_q21_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q21_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q21_answer"
                                value="3"
                                name="body_shop_q21_answer"
                                id="body_shop_q21_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q21_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q21_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q21_images"/>
        </div>
        <!-- 22 Are any doorways that are nonfunctioning or blocked marked by a sign stating “NOT AN EXIT”? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are any doorways that are nonfunctioning or blocked
                    marked by a sign stating “NOT AN EXIT”? Are any doorways that are nonfunctioning or blocked marked
                    by a sign stating “NOT AN EXIT”?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q22_answer"
                                value="1"
                                name="body_shop_q22_answer"
                                id="body_shop_q22_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q22_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q22_answer"
                                value="2"
                                name="body_shop_q22_answer"
                                id="body_shop_q22_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q22_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q22_answer"
                                value="3"
                                name="body_shop_q22_answer"
                                id="body_shop_q22_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q22_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q22_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q22_images"/>
        </div>
        <!-- 23 Are floors in good repair and free from obstruction and debris and slippery conditions? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are floors in good repair and free from obstruction
                    and debris and slippery conditions?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q23_answer"
                                value="1"
                                name="body_shop_q23_answer"
                                id="body_shop_q23_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q23_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q23_answer"
                                value="2"
                                name="body_shop_q23_answer"
                                id="body_shop_q23_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q23_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q23_answer"
                                value="3"
                                name="body_shop_q23_answer"
                                id="body_shop_q23_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q23_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q23_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q23_images"/>
        </div>
        <!-- 24 Are floor openings in excess of 2.25” wide covered with hinged flaps? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are floor openings in excess of 2.25” wide covered
                    with hinged flaps?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q24_answer"
                                value="1"
                                name="body_shop_q24_answer"
                                id="body_shop_q24_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q24_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q24_answer"
                                value="2"
                                name="body_shop_q24_answer"
                                id="body_shop_q24_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q24_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q24_answer"
                                value="3"
                                name="body_shop_q24_answer"
                                id="body_shop_q24_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q24_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q24_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q24_images"/>
        </div>
        <!-- 25 Are compressed air hoses in safe (no frays, cuts, tape or clamps for repair) working condition? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are compressed air hoses in safe (no frays, cuts,
                    tape or clamps for repair) working condition?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q25_answer"
                                value="1"
                                name="body_shop_q25_answer"
                                id="body_shop_q25_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q25_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q25_answer"
                                value="2"
                                name="body_shop_q25_answer"
                                id="body_shop_q25_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q25_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q25_answer"
                                value="3"
                                name="body_shop_q25_answer"
                                id="body_shop_q25_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q25_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q25_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q25_images"/>
        </div>
        <!-- 26 Are all portable gas containers UL of FM approved? Yes, dealership only uses UL approved containers. Did not find any of these containers in the body shop during this audit. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all portable gas containers UL of FM approved?
                    Yes, dealership only uses UL approved containers. Did not find any of these containers in the body
                    shop during this audit.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q26_answer"
                                value="1"
                                name="body_shop_q26_answer"
                                id="body_shop_q26_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q26_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q26_answer"
                                value="2"
                                name="body_shop_q26_answer"
                                id="body_shop_q26_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q26_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q26_answer"
                                value="3"
                                name="body_shop_q26_answer"
                                id="body_shop_q26_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q26_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q26_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q26_images"/>
        </div>
        <!-- 27 All gas cylinders stored properly i.e. tied down etc.? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">All gas cylinders stored properly i.e. tied down
                    etc.?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q27_answer"
                                value="1"
                                name="body_shop_q27_answer"
                                id="body_shop_q27_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q27_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q27_answer"
                                value="2"
                                name="body_shop_q27_answer"
                                id="body_shop_q27_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q27_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q27_answer"
                                value="3"
                                name="body_shop_q27_answer"
                                id="body_shop_q27_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q27_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q27_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q27_images"/>
        </div>
        <!-- 28 Are gas cylinders stored away from sources of heat or electricity and at least 20’ away from combustible materials? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are gas cylinders stored away from sources of heat
                    or electricity and at least 20’ away from combustible materials?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q28_answer"
                                value="1"
                                name="body_shop_q28_answer"
                                id="body_shop_q28_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q28_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q28_answer"
                                value="2"
                                name="body_shop_q28_answer"
                                id="body_shop_q28_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q28_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q28_answer"
                                value="3"
                                name="body_shop_q28_answer"
                                id="body_shop_q28_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q28_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q28_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q28_images"/>
        </div>
        <!-- 29 When dispensing are all tanks holding flammable material properly grounded? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">When dispensing are all tanks holding flammable
                    material properly grounded?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q29_answer"
                                value="1"
                                name="body_shop_q29_answer"
                                id="body_shop_q29_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q29_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q29_answer"
                                value="2"
                                name="body_shop_q29_answer"
                                id="body_shop_q29_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q29_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q29_answer"
                                value="3"
                                name="body_shop_q29_answer"
                                id="body_shop_q29_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q29_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q29_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q29_images"/>
        </div>
        <!-- 30 Is there proper signage about not smoking in the appropriate areas? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there proper signage about not smoking in the
                    appropriate areas?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q30_answer"
                                value="1"
                                name="body_shop_q30_answer"
                                id="body_shop_q30_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q30_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q30_answer"
                                value="2"
                                name="body_shop_q30_answer"
                                id="body_shop_q30_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q30_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q30_answer"
                                value="3"
                                name="body_shop_q30_answer"
                                id="body_shop_q30_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q30_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q30_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q30_images"/>
        </div>
        <!-- 31 Are no smoking signs being enforced? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are no smoking signs being enforced?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q31_answer"
                                value="1"
                                name="body_shop_q31_answer"
                                id="body_shop_q31_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q31_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q31_answer"
                                value="2"
                                name="body_shop_q31_answer"
                                id="body_shop_q31_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q31_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q31_answer"
                                value="3"
                                name="body_shop_q31_answer"
                                id="body_shop_q31_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q31_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q31_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q31_images"/>
        </div>
        <!-- 32 Are goggles or face shields always worn when grinding? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are goggles or face shields always worn when
                    grinding?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q32_answer"
                                value="1"
                                name="body_shop_q32_answer"
                                id="body_shop_q32_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q32_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q32_answer"
                                value="2"
                                name="body_shop_q32_answer"
                                id="body_shop_q32_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q32_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q32_answer"
                                value="3"
                                name="body_shop_q32_answer"
                                id="body_shop_q32_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q32_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q32_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q32_images"/>
        </div>
        <!-- 33 Is there proper spacing on grinders; Tool rest 1/8” from grinding wheel Tongue plate 1/4” from grinding wheel -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there proper spacing on grinders; Tool rest 1/8”
                    from grinding wheel Tongue plate 1/4” from grinding wheel</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q33_answer"
                                value="1"
                                name="body_shop_q33_answer"
                                id="body_shop_q33_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q33_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q33_answer"
                                value="2"
                                name="body_shop_q33_answer"
                                id="body_shop_q33_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q33_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q33_answer"
                                value="3"
                                name="body_shop_q33_answer"
                                id="body_shop_q33_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q33_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q33_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q33_images"/>
        </div>
        <!-- 34 Are Signs posted warning of automatic starting feature of the compressors? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are Signs posted warning of automatic starting
                    feature of the compressors?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q34_answer"
                                value="1"
                                name="body_shop_q34_answer"
                                id="body_shop_q34_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q34_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q34_answer"
                                value="2"
                                name="body_shop_q34_answer"
                                id="body_shop_q34_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q34_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q34_answer"
                                value="3"
                                name="body_shop_q34_answer"
                                id="body_shop_q34_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q34_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q34_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q34_images"/>
        </div>
        <!-- 35 Is there clear access of at least 36” to all electrical panels? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there clear access of at least 36” to all
                    electrical panels?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q35_answer"
                                value="1"
                                name="body_shop_q35_answer"
                                id="body_shop_q35_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q35_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q35_answer"
                                value="2"
                                name="body_shop_q35_answer"
                                id="body_shop_q35_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q35_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q35_answer"
                                value="3"
                                name="body_shop_q35_answer"
                                id="body_shop_q35_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q35_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q35_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q35_images"/>
        </div>
        <!-- 36 Are all the breakers properly labeled? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all the breakers properly labeled?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q36_answer"
                                value="1"
                                name="body_shop_q36_answer"
                                id="body_shop_q36_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q36_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q36_answer"
                                value="2"
                                name="body_shop_q36_answer"
                                id="body_shop_q36_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q36_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q36_answer"
                                value="3"
                                name="body_shop_q36_answer"
                                id="body_shop_q36_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q36_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q36_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q36_images"/>
        </div>
        <!-- 37 Are there any extension cords being used improperly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are there any extension cords being used
                    improperly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q37_answer"
                                value="1"
                                name="body_shop_q37_answer"
                                id="body_shop_q37_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q37_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q37_answer"
                                value="2"
                                name="body_shop_q37_answer"
                                id="body_shop_q37_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q37_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q37_answer"
                                value="3"
                                name="body_shop_q37_answer"
                                id="body_shop_q37_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q37_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q37_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q37_images"/>
        </div>
        <!-- 38 Are any electrical cords frayed, cracked, taped, or spliced? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are any electrical cords frayed, cracked, taped, or
                    spliced?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q38_answer"
                                value="1"
                                name="body_shop_q38_answer"
                                id="body_shop_q38_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q38_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q38_answer"
                                value="2"
                                name="body_shop_q38_answer"
                                id="body_shop_q38_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q38_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q38_answer"
                                value="3"
                                name="body_shop_q38_answer"
                                id="body_shop_q38_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q38_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q38_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q38_images"/>
        </div>
        <!-- 39 Check the plug end to be sure the ground is still intact. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Check the plug end to be sure the ground is still
                    intact.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q39_answer"
                                value="1"
                                name="body_shop_q39_answer"
                                id="body_shop_q39_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q39_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q39_answer"
                                value="2"
                                name="body_shop_q39_answer"
                                id="body_shop_q39_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q39_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q39_answer"
                                value="3"
                                name="body_shop_q39_answer"
                                id="body_shop_q39_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q39_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q39_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q39_images"/>
        </div>
        <!-- 40 Any electrical issues: -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Any electrical issues:</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q40_answer"
                                value="1"
                                name="body_shop_q40_answer"
                                id="body_shop_q40_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q40_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q40_answer"
                                value="2"
                                name="body_shop_q40_answer"
                                id="body_shop_q40_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q40_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q40_answer"
                                value="3"
                                name="body_shop_q40_answer"
                                id="body_shop_q40_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q40_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q40_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q40_images"/>
        </div>
        <!-- 41 Miscellaneous issues? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Miscellaneous issues?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q41_answer"
                                value="1"
                                name="body_shop_q41_answer"
                                id="body_shop_q41_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q41_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q41_answer"
                                value="2"
                                name="body_shop_q41_answer"
                                id="body_shop_q41_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q41_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q41_answer"
                                value="3"
                                name="body_shop_q41_answer"
                                id="body_shop_q41_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q41_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q41_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q41_images"/>
        </div>
        <!-- 42 Hybrid Vehicle Safety: Are batteries removed before work is started? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Hybrid Vehicle Safety: Are batteries removed before
                    work is started? Safety Gloves –“Class O heavy- duty gloves” rated to withstand 1,000 volts.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q42_answer"
                                value="1"
                                name="body_shop_q42_answer"
                                id="body_shop_q42_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q42_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q42_answer"
                                value="2"
                                name="body_shop_q42_answer"
                                id="body_shop_q42_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q42_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q42_answer"
                                value="3"
                                name="body_shop_q42_answer"
                                id="body_shop_q42_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q42_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q42_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q42_images"/>
        </div>
        <!-- 43 Safety glasses not being worn when working on hybrid vehicle? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Safety glasses not being worn when working on
                    hybrid vehicle?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q43_answer"
                                value="1"
                                name="body_shop_q43_answer"
                                id="body_shop_q43_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q43_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q43_answer"
                                value="2"
                                name="body_shop_q43_answer"
                                id="body_shop_q43_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q43_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q43_answer"
                                value="3"
                                name="body_shop_q43_answer"
                                id="body_shop_q43_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q43_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q43_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q43_images"/>
        </div>
        <!-- 44 Is the First Aid Kit identified and is it stocked with appropriate supplies? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the First Aid Kit identified and is it stocked
                    with appropriate supplies? i.e. absorbent compress, adhesive bandages, adhesive tape, antiseptic,
                    burn treatment, medical exam gloves, sterile pads, triangular bandages.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q44_answer"
                                value="1"
                                name="body_shop_q44_answer"
                                id="body_shop_q44_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q44_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q44_answer"
                                value="2"
                                name="body_shop_q44_answer"
                                id="body_shop_q44_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q44_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q44_answer"
                                value="3"
                                name="body_shop_q44_answer"
                                id="body_shop_q44_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q44_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q44_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q44_images"/>
        </div>
        <!-- 45 Electrical panels: (clear access of at -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Electrical panels: (clear access of at least
                    36")</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q45_answer"
                                value="1"
                                name="body_shop_q45_answer"
                                id="body_shop_q45_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q45_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q45_answer"
                                value="2"
                                name="body_shop_q45_answer"
                                id="body_shop_q45_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q45_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model.defer="body_shop_q45_answer"
                                value="3"
                                name="body_shop_q45_answer"
                                id="body_shop_q45_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="body_shop_q45_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.defer="body_shop_q45_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                @error('answer') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="body_shop_q45_images"/>
        </div>
        <div class="flex items-center space-x-6">
            <button
                class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <svg wire:loading
                     class="animate-spin w-4 h-4 mr-2 text-gray-300 hover:cursor-pointer"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submit
            </button>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model.defer="draft" id="draft" aria-describedby="draft-description" name="draft"
                           type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-1 text-sm leading-6">
                    <label for="draft" class="font-medium text-gray-900">Save as Draft</label>
                </div>
            </div>
        </div>
    </div>
</form>
