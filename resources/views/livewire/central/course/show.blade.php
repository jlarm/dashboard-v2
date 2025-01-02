<div
    x-data="{
        activeSlide: 0,
        percentage: 0,
        slidesCount: {{ count($slides) }},
        init() {
            this.percentage = Math.round(((this.activeSlide + 1) / this.slidesCount) * 100);
            this.$watch('activeSlide', value => {
                this.percentage = Math.round(((value + 1) / this.slidesCount) * 100);
            });
        }
    }"
    x-init="init"
>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">{{ $course->name }}</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <div class="flex justify-end">

            </div>
        </div>
    </div>

    <div class="mt-5">
        @foreach($slides as $index => $slide)
            <article x-show="activeSlide === {{ $index }}" class="border rounded-lg p-5 space-y-5" x-cloak>
                <h1 class="font-bold">{{ $slide['title'] ?? '' }}</h1>
                <div class="prose min-w-full">
                    {!! $slide['description'] !!}
                </div>
            </article>
        @endforeach
        <div class="mt-5">
            <div class="flex justify-between items-center gap-10">
                <button
                    :disabled="activeSlide === 0"
                    @click="activeSlide--"
                    class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg"
                >
                    Previous
                </button>
                <!-- Progress -->
                <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-arm-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500" x-bind:style="'width: ' + percentage + '%;'"></div>
                </div>
                <button
                    x-show="activeSlide < slidesCount - 1"
                    @click="activeSlide++"
                    class="px-4 py-2 text-sm font-semibold text-white bg-arm-orange-500 hover:bg-orange-600 rounded-lg"
                >
                    Next
                </button>
                <a
                    :href="'{{ $quizLink }}'"
                    x-show="activeSlide === slidesCount - 1"
                    class="px-4 py-2 text-sm font-semibold text-white bg-arm-blue-500 hover:bg-arm-blue-600 rounded-lg"
                >
                    Quiz
                </a>
            </div>
        </div>
    </div>
</div>
