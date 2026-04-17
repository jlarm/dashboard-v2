<?php

declare(strict_types=1);

return [

    'disks' => [
        'courses' => [
            'driver' => 'local',
            'root' => storage_path('/app/courses'),
            'url' => env('APP_URL').'/courses',
            'visibility' => 'public',
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'tmp-for-tests' => [
            'driver' => 'local',
            'root' => storage_path('framework/testing/disks/tmp-for-tests'),
            'throw' => false,
        ],

        'digitalocean' => [
            'driver' => 's3',
            'key' => env('DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'do-audits' => [
            'driver' => 's3',
            'key' => env('AUDITS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('AUDITS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('AUDITS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('AUDITS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('AUDITS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'do-manuals' => [
            'driver' => 's3',
            'key' => env('MANUALS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('MANUALS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('MANUALS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('MANUALS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('MANUALS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'do-scans' => [
            'driver' => 's3',
            'key' => env('SCANS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('SCANS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('SCANS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('SCANS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('SCANS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'dealer-docs' => [
            'driver' => 's3',
            'key' => env('DOCS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('DOCS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('DOCS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('DOCS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('DOCS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'armp-certs' => [
            'driver' => 's3',
            'key' => env('CERTS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('CERTS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('CERTS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('CERTS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('CERTS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'central-docs' => [
            'driver' => 's3',
            'key' => env('CENTRAL_DOCS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('CENTRAL_DOCS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('CENTRAL_DOCS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('CENTRAL_DOCS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('CENTRAL_DOCS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'armp-backups' => [
            'driver' => 's3',
            'key' => env('BACKUPS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('BACKUPS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('BACKUPS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('BACKUPS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('BACKUPS_DIGITALOCEAN_SPACES_BUCKET'),
            'visibility' => 'public',
        ],

        'armpcon' => [
            'driver' => 's3',
            'key' => env('CONS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('CONS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('CONS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('CONS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('CONS_DIGITALOCEAN_SPACES_BUCKET'),
        ],

        'armpaudits' => [
            'driver' => 's3',
            'key' => env('ARMP_AUDITS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('ARMP_AUDITS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('ARMP_AUDITS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('ARMP_AUDITS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('ARMP_AUDITS_DIGITALOCEAN_SPACES_BUCKET'),
        ],

        'sds-sheets' => [
            'driver' => 's3',
            'key' => env('SDS_DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('SDS_DIGITALOCEAN_SPACES_SECRET'),
            'endpoint' => env('SDS_DIGITALOCEAN_SPACES_ENDPOINT'),
            'region' => env('SDS_DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('SDS_DIGITALOCEAN_SPACES_BUCKET'),
        ],
    ],

];
