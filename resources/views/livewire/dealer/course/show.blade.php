<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>

    <style>
        .splide__pagination__page.is-active {
            background: #333;
        }

        .splide__pagination {
            top: 0;
            bottom: auto;
        }

        .splide__track {
            padding-top: 3em;
        }

        .splide__arrows {
            height: 2em;
            margin: 0 auto;
            position: relative;
            top: -0.4em;
        }
    </style>

    <div
        x-data="{
        init() {
            new Splide(this.$refs.splide, {
                gap: '1rem',
                autoHeight: true,
                keyboard: true,
                wheel: true,
                focus: 'center',
            }).mount()
        },
    }"
    >
        <section x-ref="splide" class="splide">
            <div class="splide__track">
                <ul class="splide__list items-baseline">
                    @foreach($course['slides'] as $slide)
                        <li class="splide__slide flex flex-col items-center justify-center pb-8">
                            <h2 class="text-2xl font-bold mb-5">{{ $slide['title'] ?? '' }}</h2>
                            <span class="prose">
                                {!! $slide['description'] !!}
                            </span>
                        </li>
                    @endforeach
                    <li class="splide__slide flex flex-col items-center justify-center pb-8">
                        <div class="w-full px-5 flex justify-center">
                            <a
                                href="{{ route('dealer.courses.quiz', $course) }}"
                                class="inline-flex items-center rounded-md border border-transparent bg-arm-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-arm-green-700 focus:outline-none focus:ring-2 focus:ring-arm-green-500 focus:ring-offset-2"
                            >
                                Start Quiz
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </div>

</div>
