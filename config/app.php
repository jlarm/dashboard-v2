<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;
use Webklex\PDFMerger\Facades\PDFMergerFacade;

return [

    'admin_email' => env('ADMIN_EMAIL'),

    'available_locales' => [
        'English' => 'en',
        'Spanish' => 'es',
    ],

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'PDFMerger' => PDFMergerFacade::class,
    ])->toArray(),

];
