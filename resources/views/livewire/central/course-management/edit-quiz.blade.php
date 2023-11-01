<div>
    <div class="bg-white rounded-md p-6">
        <div class="space-y-10">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">{{ $name }}</h1>
            <div class="space-y-10">
                @foreach($questions as $question)
                    <div class="space-y-5">
                        <div>
                            <x-input-label>Question:</x-input-label>
                            <x-text-input
                                wire:model="questions.{{ $loop->index }}.question"
                                id="questions.{{ $loop->index }}.question"
                                class="block mt-1 w-full"
                                type="text"
                                name="questions.{{ $loop->index }}.question"
                                :value="old('questions.{{ $loop->index }}.question')"
                                required
                            />
                        </div>
                        <div>
                            <x-input-label>Available Answers:</x-input-label>
                            @foreach($question['answers'][0] as $key => $value)
                                <div class="mt-2 flex rounded-md">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 bg-gray-100 text-gray-500 sm:text-sm w-[30px]">{{ $key }}</span>
                                    <input
                                        wire:model="questions.{{ $loop->parent->index }}.answers.0.{{ $key }}"
                                        type="text"
                                        class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        placeholder="www.example.com"
                                    />
                                    <button type="button"
                                            class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 py-1.5 px-2.5 ml-5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                            <button type="button"
                                    class="inline-flex items-center gap-x-1.5 rounded-md mt-2 bg-arm-blue-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="-ml-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>

                                Add New Answer
                            </button>
                        </div>
                        <div>
                            <x-input-label>Correct Answer:</x-input-label>
                            <x-text-input
                                wire:model="questions.{{ $loop->index }}.correctAnswer"
                                id="questions.{{ $loop->index }}.correctAnswer"
                                class="block mt-1 w-full"
                                type="text"
                                name="questions.{{ $loop->index }}.correctAnswer"
                                :value="old('questions.{{ $loop->index }}.correctAnswer')"
                                required
                            />
                        </div>
                    </div>
                @endforeach
                <x-primary-button>Update</x-primary-button>
            </div>
        </div>
    </div>
</div>
