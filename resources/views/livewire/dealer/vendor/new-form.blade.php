<div class="w-full max-w-3xl mx-auto py-10 space-y-5">
    <x-application-logo class="h-12 w-auto mx-auto"/>
    <h1 class="text-center">{{ $storeName }}</h1>
    <p><span class="block">Hi {{ $vendor->name }},</span>
        Please complete the attached Third Party Vendor Risk Assessment form and provide electronic sign-off. We are finalizing our GLBA / Safeguards Rule requirements and need to confirm that {{ $vendor->vendor->name }} has adequate policies, procedures, and IT/cybersecurity controls in place to detect and respond to potential security incidents involving our customer information to which you may have access, either electronically or physically.</p>
    <form wire:submit.prevent="submit" class="space-y-3">
        <div class="bg-blue-50 border border-blue-200 rounded-md p-6">
            <label for="document" class="block text-base font-medium text-gray-900 mb-2">
                Upload Completed Risk Assessment Document (PDF)
            </label>
            <p class="text-sm text-gray-600 mb-4">
                If {{ $vendor->vendor->name }} already has a written policies-and-procedures program that outlines your response to GLBA/Safeguards-related security and IT incidents, you may upload a PDF in the tab below. Your company policy must be signed off by a key upper management person, Owner or a board member.
            </p>
            <input
                wire:model="document"
                type="file"
                id="document"
                accept=".pdf"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-arm-blue-50 file:text-arm-blue-700 hover:file:bg-arm-blue-100"
            >
            @error('document') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            <div wire:loading wire:target="document" class="text-sm text-gray-500 mt-2">Uploading...</div>
        </div>

        @if(!$document)
        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[1]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.1.response"
                                value="yes"
                                name="data.1.response"
                                type="radio"
                                id="data.1.response-yes"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.1.response-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.1.response"
                                value="no"
                                name="data.1.response"
                                type="radio"
                                id="data.1.response-no"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.1.response-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.1.response"
                                value="na"
                                name="data.1.response"
                                type="radio"
                                id="data.1.response-na"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.1.response-na" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.1.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.1.comment"
                            rows="4"
                            id="data.1.comment"
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
                <label class="text-base font-medium text-gray-900">{{ $data[2]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.2.response"
                                id="data.2.response"
                                name="data.2.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.2.response"
                                id="data.2.response"
                                name="data.2.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.2.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.2.response"
                                id="data.2.response"
                                name="data.2.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.2.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.2.comment"
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
                <label class="text-base font-medium text-gray-900">{{ $data[3]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.3.response"
                                id="data.3.response"
                                name="data.3.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.3.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.3.response"
                                id="data.3.response"
                                name="data.3.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.3.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.3.response"
                                id="data.3.response"
                                name="data.3.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.3.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.3.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.3.comment"
                            rows="4"
                            id="data.3.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[4]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.4.response"
                                id="data.4.response"
                                name="data.4.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">

                            <label for="data.4.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.4.response"
                                id="data.4.response"
                                name="data.4.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.4.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.4.response"
                                id="data.4.response"
                                name="data.4.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.4.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.4.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.4.comment"
                            rows="4"
                            id="data.4.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[5]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.5.response"
                                id="data.5.response"
                                name="data.5.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.5.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.5.response"
                                id="data.5.response"
                                name="data.5.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.5.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.5.response"
                                id="data.5.response"
                                name="data.5.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.5.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.5.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.5.comment"
                            rows="4"
                            id="data.5.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[6]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.6.response"
                                id="data.6.response"
                                name="data.6.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.6.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.6.response"
                                id="data.6.response"
                                name="data.6.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.6.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.6.response"
                                id="data.6.response"
                                name="data.6.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.6.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.6.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.6.comment"
                            rows="4"
                            id="data.6.comment"
                            placeholder="Security Training Frequency:"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[7]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.7.response"
                                id="data.7.response"
                                name="data.7.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.7.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.7.response"
                                id="data.7.response"
                                name="data.7.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.7.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.7.response"
                                id="data.7.response"
                                name="data.7.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.7.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.7.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.7.comment"
                            rows="4"
                            id="data.7.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[8]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.8.response"
                                id="data.8.response"
                                name="data.8.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.8.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.8.response"
                                id="data.8.response"
                                name="data.8.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.8.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.8.response"
                                id="data.8.response"
                                name="data.8.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.8.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.8.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.8.comment"
                            rows="4"
                            id="data.8.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[9]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.9.response"
                                id="data.9.response"
                                name="data.9.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.9.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.9.response"
                                id="data.9.response"
                                name="data.9.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.9.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.9.response"
                                id="data.9.response"
                                name="data.9.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.9.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.9.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.9.comment"
                            rows="4"
                            id="data.9.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[10]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.10.response"
                                id="data.10.response"
                                name="data.10.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.10.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.10.response"
                                id="data.10.response"
                                name="data.10.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.10.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.10.response"
                                id="data.10.response"
                                name="data.10.response"
                                value="na"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.10.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.10.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.10.comment"
                            rows="4"
                            id="data.10.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[11]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.11.response"
                                id="data.11.response"
                                name="data.11.response"
                                value="yes"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.11.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.11.response"
                                id="data.11.response"
                                name="data.11.response"
                                value="no"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.11.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.11.response" name="data.11.response" value="na" id="data.11.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.11.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.11.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.11.comment" rows="4" id="data.11.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[12]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.12.response" name="data.12.response" value="yes" id="data.12.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.12.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.12.response" name="data.12.response" value="no" id="data.12.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.12.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.12.response" name="data.12.response" value="na" id="data.12.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.12.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.12.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.12.comment" rows="4" id="data.12.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[13]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.13.response" name="data.13.response" value="yes" id="data.13.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.13.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.13.response" name="data.13.response" value="no" id="data.13.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.13.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.13.response" name="data.13.response" value="na" id="data.13.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.13.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.13.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.13.comment" rows="4" id="data.13.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[14]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.14.response" name="data.14.response" value="yes" id="data.14.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.14.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.14.response" name="data.14.response" value="no" id="data.14.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.14.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.14.response" name="data.14.response" value="na" id="data.14.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.14.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.14.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.14.comment" rows="4" id="data.14.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[15]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.15.response" name="data.15.response" value="yes" id="data.15.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.15.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.15.response" name="data.15.response" value="no" id="data.15.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.15.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.15.response" name="data.15.response" value="na" id="data.15.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500"
                            >
                            <label for="data.15.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.15.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.15.comment" rows="4" id="data.15.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[16]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.16.response" name="data.16.response" value="yes" id="data.16.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.16.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.16.response" name="data.16.response" value="no" id="data.16.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.16.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.16.response" name="data.16.response" value="na" id="data.16.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.16.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.16.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.16.comment" rows="4" id="data.16.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[17]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.17.response" name="data.17.response" value="yes" id="data.17.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.17.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.17.response" name="data.17.response" value="no" id="data.17.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.17.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.17.response" name="data.17.response" value="na" id="data.17.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.17.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.17.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.17.comment" rows="4" id="data.17.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[18]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.18.response" name="data.18.response" value="yes" id="data.18.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.18.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.18.response" name="data.18.response" value="no" id="data.18.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.18.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.18.response" name="data.18.response" value="na" id="data.18.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.18.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.18.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.18.comment" rows="4" id="data.18.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[19]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.19.response" name="data.19.response" value="yes" id="data.19.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.19.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.19.response" name="data.19.response" value="no" id="data.19.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.19.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.19.response" name="data.19.response" value="na" id="data.19.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.19.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.19.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.19.comment" rows="4" id="data.19.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[20]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.20.response" name="data.20.response" value="yes" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.20.response" name="data.20.response" value="no" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.20.response" name="data.20.response" value="na" id="a20a" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="a20a" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.20.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.20.comment" rows="4" id="data.20.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[21]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.21.response" name="data.21.response" value="yes" id="data.21.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.21.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.21.response" name="data.21.response" value="no" id="data.21.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.21.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.21.response" name="data.21.response" value="na" id="data.21.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.21.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.21.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea wire:model.defer="data.21.comment" rows="4" id="data.21.comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 rounded-md">
            <div class="p-10">
                <label class="text-base font-medium text-gray-900">{{ $data[22]['question'] }}</label>
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input wire:model.defer="data.22.response" name="data.22.response" value="yes" id="data.22.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.22.response" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                        </div>

                        <div class="flex items-center">
                            <input wire:model.defer="data.22.response" name="data.22.response" value="no" id="data.22.response" type="radio"
                                   class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.22.response" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                        </div>

                        <div class="flex items-center">
                            <input
                                wire:model.defer="data.22.response"
                                name="data.22.response"
                                value="na"
                                id="data.22.response"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                            <label for="data.22.response" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-5">
                    <label for="data.22.comment" class="block text-sm font-medium text-gray-700">Comments</label>
                    <div class="mt-1">
                        <textarea
                            wire:model.defer="data.22.comment"
                            rows="4"
                            id="data.22.comment"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <x-signature-pad wire:model.defer="signature"/>
        @error('signature') <span class="text-red-500">{{ $message }}</span> @enderror
        @endif

        <div>
            <x-primary-button>Submit</x-primary-button>
        </div>
    </form>
</div>
