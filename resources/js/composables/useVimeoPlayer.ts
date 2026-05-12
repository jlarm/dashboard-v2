import { onBeforeUnmount, onMounted, ref, type Ref } from 'vue';

declare global {
    interface Window {
        Vimeo?: { Player: new (iframe: HTMLIFrameElement) => VimeoPlayerInstance };
        Sentry?: { captureException: (e: unknown, ctx?: Record<string, unknown>) => void };
    }
}

type VimeoPlayerInstance = {
    ready: () => Promise<void>;
    on: (event: 'ended' | 'error', cb: (payload?: unknown) => void) => void;
};

const SCRIPT_SRC = 'https://player.vimeo.com/api/player.js';
const LOADING_TIMEOUT = 15_000;
const SCRIPT_TIMEOUT = 10_000;

type Options = {
    iframe: Ref<HTMLIFrameElement | null>;
    videoId: string | null;
    hasSlides: boolean;
    onEnded: () => void;
    onShowSlides: () => void;
};

export function useVimeoPlayer({ iframe, videoId, hasSlides, onEnded, onShowSlides }: Options) {
    const loading = ref(true);
    const error = ref<string | null>(null);

    let timeoutId: ReturnType<typeof setTimeout> | null = null;
    let handledError = false;

    const reportToSentry = (err: unknown, context: Record<string, unknown> = {}): void => {
        window.Sentry?.captureException(err, {
            tags: { video_source: 'vimeo', video_id: videoId ?? 'unknown' },
            extra: { ...context, video_url: iframe.value?.src ?? 'unknown' },
        });
    };

    const fail = (message: string, err?: unknown, context: Record<string, unknown> = {}): void => {
        if (handledError) return;
        handledError = true;
        loading.value = false;
        error.value = hasSlides ? `${message} You can view the slides instead.` : message;
        if (err) reportToSentry(err, { ...context, errorMessage: message });
    };

    const loadScript = (): Promise<void> => new Promise((resolve, reject) => {
        if (typeof window.Vimeo !== 'undefined') {
            resolve();
            return;
        }

        const script = document.createElement('script');
        script.src = SCRIPT_SRC;
        script.async = true;

        const timeout = setTimeout(() => {
            const err = new Error('Vimeo Player API script load timeout');
            reportToSentry(err, { errorType: 'script_load_timeout' });
            reject(err);
        }, SCRIPT_TIMEOUT);

        script.onload = () => {
            setTimeout(() => {
                clearTimeout(timeout);
                if (typeof window.Vimeo !== 'undefined') {
                    resolve();
                } else {
                    const err = new Error('Vimeo object undefined after script load');
                    reportToSentry(err, { errorType: 'vimeo_object_undefined' });
                    reject(err);
                }
            }, 100);
        };

        script.onerror = (evt) => {
            clearTimeout(timeout);
            const err = new Error('Failed to load Vimeo Player API script from CDN');
            reportToSentry(err, { errorType: 'script_load_error', networkError: String(evt) });
            reject(err);
        };

        document.head.appendChild(script);
    });

    const initPlayer = (): void => {
        const el = iframe.value;
        if (!el || !window.Vimeo) {
            fail('Unable to load video player.', new Error('Vimeo Player API unavailable'), { errorType: 'script_load_failure' });
            return;
        }

        const blockMenu = (e: Event): void => e.preventDefault();
        el.addEventListener('contextmenu', blockMenu);

        timeoutId = setTimeout(() => {
            fail('Video is taking too long to load.', new Error('Vimeo video loading timeout'), { errorType: 'timeout' });
        }, LOADING_TIMEOUT);

        try {
            const player = new window.Vimeo.Player(el);

            player.ready().then(() => {
                if (timeoutId) clearTimeout(timeoutId);
                loading.value = false;
            }).catch((err) => {
                fail('Failed to initialize video player.', err, { errorType: 'player_init' });
            });

            player.on('error', (payload) => {
                fail('Video playback error.', payload, { errorType: 'playback' });
            });

            player.on('ended', () => {
                onEnded();
            });
        } catch (err) {
            fail('Failed to create video player.', err, { errorType: 'player_creation' });
        }
    };

    onMounted(() => {
        if (!videoId) {
            loading.value = false;
            return;
        }

        loadScript()
            .then(initPlayer)
            .catch((err) => fail(
                'Unable to load video player. This may be due to a content blocker, firewall, or network restriction.',
                err,
                { errorType: 'script_load_failed' },
            ));
    });

    onBeforeUnmount(() => {
        if (timeoutId) clearTimeout(timeoutId);
    });

    return { loading, error, showSlidesFallback: onShowSlides };
}
