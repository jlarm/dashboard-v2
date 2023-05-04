<form>
    <div class="space-y-5">
        <div class="ml-3 sm:ml-0">
            <label for="audit_date" class="block text-sm font-medium leading-6 text-gray-900">Audit Date</label>
            <div class="mt-2">
                <input
                    wire:model="audit_date"
                    type="date"
                    name="audit_date"
                    id="audit_date"
                    pattern=""
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- 1 Has the Dealer established a written CMS? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has the Dealer established a written CMS?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q1_answer"
                                value="1"
                                name="finance_q1_answer"
                                id="finance_q1_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q1_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q1_answer"
                                value="2"
                                name="finance_q1_answer"
                                id="finance_q1_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q1_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q1_answer"
                                value="3"
                                name="finance_q1_answer"
                                id="finance_q1_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q1_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="finance_q1_danger"
                            id="finance_q1_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q1_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q1_comment" id.lazy="finance_q1_comment"
                          name.lazy="finance_q1_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-collection
                multiple
                max-items="2"
                rules="mimes:png,jpeg"
                name="finance_q1_images"
                :model="$financeAudit"
                collection="finance_q1_images"
            />
            @error('finance_q1_images.*'){{ $message }}@enderror
        </div>
        <!-- 2 Has the written CMS been approved by the Board/Ownership? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has the written CMS been approved by the
                    Board/Ownership?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q2_answer"
                                value="1"
                                name="finance_q2_answer"
                                id="finance_q2_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q2_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q2_answer"
                                value="2"
                                name="finance_q2_answer"
                                id="finance_q2_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q2_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q2_answer"
                                value="3"
                                name="finance_q2_answer"
                                id="finance_q2_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q2_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q2_danger" type="checkbox" id="finance_q2_danger"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q2_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy.lazy="finance_q2_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-collection
                multiple
                max-items="2"
                rules="mimes:png,jpeg"
                name="finance_q2_images"
                :model="$financeAudit"
                collection="finance_q2_images"
            />
        </div>
        <!-- 3 Shredding bins over-flowing and need to be cleaned out. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Shredding bins over-flowing and need to be cleaned
                    out.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q3_answer"
                                value="1"
                                name="finance_q3_answer"
                                id="finance_q3_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q3_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q3_answer"
                                value="2"
                                name="finance_q3_answer"
                                id="finance_q3_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q3_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q3_answer"
                                value="3"
                                name="finance_q3_answer"
                                id="finance_q3_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q3_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q3_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q3_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q3_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q3_images"/>
        </div>
        <!-- 4 Has complaint procedure been established and adopted by Board? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has complaint procedure been established and
                    adopted by Board?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q4_answer"
                                value="1"
                                name="finance_q4_answer"
                                id="finance_q4_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q4_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q4_answer"
                                value="2"
                                name="finance_q4_answer"
                                id="finance_q4_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q4_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q4_answer"
                                value="3"
                                name="finance_q4_answer"
                                id="finance_q4_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q4_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q4_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q4_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q4_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q4_images"/>
        </div>
        <!-- 5 Account department is not locked when employees are not present. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Account department is not locked when employees are
                    not present.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q5_answer"
                                value="1"
                                name="finance_q5_answer"
                                id="finance_q5_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q5_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q5_answer"
                                value="2"
                                name="finance_q5_answer"
                                id="finance_q5_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q5_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q5_answer"
                                value="3"
                                name="finance_q5_answer"
                                id="finance_q5_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q5_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q5_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q5_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q5_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q5_images"/>
        </div>
        <!-- 6 Have CMS policies been distributed to management and relevant employees? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have CMS policies been distributed to management
                    and relevant employees?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q6_answer"
                                value="1"
                                name="finance_q6_answer"
                                id="finance_q6_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q6_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q6_answer"
                                value="2"
                                name="finance_q6_answer"
                                id="finance_q6_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q6_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q6_answer"
                                value="3"
                                name="finance_q6_answer"
                                id="finance_q6_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q6_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q6_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q6_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q6_images"/>
        </div>
        <!-- 7 Have employees and management acknowledged receipt of the above? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have employees and management acknowledged receipt
                    of the above?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q7_answer"
                                value="1"
                                name="finance_q7_answer"
                                id="finance_q7_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q7_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q7_answer"
                                value="2"
                                name="finance_q7_answer"
                                id="finance_q7_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q7_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q7_answer"
                                value="3"
                                name="finance_q7_answer"
                                id="finance_q7_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q7_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q7_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q7_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q7_images"/>
        </div>
        <!-- 8 Are employees and management completing training on a consistent basis? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are employees and management completing training on
                    a consistent basis?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q8_answer"
                                value="1"
                                name="finance_q8_answer"
                                id="finance_q8_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q8_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q8_answer"
                                value="2"
                                name="finance_q8_answer"
                                id="finance_q8_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q8_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q8_answer"
                                value="3"
                                name="finance_q8_answer"
                                id="finance_q8_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q8_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q8_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q8_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q8_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q8_images"/>
        </div>
        <!-- 9 Are there policies and procedures in place to handle and respond to consumer complaints? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are there policies and procedures in place to
                    handle and respond to consumer complaints?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q9_answer"
                                value="1"
                                name="finance_q9_answer"
                                id="finance_q9_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q9_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q9_answer"
                                value="2"
                                name="finance_q9_answer"
                                id="finance_q9_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q9_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q9_answer"
                                value="3"
                                name="finance_q9_answer"
                                id="finance_q9_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q9_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q9_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q9_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q9_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q9_images"/>
        </div>
        <!-- 10 Destruction of outdated NPI records? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Destruction of outdated NPI records?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q10_answer"
                                value="1"
                                name="finance_q10_answer"
                                id="finance_q10_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q10_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q10_answer"
                                value="2"
                                name="finance_q10_answer"
                                id="finance_q10_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q10_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q10_answer"
                                value="3"
                                name="finance_q10_answer"
                                id="finance_q10_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q10_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q10_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q10_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q10_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q10_images"/>
        </div>
        <!-- 11 OFAC/SDN Listing documentation -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">OFAC/SDN Listing documentation</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q11_answer"
                                value="1"
                                name="finance_q11_answer"
                                id="finance_q11_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q11_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q11_answer"
                                value="2"
                                name="finance_q11_answer"
                                id="finance_q11_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q11_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q11_answer"
                                value="3"
                                name="finance_q11_answer"
                                id="finance_q11_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q11_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q11_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q11_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q11_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q11_images"/>
        </div>
        <!-- 12 Employees hired have signed confidentiality and security policy statements. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Employees hired have signed confidentiality and
                    security policy statements.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q12_answer"
                                value="1"
                                name="finance_q12_answer"
                                id="finance_q12_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q12_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q12_answer"
                                value="2"
                                name="finance_q12_answer"
                                id="finance_q12_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q12_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q12_answer"
                                value="3"
                                name="finance_q12_answer"
                                id="finance_q12_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q12_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q12_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q12_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q12_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q12_images"/>
        </div>
        <!-- 13 Password activation on computers -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Password activation on computers</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q13_answer"
                                value="1"
                                name="finance_q13_answer"
                                id="finance_q13_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q13_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q13_answer"
                                value="2"
                                name="finance_q13_answer"
                                id="finance_q13_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q13_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q13_answer"
                                value="3"
                                name="finance_q13_answer"
                                id="finance_q13_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q13_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q13_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q13_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q13_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q13_images"/>
        </div>
        <!-- 14 Service Writers trash can have RO’s and misc. NPI documents present. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Service Writers trash can have RO’s and misc. NPI
                    documents present.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q14_answer"
                                value="1"
                                name="finance_q14_answer"
                                id="finance_q14_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q14_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q14_answer"
                                value="2"
                                name="finance_q14_answer"
                                id="finance_q14_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q14_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q14_answer"
                                value="3"
                                name="finance_q14_answer"
                                id="finance_q14_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q14_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q14_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q14_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q14_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q14_images"/>
        </div>
        <!-- 15 Website privacy policy compliance. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Website privacy policy compliance.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q15_answer"
                                value="1"
                                name="finance_q15_answer"
                                id="finance_q15_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q15_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q15_answer"
                                value="2"
                                name="finance_q15_answer"
                                id="finance_q15_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q15_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q15_answer"
                                value="3"
                                name="finance_q15_answer"
                                id="finance_q15_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q15_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q15_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q15_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q15_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q15_images"/>
        </div>
        <!-- 16 “NPI Check-Out Log” being utilized in accounting. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">“NPI Check-Out Log” being utilized in
                    accounting.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q16_answer"
                                value="1"
                                name="finance_q16_answer"
                                id="finance_q16_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q16_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q16_answer"
                                value="2"
                                name="finance_q16_answer"
                                id="finance_q16_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q16_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q16_answer"
                                value="3"
                                name="finance_q16_answer"
                                id="finance_q16_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q16_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q16_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q16_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q16_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q16_images"/>
        </div>
        <!-- 17 Review “Certificate of Destruction” receipts from shredding company -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Review “Certificate of Destruction” receipts from
                    shredding company</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q17_answer"
                                value="1"
                                name="finance_q17_answer"
                                id="finance_q17_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q17_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q17_answer"
                                value="2"
                                name="finance_q17_answer"
                                id="finance_q17_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q17_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q17_answer"
                                value="3"
                                name="finance_q17_answer"
                                id="finance_q17_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q17_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q17_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q17_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q17_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q17_images"/>
        </div>
        <!-- 18 Computer terminals not being logged off to activating screensaver password? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Computer terminals not being logged off to
                    activating screensaver password?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q18_answer"
                                value="1"
                                name="finance_q18_answer"
                                id="finance_q18_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q18_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q18_answer"
                                value="2"
                                name="finance_q18_answer"
                                id="finance_q18_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q18_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q18_answer"
                                value="3"
                                name="finance_q18_answer"
                                id="finance_q18_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q18_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q18_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q18_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q18_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q18_images"/>
        </div>
        <!-- 19 Computer terminal not set to automatically log off after 5 minutes of non-activity. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Computer terminal not set to automatically log off
                    after 5 minutes of non-activity.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q19_answer"
                                value="1"
                                name="finance_q19_answer"
                                id="finance_q19_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q19_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q19_answer"
                                value="2"
                                name="finance_q19_answer"
                                id="finance_q19_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q19_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q19_answer"
                                value="3"
                                name="finance_q19_answer"
                                id="finance_q19_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q19_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q19_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q19_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q19_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q19_images"/>
        </div>
        <!-- 20 Are network firewalls being monitored for intrusion. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are network firewalls being monitored for
                    intrusion.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q20_answer"
                                value="1"
                                name="finance_q20_answer"
                                id="finance_q20_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q20_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q20_answer"
                                value="2"
                                name="finance_q20_answer"
                                id="finance_q20_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q20_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q20_answer"
                                value="3"
                                name="finance_q20_answer"
                                id="finance_q20_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q20_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q20_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q20_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q20_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q20_images"/>
        </div>
        <!-- 21 Written IT policies regarding the use of flash drives, downloading software and programs by employees, and spam email protocols? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Written IT policies regarding the use of flash
                    drives, downloading software and programs by employees, and spam email protocols?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q21_answer"
                                value="1"
                                name="finance_q21_answer"
                                id="finance_q21_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q21_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q21_answer"
                                value="2"
                                name="finance_q21_answer"
                                id="finance_q21_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q21_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q21_answer"
                                value="3"
                                name="finance_q21_answer"
                                id="finance_q21_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q21_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q21_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q21_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q21_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q21_images"/>
        </div>
        <!-- 22 Have there been any network intrusions or security breaches since last quarterly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have there been any network intrusions or security
                    breaches since last quarterly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q22_answer"
                                value="1"
                                name="finance_q22_answer"
                                id="finance_q22_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q22_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q22_answer"
                                value="2"
                                name="finance_q22_answer"
                                id="finance_q22_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q22_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q22_answer"
                                value="3"
                                name="finance_q22_answer"
                                id="finance_q22_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q22_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q22_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q22_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q22_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q22_images"/>
        </div>
        <!-- 23 Has a Security Risk Assessment been completed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has a Security Risk Assessment been
                    completed?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q23_answer"
                                value="1"
                                name="finance_q23_answer"
                                id="finance_q23_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q23_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q23_answer"
                                value="2"
                                name="finance_q23_answer"
                                id="finance_q23_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q23_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q23_answer"
                                value="3"
                                name="finance_q23_answer"
                                id="finance_q23_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q23_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q23_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q23_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q23_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q23_images"/>
        </div>
        <!-- 24 Written Response Plan been created?  -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Written Response Plan been created?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q24_answer"
                                value="1"
                                name="finance_q24_answer"
                                id="finance_q24_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q24_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q24_answer"
                                value="2"
                                name="finance_q24_answer"
                                id="finance_q24_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q24_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q24_answer"
                                value="3"
                                name="finance_q24_answer"
                                id="finance_q24_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q24_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q24_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q24_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q24_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q24_images"/>
        </div>
        <!-- 25 IT Technical requirements been implemented for Encryption, MFA and System monitoring, penetration testing, and vulnerability assessments? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">IT Technical requirements been implemented for
                    Encryption, MFA and System monitoring, penetration testing, and vulnerability assessments?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q25_answer"
                                value="1"
                                name="finance_q25_answer"
                                id="finance_q25_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q25_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q25_answer"
                                value="2"
                                name="finance_q25_answer"
                                id="finance_q25_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q25_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q25_answer"
                                value="3"
                                name="finance_q25_answer"
                                id="finance_q25_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q25_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q25_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q25_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q25_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q25_images"/>
        </div>
        <!-- 26 Cashiers area unsecured -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Cashiers area unsecured</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q26_answer"
                                value="1"
                                name="finance_q26_answer"
                                id="finance_q26_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q26_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q26_answer"
                                value="2"
                                name="finance_q26_answer"
                                id="finance_q26_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q26_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q26_answer"
                                value="3"
                                name="finance_q26_answer"
                                id="finance_q26_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q26_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q26_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_qq26_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q26_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q26_images"/>
        </div>
        <!-- 27 Review new Third Party provider agreements for safeguard language and compliance. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Review new Third Party provider agreements for
                    safeguard language and compliance.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q27_answer"
                                value="1"
                                name="finance_q27_answer"
                                id="finance_q27_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q27_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q27_answer"
                                value="2"
                                name="finance_q27_answer"
                                id="finance_q27_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q27_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q27_answer"
                                value="3"
                                name="finance_q27_answer"
                                id="finance_q27_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q27_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q27_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q27_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q27_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q27_images"/>
        </div>
        <!-- 28 Have Third Party Providers been vetted for required compliance practices, procedures and training? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have Third Party Providers been vetted for required
                    compliance practices, procedures and training?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q28_answer"
                                value="1"
                                name="finance_q28_answer"
                                id="finance_q28_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q28_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q28_answer"
                                value="2"
                                name="finance_q28_answer"
                                id="finance_q28_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q28_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q28_answer"
                                value="3"
                                name="finance_q28_answer"
                                id="finance_q28_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q28_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q28_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q28_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q28_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q28_images"/>
        </div>
        <!-- 29 Sales desks not secured and have customer document exposed -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">ASales desks not secured and have customer document
                    exposed</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q29_answer"
                                value="1"
                                name="finance_q29_answer"
                                id="finance_q29_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q29_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q29_answer"
                                value="2"
                                name="finance_q29_answer"
                                id="finance_q29_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q29_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q29_answer"
                                value="3"
                                name="finance_q29_answer"
                                id="finance_q29_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q29_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q29_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q29_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q29_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q29_images"/>
        </div>
        <!-- 30 Check Can Spam Unsubscribe compliance. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Check Can Spam Unsubscribe compliance.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q30_answer"
                                value="1"
                                name="finance_q30_answer"
                                id="finance_q30_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q30_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q30_answer"
                                value="2"
                                name="finance_q30_answer"
                                id="finance_q30_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q30_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q30_answer"
                                value="3"
                                name="finance_q30_answer"
                                id="finance_q30_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q30_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q30_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q30_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q30_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q30_images"/>
        </div>
        <!-- 31 Check for Telemarketing Do Not Call rules compliance: i.e., what system/software is in place to provide tracking? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Check for Telemarketing Do Not Call rules
                    compliance: i.e., what system/software is in place to provide tracking?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q31_answer"
                                value="1"
                                name="finance_q31_answer"
                                id="finance_q31_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q31_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q31_answer"
                                value="2"
                                name="finance_q31_answer"
                                id="finance_q31_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q31_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q31_answer"
                                value="3"
                                name="finance_q31_answer"
                                id="finance_q31_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q31_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q31_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q31_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q31_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q31_images"/>
        </div>
        <!-- 32 NPI documents publicly exposed, not secured properly -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">NPI documents publicly exposed, not secured
                    properly</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q32_answer"
                                value="1"
                                name="finance_q32_answer"
                                id="finance_q32_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q32_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q32_answer"
                                value="2"
                                name="finance_q32_answer"
                                id="finance_q32_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q32_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q32_answer"
                                value="3"
                                name="finance_q32_answer"
                                id="finance_q32_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q32_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q32_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q32_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q32_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q32_images"/>
        </div>
        <!-- 33 Breach in password sharing? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Breach in password sharing?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q33_answer"
                                value="1"
                                name="finance_q33_answer"
                                id="finance_q33_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q33_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q33_answer"
                                value="2"
                                name="finance_q33_answer"
                                id="finance_q33_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q33_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q33_answer"
                                value="3"
                                name="finance_q33_answer"
                                id="finance_q33_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q33_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q33_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q33_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q33_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q33_images"/>
        </div>
        <!-- 34 Customers NPI in unsecured trash cans? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Customers NPI in unsecured trash cans?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q34_answer"
                                value="1"
                                name="finance_q34_answer"
                                id="finance_q34_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q34_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q34_answer"
                                value="2"
                                name="finance_q34_answer"
                                id="finance_q34_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q34_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q34_answer"
                                value="3"
                                name="finance_q34_answer"
                                id="finance_q34_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q34_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q34_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q34_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q34_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q34_images"/>
        </div>
        <!-- 35 Deal jackets unsecured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Deal jackets unsecured?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q35_answer"
                                value="1"
                                name="finance_q35_answer"
                                id="finance_q35_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q35_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q35_answer"
                                value="2"
                                name="finance_q35_answer"
                                id="finance_q35_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q35_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q35_answer"
                                value="3"
                                name="finance_q35_answer"
                                id="finance_q35_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q35_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q35_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q35_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q35_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q35_images"/>
        </div>
        <!-- 36 Customer Information exposed/not secured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Customer Information exposed/not secured?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q36_answer"
                                value="1"
                                name="finance_q36_answer"
                                id="finance_q36_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q36_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q36_answer"
                                value="2"
                                name="finance_q36_answer"
                                id="finance_q36_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q36_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q36_answer"
                                value="3"
                                name="finance_q36_answer"
                                id="finance_q36_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q36_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q36_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q36_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q36_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q36_images"/>
        </div>
        <!-- 37 Filing cabinets securing customers NPI locked and secured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Filing cabinets securing customers NPI locked and
                    secured?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q37_answer"
                                value="1"
                                name="finance_q37_answer"
                                id="finance_q37_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q37_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q37_answer"
                                value="2"
                                name="finance_q37_answer"
                                id="finance_q37_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q37_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q37_answer"
                                value="3"
                                name="finance_q37_answer"
                                id="finance_q37_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q37_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q37_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q37_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q37_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q37_images"/>
        </div>
        <!-- 38 Sales Tower area has NPI exposure, unsecured customer documents -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Sales Tower area has NPI exposure, unsecured
                    customer documents</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q38_answer"
                                value="1"
                                name="finance_q38_answer"
                                id="finance_q38_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q38_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q38_answer"
                                value="2"
                                name="finance_q38_answer"
                                id="finance_q38_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q38_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q38_answer"
                                value="3"
                                name="finance_q38_answer"
                                id="finance_q38_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q38_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q39_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q39_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q38_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q38_images"/>
        </div>
        <!-- 39 Was Network Vulnerability Assessment Report completed, denote possible issues? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was Network Vulnerability \Assessment Report
                    completed, denote possible issues?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q39_answer"
                                value="1"
                                name="finance_q39_answer"
                                id="finance_q39_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q39_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q39_answer"
                                value="2"
                                name="finance_q39_answer"
                                id="finance_q39_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q39_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q39_answer"
                                value="3"
                                name="finance_q39_answer"
                                id="finance_q39_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q39_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q39_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q39_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q39_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q39_images"/>
        </div>
        <!-- 40 Finance Office not locked exposing unsecured customer documents -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Finance Office not locked exposing unsecured
                    customer documents</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q40_answer"
                                value="1"
                                name="finance_q40_answer"
                                id="finance_q40_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q40_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q40_answer"
                                value="2"
                                name="finance_q40_answer"
                                id="finance_q40_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q40_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q40_answer"
                                value="3"
                                name="finance_q40_answer"
                                id="finance_q40_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q40_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q40_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q40_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q40_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q40_images"/>
        </div>
        <!-- 41 Credit application unsecured -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Credit application unsecured</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q41_answer"
                                value="1"
                                name="finance_q41_answer"
                                id="finance_q41_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q41_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q41_answer"
                                value="2"
                                name="finance_q41_answer"
                                id="finance_q41_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q41_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q41_answer"
                                value="3"
                                name="finance_q41_answer"
                                id="finance_q41_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q41_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q41_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q41_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q41_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q41_images"/>
        </div>
        <!-- 42 Red Flag software being utilized to check for fraudulent applicants? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Red Flag software being utilized to check for
                    fraudulent applicants?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q42_answer"
                                value="1"
                                name="finance_q42_answer"
                                id="finance_q42_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q42_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q42_answer"
                                value="2"
                                name="finance_q42_answer"
                                id="finance_q42_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q42_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q42_answer"
                                value="3"
                                name="finance_q42_answer"
                                id="finance_q42_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q42_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q42_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q42_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q42_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q42_images"/>
        </div>
        <!-- 43 Managers’ offices not being secured when employee not present. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Managers’ offices not being secured when employee
                    not present.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q43_answer"
                                value="1"
                                name="finance_q43_answer"
                                id="finance_q43_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q43_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q43_answer"
                                value="2"
                                name="finance_q43_answer"
                                id="finance_q43_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q43_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q43_answer"
                                value="3"
                                name="finance_q43_answer"
                                id="finance_q43_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q43_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q43_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q43_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q43_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q43_images"/>
        </div>
        <!-- 44 Sales Showroom main exterior doors not secured prior to sales managers’ and employees reporting to work. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Sales Showroom main exterior doors not secured
                    prior to sales managers’ and employees reporting to work.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q44_answer"
                                value="1"
                                name="finance_q44_answer"
                                id="finance_q44_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q44_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q44_answer"
                                value="2"
                                name="finance_q44_answer"
                                id="finance_q44_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q44_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q44_answer"
                                value="3"
                                name="finance_q44_answer"
                                id="finance_q44_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q44_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q44_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q44_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q44_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q44_images"/>
        </div>
        <!-- 45 Use Car buyers guide not visibly posted on vehicles in parking lot/showroom -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Use Car buyers guide not visibly posted on vehicles
                    in parking lot/showroom</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q45_answer"
                                value="1"
                                name="finance_q45_answer"
                                id="finance_q45_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q45_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q45_answer"
                                value="2"
                                name="finance_q45_answer"
                                id="finance_q45_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q45_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q45_answer"
                                value="3"
                                name="finance_q45_answer"
                                id="finance_q45_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q45_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q45_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q45_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q45_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q45_images"/>
        </div>
        <!-- 46 Buyers Guide not filled out properly -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Buyers Guide not filled out properly</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q46_answer"
                                value="1"
                                name="finance_q46_answer"
                                id="finance_q46_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q46_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q46_answer"
                                value="2"
                                name="finance_q46_answer"
                                id="finance_q46_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q46_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q46_answer"
                                value="3"
                                name="finance_q46_answer"
                                id="finance_q46_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q46_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q46_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q46_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q46_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q46_images"/>
        </div>
        <!-- 47 New car missing Monroney sticker placement. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">New car missing Monroney sticker placement.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q47_answer"
                                value="1"
                                name="finance_q47_answer"
                                id="finance_q47_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q47_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q47_answer"
                                value="2"
                                name="finance_q47_answer"
                                id="finance_q47_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q47_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q47_answer"
                                value="3"
                                name="finance_q47_answer"
                                id="finance_q47_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q47_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q47_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q47_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q47_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q47_images"/>
        </div>
        <!-- 48 Improper finance terms noted/written on vehicle inventory -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Improper finance terms noted/written on vehicle
                    inventory</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q48_answer"
                                value="1"
                                name="finance_q48_answer"
                                id="finance_q48_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q48_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q48_answer"
                                value="2"
                                name="finance_q48_answer"
                                id="finance_q48_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q48_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q48_answer"
                                value="3"
                                name="finance_q48_answer"
                                id="finance_q48_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q48_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q48_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q48_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q48_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q48_images"/>
        </div>
        <!-- 49 Sale staff bull pin area not secured properly when employees not present -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Sale staff bull pin area not secured properly when
                    employees not present</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q49_answer"
                                value="1"
                                name="finance_q49_answer"
                                id="finance_q49_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q49_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q49_answer"
                                value="2"
                                name="finance_q49_answer"
                                id="finance_q49_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q49_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="finance_q49_answer"
                                value="3"
                                name="finance_q49_answer"
                                id="finance_q49_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="finance_q49_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q49_danger" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q49_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q49_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-attachment multiple max-items="2" rules="mimes:png,jpeg" name="finance_q49_images"/>
        </div>
        <div class="w-full sticky bottom-0 bg-arm-blue-200 p-5">
            <div class="flex justify-between sm:justify-end items-center flex-row-reverse sm:flex-row space-x-6">
                <button
                    wire:click.prevent="uploadImages"
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
                    Update
                </button>
                <div class="relative flex items-start">
                    <div class="flex h-6 items-center">
                        <input wire:model="draft" id="draft" aria-describedby="draft-description" name="draft"
                               type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                    </div>
                    <div class="ml-1 text-sm leading-6">
                        <label for="draft" class="font-medium text-gray-900">Save as Draft</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
