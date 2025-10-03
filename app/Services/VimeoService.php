<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

class VimeoService
{
    protected Vimeo $client;
    protected ?string $userId;
    protected int $perPage = 10;

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

        return $this->fetchAndTransformVideos() ?? [];
    }

    public function getCategories(): array
    {
        return $this->fetchCategories();
    }

    public function getVideo(string $videoId): ?array
    {
        return $this->fetchVideo($videoId);
    }

    public function totalVideos(): int
    {
        return count($this->getVideos());
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
