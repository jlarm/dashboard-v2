<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Log;
use Vimeo\Vimeo;

class VimeoService
{
    protected Vimeo $client;

    protected mixed $userId;

    protected int $cacheTtl = 3600;

    public function __construct()
    {
        $this->client = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token'),
        );

        $this->userId = config('services.vimeo.user_id');
    }

    public function getVideos($debug = false): ?array
    {
        if ($debug) {
            return $this->client->request('/me/videos', ['per_page' => 10], 'GET');
        }

        $cacheKey = 'vimeo_videos';

        return Cache::store('redis')->remember($cacheKey, $this->cacheTtl, function () {
            try {
                $response = $this->client->request('/me/videos', ['per_page' => 10], 'GET');

                if (isset($response['body']['data']) && ! isset($response['body']['error'])) {
                    $videos = [];

                    foreach ($response['body']['data'] as $video) {
                        $parts = explode('/', $video['uri']);
                        $videoId = end($parts);

                        $videos[] = [
                            'id' => $videoId,
                            'title' => $video['name'] ?? 'Untitled',
                            'thumbnail' => ! empty($video['pictures']['sizes']) ?
                                end($video['pictures']['sizes'])['link'] : null,
                            'category' => $video['parent_folder']['name'] ?? null,
                        ];
                    }

                    return $videos;
                }

                return null;
            } catch (Exception $e) {
                Log::error('Vimeo API Error: '.$e->getMessage());

                return null;
            }
        });
    }

    public function getCategories(): array
    {
        $cacheKey = 'vimeo_categories';

        return Cache::store('redis')->remember($cacheKey, $this->cacheTtl, function () {
            $response = $this->client->request('/me/videos', ['per_page' => 10], 'GET');

            if (isset($response['body']['data']) && ! isset($response['body']['error'])) {
                $categories = [];

                foreach ($response['body']['data'] as $video) {
                    $categories[] = $video['parent_folder']['name'];
                }

                return array_unique($categories);
            }

            return [];
        });
    }

    public function getVideo($videoId): ?array
    {
        $cacheKey = "vimeo_video_{$videoId}";

        return Cache::store('redis')->remember($cacheKey, $this->cacheTtl, function () use ($videoId) {
            try {
                $response = $this->client->request("/videos/{$videoId}", [], 'GET');

                if (isset($response['body']) && ! isset($response['body']['error'])) {
                    $video = $response['body'];

                    return [
                        'id' => $videoId,
                        'player_embed_url' => $video['player_embed_url'],
                        'title' => $video['name'] ?? 'Untitled',
                        'duration' => $video['duration'] ?? 0,
                        'url' => $video['player_embed_url'],
                    ];
                }

                return null;
            } catch (Exception $e) {
                Log::error('Vimeo API Error: '.$e->getMessage());

                return null;
            }
        });
    }

    public static function totalVideos(): int
    {
        $cacheKey = 'vimeo_total_videos';

        return Cache::store('redis')->remember($cacheKey, 3600, function () {
            $vimeoService = new self;

            return count($vimeoService->getVideos());
        });
    }

    public function clearCache(): void
    {
        Cache::forget('vimeo_videos');
        Cache::forget('vimeo_categories');
    }

    public function clearVideoCache($videoId): void
    {
        Cache::forget("vimeo_video_{$videoId}");
    }
}
