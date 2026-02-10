<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\RedirectResponse;

class FinanceCreateController extends Controller
{
    public $store;
    public function __invoke(): RedirectResponse
    {
        $audit = FinanceAudit::query()->create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::query()->first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('dealer.audit.finance.show', $audit->id);
    }
}
