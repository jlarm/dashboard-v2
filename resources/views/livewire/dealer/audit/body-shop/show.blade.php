<div class="min-h-screen">
    <form class="md:px-4" wire:loading.class="opacity-25">
        <div class="space-y-5">
            <div class="ml-3 sm:ml-0">
                <label for="audit_date" class="block text-sm font-medium leading-6 text-gray-900">Audit Date</label>
                <div class="mt-2">
                    <input
                        wire:model.defer="audit_date"
                        type="date"
                        name="audit_date"
                        id="audit_date"
                        pattern=""
                        class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>
            @foreach($questions as $question)
                <div class="bg-gray-50 p-3 space-y-7" id="filtration">
                    <div>
                        <label class="text-base font-semibold text-gray-900">{{ $question->id }}
                            . {{ $question->question }}</label>
                        <fieldset class="mt-4">
                            <div class="flex items-center space-x-5">
                                <div class="flex items-center">
                                    <input
                                        wire:model.defer="body_shop_q{{ $question->id }}_answer"
                                        value="1"
                                        name="body_shop_q{{ $question->id }}_answer"
                                        id="body_shop_q{{ $question->id }}_answer_1"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                    <label for="body_shop_q{{ $question->id }}_answer_1"
                                           class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        wire:model.defer="body_shop_q{{ $question->id }}_answer"
                                        value="2"
                                        name="body_shop_q{{ $question->id }}_answer"
                                        id="body_shop_q{{ $question->id }}_answer_2"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                    <label for="body_shop_q{{ $question->id }}_answer_2"
                                           class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        wire:model.defer="body_shop_q{{ $question->id }}_answer"
                                        value="3"
                                        name="body_shop_q{{ $question->id }}_answer"
                                        id="body_shop_q{{ $question->id }}_answer_3"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                    <label for="body_shop_q{{ $question->id }}_answer_3"
                                           class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <label>
                                <input
                                    wire:model.defer="body_shop_q{{ $question->id }}_danger"
                                    id="body_shop_q{{ $question->id }}_danger"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                                />
                            </label>
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="body_shop_q{{ $question->id }}_danger" class="font-medium text-red-500">Flag as
                                high risk</label>
                        </div>
                    </div>
                    @if($question->id == 16)
                        <div>
                            <label for="body_shop_q{{ $question->id }}_inspection_date"
                                   class="text-base font-semibold text-gray-900"
                            >Last Annual Inspection
                                Date</label>
                            <input
                                wire:model.defer="body_shop_q{{ $question->id }}_inspection_date"
                                type="date"
                                name="body_shop_q{{ $question->id }}_inspection_date"
                                id="body_shop_q{{ $question->id }}_inspection_date"
                                pattern=""
                                class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                    @endif
                    <div>
                        <label class="text-base font-semibold text-gray-900">Comments</label>
                        <textarea wire:model.defer.lazy="body_shop_q{{ $question->id }}_comment"
                                  id="body_shop_q{{ $question->id }}_comment"
                                  name="body_shop_q{{ $question->id }}_comment"
                                  rows="3"
                                  class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                    <x-media-library-collection
                        multiple
                        max-items="2"
                        rules="mimes:png,jpeg"
                        name="body_shop_q{{ $question->id }}_images"
                        :model="$bodyShopAudit"
                        collection="body_shop_q{{ $question->id }}_images"
                    />
                </div>
            @endforeach
            <!-- Additional Notes  -->
            <div class="bg-gray-50 p-3">
                <div class="space-y-7">
                    <label class="text-base font-semibold text-gray-900">Additional Notes:</label>
                    <div>
                    <textarea wire:model.defer="body_shop_q44_comment" rows="3"
                              class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
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
