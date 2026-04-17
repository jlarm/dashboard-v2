<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\StoreServiceProvider;
use App\Providers\TelescopeServiceProvider;
use App\Providers\TenancyServiceProvider;
use App\Providers\VaporUiServiceProvider;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Webklex\PDFMerger\Facades\PDFMergerFacade;
use Webklex\PDFMerger\Providers\PDFMergerServiceProvider;
use WireElements\Pro\Components\Modal\ModalServiceProvider;
use WireElements\Pro\Components\SlideOver\SlideOverServiceProvider;
use WireElements\Pro\WireElementsProServiceProvider;

return [

    'admin_email' => env('ADMIN_EMAIL'),

    'available_locales' => [
        'English' => 'en',
        'Spanish' => 'es',
    ],


    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'Excel' => Excel::class,
        'PDFMerger' => PDFMergerFacade::class,
    ])->toArray(),

];
