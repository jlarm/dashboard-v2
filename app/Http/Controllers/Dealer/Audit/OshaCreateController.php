<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Str;

class OshaCreateController extends Controller
{
    public function __invoke($store): RedirectResponse
    {
        $audit = OshaViolationAudit::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => $store,
            'date' => now()->format('Y-m-d'),
        ]);

        if (tenant('locations')) {
            $currentStore = Store::find($store);

            return redirect()->to(route('dealer.stores.audits.osha.edit', [$currentStore->slug, $audit->uuid]));
        }

        return redirect()->to(route('dealer.audit.osha.edit', $audit->uuid));
    }
}
