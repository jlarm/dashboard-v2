<?php

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;
use Str;

class FinanceCreateController extends Controller
{
    public function __invoke($store): RedirectResponse
    {
        $audit = GlbaViolationAudit::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => $store,
            'date' => now()->format('Y-m-d'),
        ]);

        if (tenant('locations')) {
            $currentStore = Store::find($store);

            return redirect()->to(route('dealer.stores.audits.finance.edit', [$currentStore->slug, $audit->uuid]));
        }

        return redirect()->to(route('dealer.audit.finance.edit', $audit->uuid));
    }
}
