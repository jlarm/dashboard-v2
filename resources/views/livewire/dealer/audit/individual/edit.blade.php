<div class="min-h-screen">
    <form class="md:px-4" wire:loading.class="opacity-25">
        <div class="max-w-3xl mx-auto px-3 mb-5 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <label for="audit_date" class="block text-sm font-medium leading-6 text-gray-900">Audit Date</label>
                    <div class="mt-2">
                        <input
                            wire:model.defer="audit_date"
                            type="date"
                            name="audit_date"
                            id="audit_date"
                            pattern=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <!-- Deal Jacket Date -->
                <div>
                    <label for="deal_jacket_date" class="block text-sm font-medium leading-6 text-gray-900">Date of Deal
                        Jacket</label>
                    <div class="mt-2">
                        <input
                            wire:model.defer="deal_jacket_date"
                            type="date"
                            name="deal_jacket_date"
                            id="deal_jacket_date"
                            pattern=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <!-- Customer Name -->
                <div>
                    <label for="customer_name" class="block text-sm font-medium leading-6 text-gray-900">Customer
                        Name</label>
                    <div class="mt-2">
                        <input
                            wire:model.defer="customer_name"
                            type="text"
                            name="customer_name"
                            id="customer_name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <!-- Customer Number -->
                <div>
                    <label for="customer_number" class="block text-sm font-medium leading-6 text-gray-900">Customer Deal
                        Number</label>
                    <div class="mt-2">
                        <input
                            wire:model.defer="customer_number"
                            type="text"
                            name="customer_number"
                            id="customer_number"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <!-- Manager Name -->
                <div>
                    <label for="manager_id" class="block text-sm font-medium leading-6 text-gray-900">Finance
                        Manager</label>
                    <div class="mt-2">
                        <select wire:model.defer="manager_id" id="manager_id" name="manager_id" autocomplete="cmanager_id"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                            <option></option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Mileage -->
                <div>
                    <label for="customer_number" class="block text-sm font-medium leading-6 text-gray-900">Mileage</label>
                    <div class="mt-2">
                        <input
                            wire:model.defer="mileage"
                            type="number"
                            name="mileage"
                            id="mileage"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
            </div>
            @foreach($questions as $index => $question)
                <div class="border border-gray-200 shadow-sm rounded-xl p-5">
                    <label class="text-base font-semibold text-gray-900">{{ $index + 1 }}. {{ $question->question }}</label>
                    <div class="space-y-4 mt-4">
                        <fieldset>
                            @if ($question->id === 1)
                                <div class="flex items-center space-x-5">
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="1"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_1"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_1"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">Cash</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="2"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_2"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_2"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">Finance</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="3"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_3"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_3"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">Lease</label>
                                    </div>
                                </div>
                            @elseif($question->id === 2)
                                <div class="flex items-center space-x-5">
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="1"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_1"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_1"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">New</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="2"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_2"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_2"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">Used</label>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-5">
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="1"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_1"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_1"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="2"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_2"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_2"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            wire:model.defer="individual_q{{ $question->id }}_answer"
                                            value="3"
                                            name="individual_q{{ $question->id }}_answer"
                                            id="individual_q{{ $question->id }}_answer_3"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="individual_q{{ $question->id }}_answer_3"
                                               class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                                    </div>
                                </div>
                            @endif
                        </fieldset>
                        <div class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <label>
                                    <input
                                        wire:model.defer="individual_q{{ $question->id }}_danger"
                                        id="individual_q{{ $question->id }}_danger"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                                    />
                                </label>
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="individual_q{{ $question->id }}_danger" class="font-medium text-red-500">Flag as
                                    high
                                    risk</label>
                            </div>
                        </div>
                        <div>
                            <label class="text-base font-semibold text-gray-900">Comments</label>
                            <textarea wire:model.defer="individual_q{{ $question->id }}_comment"
                                      id="individual_q{{ $question->id }}_comment"
                                      name="individual_q{{ $question->id }}_comment"
                                      rows="3"
                                      class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="border border-gray-200 shadow-sm rounded-xl p-5 space-y-7">
                <label class="text-base font-semibold text-gray-900">Image Upload</label>
                <!-- Images -->
                <x-media-library-collection
                    multiple
                    max-items="6"
                    rules="mimes:png,jpeg"
                    name="audit_images"
                    :model="$individualAudit"
                    collection="individual_audit_images"
                />
            </div>
        </div>
        <div class="w-full sticky bottom-0 bg-arm-blue-200 p-3 z-20">
            <div class="flex justify-evenly">
                <a
                    class="sm:mr-auto sm:ml-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 hover:cursor-pointer"
                    wire:click.prevent="update($exit = true, {{ $store }})"
                >
                    Exit
                </a>
                <input type="search" name="search" id="search"
                       wire:model="search"
                       class="block sm:w-1/4 w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm mx-5"
                       placeholder="Search Questions...">
                <button
                    wire:click.prevent="update($exit = false)"
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
            </div>
        </div>
    </form>
</div>
