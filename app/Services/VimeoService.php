<?php

namespace App\Services;

use Exception;
use Log;
use Vimeo\Vimeo;

class VimeoService
{
    protected $client;
    protected $userId;
    public function __construct()
    {
        $this->client = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token') // Pass access token directly here
        );

        $this->userId = config('services.vimeo.user_id');
    }

    /**
     * Get videos from the team library
     * Debug mode returns the raw response to help troubleshoot
     */
    public function getVideos($debug = false): ?array
    {
        try {
            // Try direct team access first
            $response = $this->client->request('/me/videos', ['per_page' => 10], 'GET');

            if ($debug) {
                return $response;
            }

            if (isset($response['body']['data']) && !isset($response['body']['error'])) {
                $videos = [];

                foreach ($response['body']['data'] as $video) {
                    // Extract video ID from URI (format: "/videos/123456789")
                    $parts = explode('/', $video['uri']);
                    $videoId = end($parts);

                    $videos[] = [
                        'id' => $videoId,
                        'title' => $video['name'] ?? 'Untitled',
                        'thumbnail' => !empty($video['pictures']['sizes']) ?
                            end($video['pictures']['sizes'])['link'] : null,
                        'category' => $video['parent_folder']['name'] ?? null
                    ];
                }

                return $videos;
            }

            return null;
        } catch (Exception $e) {
            // Log the error
            Log::error('Vimeo API Error: ' . $e->getMessage());
            return $debug ? ['error' => $e->getMessage()] : null;
        }
    }

    public function getCategories(): array
    {
        $response = $this->client->request('/me/videos', ['per_page' => 10], 'GET');

        if (isset($response['body']['data']) && !isset($response['body']['error'])) {
            $categories = [];

            foreach ($response['body']['data'] as $video) {
                $categories[] = $video['parent_folder']['name'];
            }

            return array_unique($categories);
        }

        return [];
    }

    /**
     * Get a specific video's data
     */
    public function getVideo($videoId): ?array
    {
        try {
            $response = $this->client->request("/videos/{$videoId}", [], 'GET');

            if (isset($response['body']) && !isset($response['body']['error'])) {
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
            Log::error('Vimeo API Error: ' . $e->getMessage());
            return null;
        }
    }
}
