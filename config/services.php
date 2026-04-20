<?php

declare(strict_types=1);

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
        'webhook_signing_key' => env('MAILGUN_WEBHOOK_SIGNING_KEY'),
    ],

    'vimeo' => [
        'client_id' => env('VIMEO_CLIENT_ID'),
        'client_secret' => env('VIMEO_CLIENT_SECRET'),
        'access_token' => env('VIMEO_ACCESS_TOKEN'),
        'user_id' => env('VIMEO_USER_ID'),
        'project_id' => env('VIMEO_PROJECT_ID'),
    ],

    'cyrisma' => [
        'api_key' => env('CYRISMA_API_KEY'),
        'api_secret' => env('CYRISMA_API_SECRET'),
        'base_url' => env('CYRISMA_API_BASE_URL', 'https://api.cyrisma.com/app'),
    ],

    'dealership' => [
        'notification_email' => env('DEALERSHIP_NOTIFICATION_EMAIL', 'jlohr@autorisknow.com'),
    ],

];
