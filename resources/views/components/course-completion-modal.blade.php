@props([
    'score' => session('flash.quizPercentage'),
    'passed' => session('flash.quizPassed'),
    'name' => session('flash.courseName'),
    'courseUrl' => session('flash.courseUrl'),
    'incorrectQuestions' => session('flash.quizIncorrectQuestions', []),
    ])
<div
    x-data="{{json_encode(['show' => true, 'score' => $score, 'passed' => $passed, 'name' => $name, 'courseUrl' => $courseUrl, 'incorrectQuestions' => $incorrectQuestions])}}"
    style="display: none;"
    x-show="show && name"
    class="relative z-50"
>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                <div>
                    <div x-show="passed" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div x-show="!passed" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                            <span x-text="name"></span>
                            <span x-show="passed">{{ __('Passed') }}!</span>
                            <span x-show="!passed">{{ __('Failed') }}!</span>
                        </h3>
                        <div class="mt-2">
                            <p x-show="passed" class="text-sm text-gray-500">{{ __('Congratulations, you passed with a score of') }} <span x-text="score"></span>%. {{ __('We will notify you when this course needs to be retaken') }}.</p>
                            <p x-show="!passed" class="text-sm text-gray-500">{{ __('Unfortunately, you did not pass this course. You can retake the quiz at any time.')  }}</p>
                            <div x-show="incorrectQuestions.length" class="mt-4 max-h-56 overflow-y-auto text-left">
                                <p class="mb-2 text-sm font-semibold text-gray-700">{{ __('Incorrect answers:') }}</p>
                                <ul class="space-y-3 text-sm text-gray-600">
                                    <template x-for="(item, index) in incorrectQuestions" :key="index">
                                        <li class="rounded-md bg-gray-50 p-2">
                                            <p class="font-medium text-gray-800" x-text="`${index + 1}. ${item.question}`"></p>
                                            <p>
                                                <span class="font-semibold">{{ __('Your answer:') }}</span>
                                                <span x-text="item.incorrect_answer || item.incorrect_answer_key || '-'"></span>
                                            </p>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex items-center gap-3 sm:mt-6">
                    <a
                        x-show="courseUrl"
                        :href="courseUrl"
                        class="inline-flex w-full justify-center rounded-md border border-arm-blue-600 px-3 py-2 text-sm font-semibold text-arm-blue-600 shadow-sm hover:bg-arm-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600"
                    >
                        {{ __('Back to Course') }}
                    </a>
                    <button x-on:click="show = false" type="button" class="inline-flex w-full justify-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
