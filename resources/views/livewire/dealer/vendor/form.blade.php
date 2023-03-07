<div>
    <form class="space-y-5" wire:submit.prevent="submit">
        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Are you an employee or authorized representative of
                    this vendor/company? Indicate the Person’s Name in the comments</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q1a"
                                value="yes"
                                name="q1a"
                                type="radio"
                                id="q1a-yes"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q1a-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q1a"
                                value="no"
                                name="q1a"
                                type="radio"
                                id="q1a-no"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q1a-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q1a"
                                value="na"
                                name="q1a"
                                type="radio"
                                id="q1a-na"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q1a-na" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q1c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q1c"
                            rows="4"
                            id="q1c"
                            placeholder="Person's Name:"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        >
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company offer software applications as part
                    of its services?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q2a"
                                id="q2a"
                                name="q2a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q2a"
                                id="q2a"
                                name="q2a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q2a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q2a"
                                id="q2a"
                                name="q2a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q2c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q2c"
                            rows="4"
                            id="q2c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Is client data encrypted at rest and in transit? If
                    not, why not?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q3a"
                                id="q3a"
                                name="q3a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q3a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q3a"
                                id="q3a"
                                name="q3a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q3a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q3a"
                                id="q3a"
                                name="q3a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q3a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q3c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q3c"
                            rows="4"
                            id="q3c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Has your company experienced a data breach in the
                    past 12 months that affected customers’ personal information?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q4a"
                                id="q4a"
                                name="q4a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">

                            <label for="q4a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q4a"
                                id="q4a"
                                name="q4a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q4a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q4a"
                                id="q4a"
                                name="q4a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q4a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q4c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q4c"
                            rows="4"
                            id="q4c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have insurance coverage for a data
                    breach that may involve our customers’ information that your company acquires while doing business
                    with us?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q5a"
                                id="q5a"
                                name="q5a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q5a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q5a"
                                id="q5a"
                                name="q5a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q5a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q5a"
                                id="q5a"
                                name="q5a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q5a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q5c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q5c"
                            rows="4"
                            id="q5c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company require security awareness training
                    for all employees? If so, please answer how often it is provided in the comments section.</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q6a"
                                id="q6a"
                                name="q6a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q6a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q6a"
                                id="q6a"
                                name="q6a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q6a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q6a"
                                id="q6a"
                                name="q6a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q6a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q6c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q6c"
                            rows="4"
                            id="q6c"
                            placeholder="Security Training Frequency:"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company monitor for the effectiveness of
                    employee security training by testing your users with simulated attacks?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q7a"
                                id="q7a"
                                name="q7a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q7a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q7a"
                                id="q7a"
                                name="q7a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q7a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q7a"
                                id="q7a"
                                name="q7a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q7a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q7c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q7c"
                            rows="4"
                            id="q7c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have a process for restricting
                    access to customer files on a need-to-know basis?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q8a"
                                id="q8a"
                                name="q8a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q8a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q8a"
                                id="q8a"
                                name="q8a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q8a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q8a"
                                id="q8a"
                                name="q8a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q8a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q8c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q8c"
                            rows="4"
                            id="q8c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Do you have a written information security
                    program?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q9a"
                                id="q9a"
                                name="q9a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q9a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q9a"
                                id="q9a"
                                name="q9a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q9a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q9a"
                                id="q9a"
                                name="q9a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q9a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q9c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q9c"
                            rows="4"
                            id="q9c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company conduct annual risk assessments
                    that assess electronic, physical, and administrative information safeguards?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q10a"
                                id="q10a"
                                name="q10a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q10a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q10a"
                                id="q10a"
                                name="q10a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q10a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q10a"
                                id="q10a"
                                name="q10a"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q10a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q10c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q10c"
                            rows="4"
                            id="q10c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have systems in place to securely
                    dispose of documents that have personal identifiable information on them?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="q11a"
                                id="q11a"
                                name="q11a"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q11a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q11a"
                                id="q11a"
                                name="q11a"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q11a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q11a" name="q11a" value="na" id="q11a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q11a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q11c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q11c" rows="4" id="q11c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have systems in place to restrict
                    access to files/documents containing customers personal information to those with proper
                    authorization?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q12a" name="q12a" value="yes" id="q12a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q12a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q12a" name="q12a" value="no" id="q12a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q12a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q12a" name="q12a" value="na" id="q12a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q12a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q12c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q12c" rows="4" id="q12c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have due diligence processes and
                    procedures for vetting subcontractors, including having them sign processing agreements that are
                    compliant with applicable federal and state laws?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q13a" name="q13a" value="yes" id="q13a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q13a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q13a" name="q13a" value="no" id="q13a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q13a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q13a" name="q13a" value="na" id="q13a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q13a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q13c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q13c" rows="4" id="q13c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Has your company performed penetration testing of its
                    systems within the past 12 months?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q14a" name="q14a" value="yes" id="q14a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q14a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q14a" name="q14a" value="no" id="q14a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q14a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q14a" name="q14a" value="na" id="q14a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q14a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q14c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q14c" rows="4" id="q14c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Has your company conducted a vulnerability assessment
                    of your systems within the past 6 months?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q15a" name="q15a" value="yes" id="q15a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q15a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q15a" name="q15a" value="no" id="q15a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q15a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q15a" name="q15a" value="na" id="q15a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="q15a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q15c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q15c" rows="4" id="q15c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company maintain end-of-life or unsupported
                    operating systems or software? If so, are these systems used to manage or maintain customer
                    data?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q16a" name="q16a" value="yes" id="q16a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q16a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q16a" name="q16a" value="no" id="q16a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q16a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q16a" name="q16a" value="na" id="q16a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q16a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q16c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q16c" rows="4" id="q16c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company regularly patch or update systems
                    and third-party software and monitor for noncompliance?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q17a" name="q17a" value="yes" id="q17a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q17a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q17a" name="q17a" value="no" id="q17a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q17a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q17a" name="q17a" value="na" id="q17a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q17a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q17c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q17c" rows="4" id="q17c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company have a written incident response
                    plan in the event of a security breach?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q18a" name="q18a" value="yes" id="q18a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q18a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q18a" name="q18a" value="no" id="q18a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q18a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q18a" name="q18a" value="na" id="q18a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q18a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q18c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q18c" rows="4" id="q18c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company require users to create complex
                    passwords with 9 characters or greater?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q19a" name="q19a" value="yes" id="q19a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q19a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q19a" name="q19a" value="no" id="q19a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q19a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q19a" name="q19a" value="na" id="q19a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q19a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q19c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q19c" rows="4" id="q19c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company prohibit shared logins?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q20a" name="q20a" value="yes" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q20a" name="q20a" value="no" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q20a" name="q20a" value="na" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q20c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q20c" rows="4" id="q20c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Does your company require multi-factor authentication
                    to log into your company’s systems?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q21a" name="q21a" value="yes" id="q21a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q21a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q21a" name="q21a" value="no" id="q21a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q21a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q21a" name="q21a" value="na" id="q21a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q21a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q21c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="q21c" rows="4" id="q21c"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">Do you have an account lockout policy?</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="q22a" name="q22a" value="yes" id="q22a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q22a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="q22a" name="q22a" value="no" id="q22a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q22a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="q22a"
                                name="q22a"
                                value="na"
                                id="q22a"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="q22a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="q22c" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="q22c"
                            rows="4"
                            id="q22c"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label for="contact_name" class="block text-sm font-medium text-gray-700">Name of Person Completing This
                Form:</label>
            <div class="mt-1">
                <input
                    disabled
                    wire:model.defer="contact_name"
                    type="text"
                    name="contact_name"
                    id="contact_name"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500
                focus:ring-arm-blue-500 sm:text-sm"
                >
            </div>
        </div>

        <div>
            <label for="company" class="block text-sm font-medium text-gray-700">Company Name:</label>
            <div class="mt-1">
                <input
                    disabled
                    wire:model="name"
                    type="text"
                    name="company"
                    id="company"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500
                focus:ring-arm-blue-500 sm:text-sm">
            </div>
        </div>

        <x-signature-pad wire:model.defer="signature"/>

        <div>
            <button type="submit" class="bg-arm-blue-500 py-3 px-5 rounded-md text-white">Submit</button>
        </div>

    </form>

</div>
