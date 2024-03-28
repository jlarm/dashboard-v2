<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'api'
])->group(function () {
    Route::post('/webhooks/{tenant_id}/gophish/', 'App\Http\Controllers\WebhookController@gophish')->name('webhooks.gophish');
});
