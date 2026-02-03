<div>
    <div class="space-y-5">
        <div class="flex justify-start items-center gap-3">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">{{ $video['title'] }}</h1>
            @if ($this->videoCompleted())
                <div class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                    Completed
                </div>
            @endif
        </div>

        <div class="w-full max-w-4xl mx-auto">
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
                        <button onclick="window.location.reload()" class="mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                            Refresh Page
                        </button>
                    </div>
                </div>
                <iframe src="{{ $video['player_embed_url'] }}" encrypted-media class="w-full h-[500px]"></iframe>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const iframe = document.querySelector('iframe');
            const loadingElement = document.getElementById('video-loading');
            const errorElement = document.getElementById('video-error');
            const errorMessage = document.getElementById('error-message');
            const LOADING_TIMEOUT = 15000;
            const SCRIPT_LOAD_TIMEOUT = 10000;
            let loadingTimeout;
            let player;
            let errorAlreadyHandled = false;

            // Catch unhandled Vimeo promise rejections
            window.addEventListener('unhandledrejection', function(event) {
                const reason = event.reason;
                const isVimeoError = reason &&
                    (reason.message?.includes('playback') ||
                     reason.message?.includes('Vimeo') ||
                     reason.name === 'Error' && event.promise?.toString?.().includes('vimeo'));
                const stackMentionsVimeo = reason?.stack?.includes('player.vimeo.com');

                if (isVimeoError || stackMentionsVimeo) {
                    event.preventDefault();
                    if (!errorAlreadyHandled) {
                        errorAlreadyHandled = true;
                        showError('Video playback was interrupted. This may be due to network issues.');
                    }
                }
            });

            function showError(message) {
                console.error('[Vimeo Error]', message);
                clearTimeout(loadingTimeout);
                if (loadingElement) loadingElement.style.display = 'none';
                if (errorElement) errorElement.classList.remove('hidden');
                if (errorMessage) errorMessage.textContent = message;
            }

            function hideLoading() {
                clearTimeout(loadingTimeout);
                if (loadingElement) loadingElement.style.display = 'none';
            }

            function initializePlayer() {
                if (!iframe || typeof Vimeo === 'undefined') {
                    showError('Unable to load video player. Please refresh the page.');
                    return;
                }

                loadingTimeout = setTimeout(() => {
                    showError('Video is taking too long to load. Please check your connection and try again.');
                }, LOADING_TIMEOUT);

                try {
                    player = new Vimeo.Player(iframe);

                    player.ready()
                        .then(() => {
                            hideLoading();
                        })
                        .catch((error) => {
                            showError('Failed to initialize video player: ' + error.message);
                        });

                    player.on('error', (error) => {
                        if (!errorAlreadyHandled) {
                            errorAlreadyHandled = true;
                            showError('Video playback error: ' + (error.message || 'Unknown error'));
                        }
                    });

                    player.on('ended', () => {
                        Livewire.emit('completedVideo');
                    });

                } catch (error) {
                    showError('Failed to create video player: ' + error.message);
                }
            }

            function loadVimeoScript() {
                return new Promise((resolve, reject) => {
                    if (typeof Vimeo !== 'undefined') {
                        resolve();
                        return;
                    }

                    const script = document.createElement('script');
                    script.src = 'https://player.vimeo.com/api/player.js';
                    script.async = true;

                    const timeout = setTimeout(() => {
                        reject(new Error('Script load timeout'));
                    }, SCRIPT_LOAD_TIMEOUT);

                    script.onload = () => {
                        clearTimeout(timeout);
                        setTimeout(() => {
                            if (typeof Vimeo !== 'undefined') {
                                resolve();
                            } else {
                                reject(new Error('Vimeo object not available'));
                            }
                        }, 100);
                    };

                    script.onerror = () => {
                        clearTimeout(timeout);
                        reject(new Error('Failed to load Vimeo script'));
                    };

                    document.head.appendChild(script);
                });
            }

            loadVimeoScript()
                .then(() => initializePlayer())
                .catch((error) => {
                    showError('Unable to load video player. Please check your internet connection or try refreshing the page.');
                });
        })();
    </script>
</div>
