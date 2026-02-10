<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Audit;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;

class BodyShopCreateController extends Controller
{
    public function __invoke($store): RedirectResponse
    {
        $audit = BodyShopViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => $store,
            'date' => now()->format('Y-m-d'),
        ]);

        if (tenant('locations')) {
            $currentStore = Store::query()->find($store);

            return redirect()->to(route('dealer.stores.audits.body-shop.edit', [$currentStore->slug, $audit->uuid]));
        }

        return redirect()->to(route('dealer.audit.body-shop.edit', $audit->uuid));
    }
}
