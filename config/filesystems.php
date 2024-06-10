<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

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

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
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

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
