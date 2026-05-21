<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

class VimeoService
{
    protected Vimeo $client;
    protected ?string $userId;
    protected int $perPage = 10;
    protected int $maxRetries = 3;
    protected int $retryDelayMs = 500;

    public function __construct()
    {
        $this->client = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token'),
        );

        $this->userId = config('services.vimeo.user_id');
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getVideos(bool $debug = false): array
    {
        if ($debug) {
            return $this->makeRequest('/me/videos', ['per_page' => $this->perPage]);
        }

        return $this->fetchAndTransformVideos() ?? [];
    }

    /**
     * @return array<int, string>
     */
    public function getCategories(): array
    {
        return $this->fetchCategories();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getVideo(string $videoId, bool $fresh = false): ?array
    {
        $cacheKey = "vimeo_video_{$videoId}";

        if ($fresh) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, now()->addHour(), fn (): ?array => $this->fetchVideo($videoId));
    }

    public function enableSeekButton(string $videoId): bool
    {
        try {
            $response = $this->client->request("/videos/{$videoId}", [
                'embed' => [
                    'skipping_forward' => true,
                ],
            ], 'PATCH');

            return $response['status'] === 200;
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error enabling seek for video {$videoId}: {$e->getMessage()}");

            return false;
        }
    }

    public function getPresetIdByName(string $name): ?string
    {
        try {
            $response = $this->makeRequest('/me/presets');

            if (! isset($response['body']['data'])) {
                return null;
            }

            foreach ($response['body']['data'] as $preset) {
                if (($preset['name'] ?? '') === $name) {
                    $parts = explode('/', (string) $preset['uri']);

                    return end($parts);
                }
            }

            return null;
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error fetching presets: {$e->getMessage()}");

            return null;
        }
    }

    public function assignPreset(string $videoId, string $presetId): bool
    {
        try {
            $response = $this->client->request("/videos/{$videoId}/presets/{$presetId}", [], 'PUT');

            return $response['status'] === 204;
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error assigning preset {$presetId} to video {$videoId}: {$e->getMessage()}");

            return false;
        }
    }

    public function totalVideos(): int
    {
        return count($this->getVideos());
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getVideoPrivacySettings(string $videoId): ?array
    {
        try {
            $response = $this->makeRequest("/videos/{$videoId}");

            if (! isset($response['body']) || isset($response['body']['error'])) {
                return null;
            }

            $video = $response['body'];

            return [
                'video_id' => $videoId,
                'privacy_view' => $video['privacy']['view'] ?? 'unknown',
                'privacy_embed' => $video['privacy']['embed'] ?? 'unknown',
                'embed_domains' => $video['privacy']['embed_domains'] ?? [],
                'privacy_download' => $video['privacy']['download'] ?? false,
                'password' => isset($video['password']) && ! empty($video['password']),
                'status' => $video['status'] ?? 'unknown',
                'is_playable' => ($video['status'] ?? '') === 'available',
            ];
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error checking privacy for video {$videoId}: {$e->getMessage()}");

            if (app()->bound('sentry')) {
                resolve('sentry')->captureException($e);
            }

            return null;
        }
    }

    /**
     * @return array<int, array<string, mixed>>|null
     */
    private function fetchAndTransformVideos(): ?array
    {
        try {
            $response = $this->makeRequest('/me/videos', ['per_page' => $this->perPage]);

            if (! $this->isValidResponse($response)) {
                return null;
            }

            return array_map(
                $this->transformVideoData(...),
                $response['body']['data']
            );
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error: {$e->getMessage()}");

            if (app()->bound('sentry')) {
                resolve('sentry')->captureException($e);
            }

            return null;
        }
    }

    /**
     * @param  array<string, mixed>  $video
     * @return array<string, mixed>
     */
    private function transformVideoData(array $video): array
    {
        $parts = explode('/', (string) $video['uri']);
        $videoId = end($parts);

        return [
            'id' => $videoId,
            'title' => $video['name'] ?? 'Untitled',
            'thumbnail' => $this->extractThumbnailUrl($video),
            'category' => $video['parent_folder']['name'] ?? null,
        ];
    }

    /**
     * @param  array<string, mixed>  $video
     */
    private function extractThumbnailUrl(array $video): ?string
    {
        if (empty($video['pictures']['sizes'])) {
            return null;
        }

        return end($video['pictures']['sizes'])['link'];
    }

    /**
     * @return array<int, string>
     */
    private function fetchCategories(): array
    {
        try {
            $response = $this->makeRequest('/me/videos', ['per_page' => $this->perPage]);

            if (! $this->isValidResponse($response)) {
                return [];
            }

            $categories = array_map(
                fn (array $video) => $video['parent_folder']['name'] ?? null,
                $response['body']['data']
            );

            return array_values(array_unique(array_filter($categories)));
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error: {$e->getMessage()}");

            if (app()->bound('sentry')) {
                resolve('sentry')->captureException($e);
            }

            return [];
        }
    }

    /**
     * @return array<string, mixed>|null
     */
    private function fetchVideo(string $videoId): ?array
    {
        try {
            $response = $this->makeRequest("/videos/{$videoId}");

            if (! isset($response['body']) || isset($response['body']['error'])) {
                return null;
            }

            $video = $response['body'];

            return [
                'id' => $videoId,
                'player_embed_url' => $video['player_embed_url'],
                'title' => $video['name'] ?? 'Untitled',
                'duration' => $video['duration'] ?? 0,
                'url' => $video['player_embed_url'],
                'status' => $video['status'] ?? 'unknown',
                'privacy_view' => $video['privacy']['view'] ?? null,
                'privacy_embed' => $video['privacy']['embed'] ?? null,
            ];
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error for video {$videoId}: {$e->getMessage()}");

            if (app()->bound('sentry')) {
                resolve('sentry')->captureException($e);
            }

            return null;
        }
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    private function makeRequest(string $endpoint, array $params = []): array
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->maxRetries) {
            try {
                $response = $this->client->request($endpoint, $params, 'GET');

                if ($attempt > 0) {
                    Log::info('Vimeo request succeeded on attempt '.($attempt + 1)." for endpoint: {$endpoint}");
                }

                return $response;
            } catch (VimeoRequestException $e) {
                $lastException = $e;
                $attempt++;

                if ($attempt < $this->maxRetries) {
                    $delay = $this->retryDelayMs * $attempt;
                    Log::warning("Vimeo request failed (attempt {$attempt}/{$this->maxRetries}), retrying in {$delay}ms: {$e->getMessage()}");
                    Sleep::usleep($delay * 1000);
                } else {
                    Log::error("Vimeo request failed after {$this->maxRetries} attempts: {$e->getMessage()}");

                    if (app()->bound('sentry')) {
                        resolve('sentry')->captureException($e);
                    }
                }
            }
        }

        throw $lastException;
    }

    /**
     * @param  array<string, mixed>  $response
     */
    private function isValidResponse(array $response): bool
    {
        return isset($response['body']['data']) && ! isset($response['body']['error']);
    }
}
