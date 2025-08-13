<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

class VimeoService
{
    protected Vimeo $client;
    protected ?string $userId;
    protected int $cacheTtl = 3600;
    protected int $perPage = 10;

    private const CACHE_KEY_VIDEOS = 'vimeo_videos';
    private const CACHE_KEY_CATEGORIES = 'vimeo_categories';
    private const CACHE_KEY_TOTAL_VIDEOS = 'vimeo_total_videos';
    private const CACHE_KEY_VIDEO_PREFIX = 'vimeo_video_';

    public function __construct()
    {
        $this->client = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token'),
        );

        $this->userId = config('services.vimeo.user_id');
    }

    public function getVideos(bool $debug = false): array
    {
        if ($debug) {
            return $this->makeRequest('/me/videos', ['per_page' => $this->perPage]);
        }

        return Cache::store('redis')->remember(
            self::CACHE_KEY_VIDEOS,
            $this->cacheTtl,
            fn () => $this->fetchAndTransformVideos()
        );
    }

    private function fetchAndTransformVideos(): ?array
    {
        try {
            $response = $this->makeRequest('/me/videos', ['per_page' => $this->perPage]);

            if (! $this->isValidResponse($response)) {
                return null;
            }

            return array_map(
                fn (array $video) => $this->transformVideoData($video),
                $response['body']['data']
            );
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error: {$e->getMessage()}");
            return null;
        }
    }

    private function transformVideoData(array $video): array
    {
        $parts = explode('/', $video['uri']);
        $videoId = end($parts);

        return [
            'id' => $videoId,
            'title' => $video['name'] ?? 'Untitled',
            'thumbnail' => $this->extractThumbnailUrl($video),
            'category' => $video['parent_folder']['name'] ?? null,
        ];
    }

    private function extractThumbnailUrl(array $video): ?string
    {
        if (empty($video['pictures']['sizes'])) {
            return null;
        }

        return end($video['pictures']['sizes'])['link'];
    }

    public function getCategories(): array
    {
        return Cache::store('redis')->remember(
            self::CACHE_KEY_CATEGORIES,
            $this->cacheTtl,
            fn () => $this->fetchCategories()
        );
    }

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
            return [];
        }
    }

    public function getVideo(string $videoId): ?array
    {
        return Cache::store('redis')->remember(
            self::CACHE_KEY_VIDEO_PREFIX . $videoId,
            $this->cacheTtl,
            fn () => $this->fetchVideo($videoId)
        );
    }

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
            ];
        } catch (VimeoRequestException|Exception $e) {
            Log::error("Vimeo API Error: {$e->getMessage()}");
            return null;
        }
    }

    public function totalVideos(): int
    {
        return Cache::store('redis')->remember(
            self::CACHE_KEY_TOTAL_VIDEOS,
            $this->cacheTtl,
            fn () => count($this->getVideos() ?? [])
        );
    }

    public function clearCache(): void
    {
        $keys = [
            self::CACHE_KEY_VIDEOS,
            self::CACHE_KEY_CATEGORIES,
            self::CACHE_KEY_TOTAL_VIDEOS,
        ];

        foreach ($keys as $key) {
            Cache::store('redis')->forget($key);
        }
    }

    public function clearVideoCache(string $videoId): void
    {
        Cache::store('redis')->forget(self::CACHE_KEY_VIDEO_PREFIX . $videoId);
    }

    private function makeRequest(string $endpoint, array $params = []): array
    {
        try {
            return $this->client->request($endpoint, $params, 'GET');
        } catch (VimeoRequestException $e) {
            Log::error("Vimeo Request Error: {$e->getMessage()}");
            throw $e;
        }
    }

    private function isValidResponse(array $response): bool
    {
        return isset($response['body']['data']) && ! isset($response['body']['error']);
    }
}
