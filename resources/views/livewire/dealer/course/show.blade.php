<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.5.x/dist/css/glide.core.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.5.x"></script>

    <style>
        .glide__bullet--active {
            background: #333;
        }
    </style>

    <div
        x-data="{
        init() {
            new Glide(this.$refs.glide, {
                perView: 1,
                640: {
                    perView: 1,
                },
            }).mount()
        },
    }"
    >
        <div x-ref="glide" class="glide block relative px-12">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($course['slides'] as $slide)
                        <li class="glide__slide flex flex-col items-center justify-center p-6">
                            <h2 class="text-2xl font-bold mb-5">{{ $slide['title'] ?? '' }}</h2>
                            <span class="prose">
                                {!! $slide['description'] !!}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="glide__arrows pointer-events-none absolute inset-0 flex items-center justify-between" data-glide-el="controls">
                <!-- Previous Button -->
                <button
                    class="glide__arrow glide__arrow--left pointer-events-auto disabled:opacity-50"
                    data-glide-dir="<"
                >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </span>
                    <span class="sr-only">Skip to previous slide page</span>
                </button>

                <!-- Next Button -->
                <button
                    class="glide__arrow glide__arrow--left pointer-events-auto disabled:opacity-50"
                    data-glide-dir=">"
                >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </span>
                    <span class="sr-only">Skip to next slide page</span>
                </button>
            </div>

            <!-- Bullets -->
            <div class="glide__bullets flex w-full items-center justify-center gap-1" data-glide-el="controls[nav]">
                @foreach($course['slides'] as $bullet)
                    @php
                        $i = 0
                    @endphp
                    <button class="glide__bullet h-3 w-3 rounded-full bg-gray-300 transition-colors" data-glide-dir="={{ $i }}"></button>
                    @php
                        $i++
                    @endphp
                @endforeach
            </div>
        </div>
        <form method="POST" action="{{ route('dealer.courses.results.store', $course) }}">
            @csrf
            <div class="questions space-y-10">
                @php
                    $i = 1
                @endphp
                @foreach($course['questions'] as $c)
                    <div class="bg-white p-10 border-md">
                        <p class="mb-5">{{ $i }}. {{ $c['question'] }}</p>
                        @foreach($c['answers'][0] as $key => $value)
                            <label class="flex justify-start items-center space-x-3">
                                <input name="question[{{ $i }}]" type="radio" value="{{ $key }}" />
                                {{ $value }}
                            </label>
                        @endforeach
                    </div>
                    @php
                        $i++
                    @endphp
                @endforeach
                <div>
                    <x-primary-button>Submit</x-primary-button>
                </div>
            </div>
        </form>
    </div>

</div>
