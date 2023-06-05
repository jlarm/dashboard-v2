<form class="md:px-4">
    <div class="space-y-5">
        <div class="ml-3 md:ml-0">
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
        <!-- Has the Dealer established a written CMS? -->
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
                <label for="finance_q1_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q1_comment" id="finance_q1_comment"
                          name.lazy="finance_q1_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-collection
                max-items="2"
                name="finance_q1_images"
                :model="$financeAudit"
                collection="finance_q1_images"
            />
            @error('finance_q1_images.*'){{ $message }}@enderror
        </div>
        <!-- Has the written CMS been approved by the Board/Ownership? -->
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
                name="finance_q2_images"
                :model="$financeAudit"
                collection="finance_q2_images"
            />
        </div>
        <!-- Are shredding bins being utilized in dealership? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are shredding bins being utilized in
                    dealership?</label>
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
                    <input
                        wire:model="finance_q3_danger"
                        type="checkbox"
                        id="finance_q3_danger"
                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                    >
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q3_images"
                :model="$financeAudit"
                collection="finance_q3_images"
            />
        </div>
        <!-- Are shredding bins being emptied properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are shredding bins being emptied properly?</label>
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
                    <input
                        wire:model="finance_q4_danger"
                        type="checkbox"
                        id="finance_q4_danger"
                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                    >
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q4_images"
                :model="$financeAudit"
                collection="finance_q4_images"
            />
        </div>
        <!-- Has complaint procedure been established and adopted by Board? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Has complaint procedure been established and
                    adopted by Board?</label>
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
                    <input
                        wire:model="finance_q5_danger"
                        type="checkbox"
                        id="finance_q5_danger"
                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                    >
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q5_images"
                :model="$financeAudit"
                collection="finance_q5_images"
            />
        </div>
        <!-- Is accounting department/office locked and secured when employees not present? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is accounting department/office locked and secured
                    when employees not
                    present?</label>
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
                    <input
                        wire:model="finance_q6_danger"
                        type="checkbox"
                        id="finance_q6_danger"
                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                    >
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q6_images"
                :model="$financeAudit"
                collection="finance_q6_images"
            />
        </div>
        <!-- Have CMS policies been distributed to management and relevant employees? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have CMS policies been distributed to management
                    and relevant employees?</label>
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
                            <label for="finance_q7_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q7_danger" type="checkbox" id="finance_q7_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q7_images"
                :model="$financeAudit"
                collection="finance_q7_images"
            />
        </div>
        <!-- Have employees and management acknowledged receipt of the above? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have employees and management acknowledged receipt
                    of the above?</label>
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
                            <label for="finance_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input wire:model="finance_q8_danger" type="checkbox" id="finance_q8_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q8_images"
                :model="$financeAudit"
                collection="finance_q8_images"
            />
        </div>
        <!-- Are employees and management completing training on a consistent basis? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are employees and management completing training on
                    a consistent basis?</label>
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
                    <input wire:model="finance_q9_danger" type="checkbox" id="finance_q9_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q9_images"
                :model="$financeAudit"
                collection="finance_q9_images"
            />
        </div>
        <!-- Are there policies and procedures in place to handle and respond to consumer complaints? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are there policies and procedures in place to
                    handle and respond to consumer complaints?</label>
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
                    <input wire:model="finance_q10_danger" type="checkbox" id="finance_q10_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q10_images"
                :model="$financeAudit"
                collection="finance_q10_images"
            />
        </div>
        <!-- Are NPI/customer records being destroyed/shredded properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are NPI/customer records being destroyed/shredded
                    properly?</label>
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
                    <input wire:model="finance_q11_danger" type="checkbox" id="finance_q11_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q11_images"
                :model="$financeAudit"
                collection="finance_q11_images"
            />
        </div>
        <!-- Is the OFAC/SDN listings being completed on all contracted deals? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the OFAC/SDN listings being completed on all
                    contracted deals?</label>
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
                    <input wire:model="finance_q12_danger" type="checkbox" id="finance_q12_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q12_images"
                :model="$financeAudit"
                collection="finance_q12_images"
            />
        </div>
        <!-- Are all new employees signing dealerships security policy statement? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all new employees signing dealerships security
                    policy statement?</label>
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
                    <input wire:model="finance_q13_danger" type="checkbox" id="finance_q13_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q13_images"
                :model="$financeAudit"
                collection="finance_q13_images"
            />
        </div>
        <!-- Are computer terminals being logged off to activating screensaver password? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are computer terminals being logged off to
                    activate screensaver password?</label>
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
                    <input wire:model="finance_q14_danger" type="checkbox" id="finance_q14_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q14_images"
                :model="$financeAudit"
                collection="finance_q14_images"
            />
        </div>
        <!-- Are repair orders (RO’s) being disposed/shredded properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are repair orders (RO’s) being disposed/shredded
                    properly?</label>
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
                    <input wire:model="finance_q15_danger" type="checkbox" id="finance_q15_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q15_images"
                :model="$financeAudit"
                collection="finance_q15_images"
            />
        </div>
        <!-- Is the privacy notice clearly stated on dealerships website? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the privacy notice clearly stated on
                    dealership's
                    website?</label>
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
                    <input wire:model="finance_q16_danger" type="checkbox" id="finance_q16_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q16_images"
                :model="$financeAudit"
                collection="finance_q16_images"
            />
        </div>
        <!-- “NPI Check-Out Log” being utilized in accounting. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">“NPI Check-Out Log” being utilized in
                    accounting.</label>
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
                    <input wire:model="finance_q17_danger" type="checkbox" id="finance_q17_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q17_images"
                :model="$financeAudit"
                collection="finance_q17_images"
            />
        </div>
        <!-- Are all computer terminals automatically set to log off after 5 minutes of non-activity? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all computer terminals automatically set to log
                    off after 5 minutes of non-activity?</label>
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
                    <input wire:model="finance_q18_danger" type="checkbox" id="finance_q18_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q18_images"
                :model="$financeAudit"
                collection="finance_q18_images"
            />
        </div>
        <!-- Are network firewalls being monitored for intrusion. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are network firewalls being monitored for
                    intrusion.</label>
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
                    <input wire:model="finance_q19_danger" type="checkbox" id="finance_q19_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q19_images"
                :model="$financeAudit"
                collection="finance_q19_images"
            />
        </div>
        <!-- Written IT policies regarding the use of flash drives, downloading software and programs by employees, and spam email protocols? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Written IT policies regarding the use of flash
                    drives, downloading software and programs by employees, and spam email protocols?</label>
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
                    <input wire:model="finance_q20_danger" type="checkbox" id="finance_q20_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q20_images"
                :model="$financeAudit"
                collection="finance_q20_images"
            />
        </div>
        <!-- Have there been any network intrusions or security breaches since last quarterly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have there been any network intrusions or security
                    breaches since last quarterly?</label>
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
                    <input wire:model="finance_q21_danger" type="checkbox" id="finance_q21_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q21_images"
                :model="$financeAudit"
                collection="finance_q21_images"
            />
        </div>
        <!-- IT Technical requirements been implemented for Encryption, MFA and System monitoring, penetration testing, and vulnerability assessments? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">IT Technical requirements been implemented for
                    Encryption, MFA and System monitoring, penetration testing, and vulnerability assessments?</label>
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
                    <input wire:model="finance_q22_danger" type="checkbox" id="finance_q22_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q22_images"
                :model="$financeAudit"
                collection="finance_q22_images"
            />
        </div>
        <!-- Cashiers area unsecured -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Cashiers area unsecured</label>
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
                    <input wire:model="finance_q23_danger" type="checkbox" id="finance_q23_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q23_images"
                :model="$financeAudit"
                collection="finance_q23_images"
            />
        </div>
        <!-- Are there any new Third Party Service Provider companies that need to be sent acknowledgements and assessment report? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are there any new Third Party Service Provider
                    companies that need to be sent
                    acknowledgements and assessment report?</label>
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
                    <input wire:model="finance_q24_danger" type="checkbox" id="finance_q24_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q24_images"
                :model="$financeAudit"
                collection="finance_q24_images"
            />
        </div>
        <!-- Have Third Party Providers been vetted for required compliance practices, procedures and training? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Have Third Party Providers been vetted for required
                    compliance practices, procedures and training?</label>
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
                    <input wire:model="finance_q25_danger" type="checkbox" id="finance_q25_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q25_images"
                :model="$financeAudit"
                collection="finance_q25_images"
            />
        </div>
        <!-- Are sales desk drawers/file cabinets locked and secured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are sales desk drawers/file cabinets locked and
                    secured?</label>
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
                    <input wire:model="finance_q26_danger" type="checkbox" id="finance_q26_danger"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q26_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q26_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q26_images"
                :model="$financeAudit"
                collection="finance_q26_images"
            />
        </div>
        <!--Any NPI/customer documents being left out on sales desks? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Any NPI/customer documents being left out on sales
                    desks?</label>
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
                    <input wire:model="finance_q27_danger" type="checkbox" id="finance_q27_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q27_images"
                :model="$financeAudit"
                collection="finance_q27_images"
            />
        </div>
        <!-- Is CAN SPAM process in place? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is CAN SPAM process in place?</label>
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
                    <input wire:model="finance_q28_danger" type="checkbox" id="finance_q28_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q28_images"
                :model="$financeAudit"
                collection="finance_q28_images"
            />
        </div>
        <!-- Is the Telemarketing “Do Not Call” rule being complied with? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the Telemarketing “Do Not Call” rule being
                    complied with?</label>
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
                    <input wire:model="finance_q29_danger" type="checkbox" id="finance_q29_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q29_images"
                :model="$financeAudit"
                collection="finance_q29_images"
            />
        </div>
        <!-- Any other NPI documents publicly exposed, not secured properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Any other NPI documents publicly exposed, not
                    secured properly?</label>
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
                    <input wire:model="finance_q30_danger" type="checkbox" id="finance_q30_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q30_images"
                :model="$financeAudit"
                collection="finance_q30_images"
            />
        </div>
        <!-- Breach in password sharing? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Breach in password sharing?</label>
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
                    <input wire:model="finance_q31_danger" type="checkbox" id="finance_q31_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q31_images"
                :model="$financeAudit"
                collection="finance_q31_images"
            />
        </div>
        <!-- Customers NPI in unsecured trash cans? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Customers NPI in unsecured trash cans?</label>
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
                    <input wire:model="finance_q32_danger" type="checkbox" id="finance_q32_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q32_images"
                :model="$financeAudit"
                collection="finance_q32_images"
            />
        </div>
        <!-- Deal jackets unsecured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Deal jackets unsecured?</label>
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
                    <input wire:model="finance_q33_danger" type="checkbox" id="finance_q33_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q33_images"
                :model="$financeAudit"
                collection="finance_q33_images"
            />
        </div>
        <!-- Filing cabinets securing customers NPI locked and secured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Filing cabinets securing customers NPI locked and
                    secured?</label>
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
                    <input wire:model="finance_q34_danger" type="checkbox" id="finance_q34_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q34_images"
                :model="$financeAudit"
                collection="finance_q34_images"
            />
        </div>
        <!-- Sales Tower area secured from NPI/customer documents being exposed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Sales Tower area secured from NPI/customer
                    documents being exposed?</label>
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
                    <input wire:model="finance_q35_danger" type="checkbox" id="finance_q35_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q35_images"
                :model="$financeAudit"
                collection="finance_q35_images"
            />
        </div>
        <!-- Was Network Vulnerability Assessment Report completed, denote possible issues? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was Network Vulnerability \Assessment Report
                    completed, denote possible issues?</label>
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
                    <input wire:model="finance_q36_danger" type="checkbox" id="finance_q36_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q36_images"
                :model="$financeAudit"
                collection="finance_q36_images"
            />
        </div>
        <!-- Are finance offices locked and secured when employee not present? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are finance offices locked and secured when
                    employee not present?</label>
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
                    <input wire:model="finance_q37_danger" type="checkbox" id="finance_q37_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q37_images"
                :model="$financeAudit"
                collection="finance_q37_images"
            />
        </div>
        <!-- Are credit applications secured? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are credit applications secured?</label>
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
                    <input wire:model="finance_q38_danger" type="checkbox" id="finance_q38_danger"
                           class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="finance_q38_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="finance_q38_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q38_images"
                :model="$financeAudit"
                collection="finance_q38_images"
            />
        </div>
        <!-- Red Flag software being utilized to check for fraudulent applicants? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Red Flag software being utilized to check for
                    fraudulent applicants?</label>
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
                    <input wire:model="finance_q39_danger" type="checkbox" id="finance_q39_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q39_images"
                :model="$financeAudit"
                collection="finance_q39_images"
            />
        </div>
        <!-- Are managers’ offices locked and secured when not present? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are managers’ offices locked and secured when not
                    present?</label>
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
                    <input wire:model="finance_q40_danger" type="checkbox" id="finance_q40_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q40_images"
                :model="$financeAudit"
                collection="finance_q40_images"
            />
        </div>
        <!-- Are the sales Showroom doors secured prior to sales staff reporting to work? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the sales Showroom doors secured prior to sales
                    staff reporting to work?</label>
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
                    <input wire:model="finance_q41_danger" type="checkbox" id="finance_q41_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q41_images"
                :model="$financeAudit"
                collection="finance_q41_images"
            />
        </div>
        <!-- Are Buyers Guide properly displayed in a fully visible on all used cars? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are Buyers Guide properly displayed in a fully
                    visible on all used cars?</label>
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
                    <input wire:model="finance_q42_danger" type="checkbox" id="finance_q42_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q42_images"
                :model="$financeAudit"
                collection="finance_q42_images"
            />
        </div>
        <!-- Are Buyers Guides filled out properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are Buyers Guides filled out properly?</label>
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
                    <input wire:model="finance_q43_danger" type="checkbox" id="finance_q43_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q43_images"
                :model="$financeAudit"
                collection="finance_q43_images"
            />
        </div>
        <!-- Any new cars missing a Monroney sticker placement? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Any new cars missing a Monroney sticker
                    placement?</label>
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
                    <input wire:model="finance_q44_danger" type="checkbox" id="finance_q44_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q44_images"
                :model="$financeAudit"
                collection="finance_q44_images"
            />
        </div>
        <!-- Are the finance terms properly displayed on vehicle inventory? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are the finance terms properly displayed on vehicle
                    inventory?</label>
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
                    <input wire:model="finance_q45_danger" type="checkbox" id="finance_q45_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q45_images"
                :model="$financeAudit"
                collection="finance_q45_images"
            />
        </div>
        <!-- Is the sales bull pin area (if present) secured properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the sales bull pin area (if present) secured
                    properly?</label>
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
                    <input wire:model="finance_q46_danger" type="checkbox" id="finance_q46_danger"
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
            <x-media-library-collection
                multiple
                max-items="2"
                name="finance_q46_images"
                :model="$financeAudit"
                collection="finance_q46_images"
            />
        </div>
        <!-- please not any additional issue/violation found during your sales &amp; finance walk-thru audit. -->
        <div class="bg-gray-50 p-3 space-y-3">
            <div>
                <label class="text-base font-semibold text-gray-900">Please not any additional issue/violation found
                    during your sales &amp; finance walk-thru audit.</label>
            </div>
            <div>
                <textarea wire:model.lazy="finance_q47_comment" rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <div class="w-full sticky bottom-0 bg-arm-blue-200 p-5 z-20">
            <div class="flex justify-between sm:justify-end items-center flex-row-reverse sm:flex-row">
                <a
                    class="sm:mr-auto ml-5 sm:ml-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ !tenant('locations') ? route('dealer.audit.finance.index') : route('dealer.stores.audits.finance.index', $store) }}"
                >
                    Exit
                </a>
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
                <div class="relative flex items-start mr-auto sm:mr-0 sm:ml-5">
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
    {{--    <div wire:loading.delay class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">--}}
    {{--        <div class="fixed inset-0 bg-gray-100 bg-opacity-75 transition-opacity"></div>--}}
    {{--        <div class="fixed inset-0 z-10 overflow-y-auto">--}}
    {{--            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">--}}
    {{--                <div--}}
    {{--                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">--}}
    {{--                    <div>--}}
    {{--                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">--}}
    {{--                            <svg class="animate-spin h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"--}}
    {{--                                 fill="none" viewBox="0 0 24 24">--}}
    {{--                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"--}}
    {{--                                        stroke-width="4"></circle>--}}
    {{--                                <path class="opacity-75" fill="currentColor"--}}
    {{--                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>--}}
    {{--                            </svg>--}}
    {{--                        </div>--}}
    {{--                        <div class="mt-3 text-center sm:mt-5">--}}
    {{--                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Audit--}}
    {{--                                Saving</h3>--}}
    {{--                            <div class="mt-2">--}}
    {{--                                <p class="text-sm text-gray-500">This may take a few seconds, please don't close this--}}
    {{--                                    page.</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</form>
