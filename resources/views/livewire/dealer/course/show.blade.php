<div>
    @if($video && !$showSlidesFallback)
        <div class="space-y-5">
            <div class="max-w-4xl mx-auto">
                @if ($this->quizLink())
                    <div class="w-full flex items-center justify-between mb-6 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        @if ($this->videoCompleted())
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-2 bg-green-50 text-green-700 text-sm font-medium px-3 py-2 rounded-full border border-green-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Video Completed
                                </div>
                            </div>
                            <a
                                :href="'{{ $quizLink }}'"
                                class="flex gap-3 px-4 py-2 text-sm font-semibold text-white bg-arm-blue-500 hover:bg-arm-blue-600 rounded-lg"
                            >
                                {{ __('Take the Quiz') }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-2 bg-gray-50 text-gray-600 text-sm font-medium px-3 py-2 rounded-full border border-gray-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                    Watch to continue
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if($video && isset($video['player_embed_url']))
                    <div class="relative">
                        <div id="video-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100 rounded-lg z-10">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="animate-spin h-8 w-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600 text-sm font-medium">Loading video...</span>
                            </div>
                        </div>
                        <div id="video-error" class="hidden absolute inset-0 flex items-center justify-center bg-red-50 rounded-lg z-10">
                            <div class="flex flex-col items-center gap-3 text-center p-6">
                                <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-900">Unable to Load Video</h3>
                                    <p class="text-sm text-red-700 mt-2" id="error-message">The video failed to load. Please try refreshing the page.</p>
                                </div>
                                <div class="flex gap-3 mt-4">
                                    <button onclick="window.location.reload()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                                        Refresh Page
                                    </button>
                                    @if($course->slides && count($course->slides) > 0)
                                        <button onclick="Livewire.emit('showSlidesFallback')" class="px-4 py-2 bg-arm-blue-600 hover:bg-arm-blue-700 text-white rounded-lg text-sm font-medium">
                                            View Slides Instead
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <iframe src="{{ $video['player_embed_url'] }}{{ $this->videoCompleted() ? '' : (str_contains($video['player_embed_url'], '?') ? '&' : '?') . 'progress_bar=0' }}" encrypted-media class="w-full h-[500px] rounded-xl border"></iframe>
                    </div>
                @else
                    <div class="flex items-center justify-center bg-red-50 rounded-lg p-8">
                        <div class="flex flex-col items-center gap-3 text-center">
                            <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-red-900">Video Not Available</h3>
                                <p class="text-sm text-red-700 mt-2">Unable to retrieve video information. The video may have been removed or there may be a connection issue.</p>
                            </div>
                            <button onclick="window.location.reload()" class="mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                                Refresh Page
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if($video && isset($video['player_embed_url']))
            <script>
                (function() {
                    const iframe = document.querySelector('iframe');
                    const loadingElement = document.getElementById('video-loading');
                    const errorElement = document.getElementById('video-error');
                    const errorMessage = document.getElementById('error-message');
                    const LOADING_TIMEOUT = 15000; // 15 seconds
                    const SCRIPT_LOAD_TIMEOUT = 10000; // 10 seconds to load Vimeo script
                    const videoId = '{{ $course->video_id ?? "unknown" }}';
                    let loadingTimeout;
                    let player;
                    let scriptLoadAttempted = false;

                    function reportToSentry(error, context = {}) {
                        if (window.Sentry) {
                            Sentry.captureException(error, {
                                tags: {
                                    video_source: 'vimeo',
                                    video_id: videoId
                                },
                                extra: {
                                    ...context,
                                    video_url: iframe ? iframe.src : 'unknown'
                                }
                            });
                        }
                    }

                    function showError(message, error = null, context = {}) {
                        console.error('[Vimeo Error]', message, error);
                        if (loadingElement) loadingElement.style.display = 'none';
                        if (errorElement) errorElement.classList.remove('hidden');
                        if (errorMessage) errorMessage.textContent = message;

                        if (error) {
                            reportToSentry(error, { errorMessage: message, ...context });
                        }
                    }

                    function hideLoading() {
                        clearTimeout(loadingTimeout);
                        if (loadingElement) loadingElement.style.display = 'none';
                    }

                    function initializePlayer() {
                        if (!iframe) {
                            console.error('[Vimeo] No iframe found');
                            return;
                        }

                        if (typeof Vimeo === 'undefined') {
                            const scriptError = new Error('Vimeo Player API script failed to load');
                            showError('Unable to load video player. Please refresh the page or check your internet connection.', scriptError, { errorType: 'script_load_failure' });
                            return;
                        }

                        // Set timeout for player loading
                        loadingTimeout = setTimeout(() => {
                            const timeoutError = new Error('Vimeo video loading timeout');
                            showError('Video is taking too long to load. This may be due to network issues or the video service being unavailable. Please check your connection and try again.', timeoutError, { errorType: 'timeout' });
                        }, LOADING_TIMEOUT);

                        try {
                            player = new Vimeo.Player(iframe);

                            player.ready()
                                .then(() => {
                                    hideLoading();
                                    console.log('[Vimeo] Player ready');
                                })
                                .catch((error) => {
                                    showError('Failed to initialize video player: ' + error.message, error, { errorType: 'player_init' });
                                });

                            player.on('error', (error) => {
                                const errorMsg = error.message || 'Unknown error';
                                showError('Video playback error: ' + errorMsg, new Error(errorMsg), { errorType: 'playback', vimeoError: error });
                            });

                            player.on('ended', () => {
                                Livewire.emit('markVideoCompleted');

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            });

                        } catch (error) {
                            showError('Failed to create video player: ' + error.message, error, { errorType: 'player_creation' });
                        }
                    }

                    function loadVimeoScript() {
                        return new Promise((resolve, reject) => {
                            // Check if already loaded
                            if (typeof Vimeo !== 'undefined') {
                                console.log('[Vimeo] Script already loaded');
                                resolve();
                                return;
                            }

                            // Create script element
                            const script = document.createElement('script');
                            script.src = 'https://player.vimeo.com/api/player.js';
                            script.async = true;

                            script.onload = () => {
                                console.log('[Vimeo] Script onload fired');

                                // Wait a bit for Vimeo to initialize
                                setTimeout(() => {
                                    if (typeof Vimeo !== 'undefined') {
                                        console.log('[Vimeo] Script loaded and Vimeo object available');
                                        resolve();
                                    } else {
                                        console.error('[Vimeo] Script loaded but Vimeo object not available');
                                        const vimeoUndefinedError = new Error('Vimeo object undefined after script load');
                                        reportToSentry(vimeoUndefinedError, {
                                            errorType: 'vimeo_object_undefined',
                                            scriptSrc: script.src,
                                            windowVimeo: typeof window.Vimeo,
                                            globalVimeo: typeof Vimeo,
                                            windowKeys: Object.keys(window).filter(k => k.toLowerCase().includes('vimeo'))
                                        });
                                        reject(vimeoUndefinedError);
                                    }
                                }, 100);
                            };

                            script.onerror = (error) => {
                                console.error('[Vimeo] Script failed to load', error);
                                const loadError = new Error('Failed to load Vimeo Player API script from CDN');
                                reportToSentry(loadError, {
                                    errorType: 'script_load_error',
                                    scriptSrc: script.src,
                                    networkError: error.toString(),
                                    errorType_detail: error.type || 'unknown'
                                });
                                reject(loadError);
                            };

                            // Set timeout for script loading
                            const timeout = setTimeout(() => {
                                script.onerror = null;
                                script.onload = null;
                                console.error('[Vimeo] Script load timeout');
                                const timeoutError = new Error('Vimeo Player API script load timeout');
                                reportToSentry(timeoutError, {
                                    errorType: 'script_load_timeout',
                                    scriptSrc: script.src,
                                    timeoutDuration: SCRIPT_LOAD_TIMEOUT,
                                    scriptInDom: document.head.contains(script),
                                    scriptReadyState: script.readyState
                                });
                                reject(timeoutError);
                            }, SCRIPT_LOAD_TIMEOUT);

                            script.addEventListener('load', () => clearTimeout(timeout), { once: true });
                            script.addEventListener('error', () => clearTimeout(timeout), { once: true });

                            console.log('[Vimeo] Attempting to load script from:', script.src);
                            document.head.appendChild(script);
                            scriptLoadAttempted = true;
                        });
                    }

                    // Load and initialize
                    console.log('[Vimeo] Starting video player initialization');
                    loadVimeoScript()
                        .then(() => {
                            console.log('[Vimeo] Script load promise resolved');
                            // Double-check Vimeo is available
                            if (typeof Vimeo === 'undefined') {
                                const error = new Error('Vimeo object not available after script load');
                                reportToSentry(error, {
                                    errorType: 'vimeo_still_undefined',
                                    windowVimeo: typeof window.Vimeo
                                });
                                throw error;
                            }
                            initializePlayer();
                        })
                        .catch((error) => {
                            console.error('[Vimeo] Error during initialization:', error);
                            showError(
                                'Unable to load video player. This may be due to a content blocker, firewall, or network restriction. Please check your browser extensions or try a different network.',
                                error,
                                {
                                    errorType: 'script_load_failed',
                                    scriptAttempted: scriptLoadAttempted,
                                    userAgent: navigator.userAgent,
                                    errorMessage: error.message,
                                    errorStack: error.stack
                                }
                            );
                        });
                })();
            </script>
        @endif
    @else
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
        <div>
            @foreach($slides as $index => $slide)
                <article x-show="activeSlide === {{ $index }}" class="space-y-5" x-cloak>
                    <h1 class="font-bold">{{ isset($slide['title']) ? __($slide['title']) : __($course->name) }}</h1>
                    <div class="prose min-w-full">
                        {!! Blade::render(__($slide['description'])) !!}
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
                        {{ __('Previous') }}
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
                        {{ __('Next') }}
                    </button>
                    <a
                        :href="'{{ $quizLink }}'"
                        x-show="activeSlide === slidesCount - 1"
                        class="px-4 py-2 text-sm font-semibold text-white bg-arm-blue-500 hover:bg-arm-blue-600 rounded-lg"
                    >
                        {{ __('Quiz') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
