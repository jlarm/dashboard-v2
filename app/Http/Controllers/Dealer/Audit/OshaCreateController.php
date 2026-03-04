<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer\Audit;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class OshaCreateController extends Controller
{
    public function __invoke($store): RedirectResponse
    {
        $audit = OshaViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => $store,
            'date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.osha.edit', $audit->uuid));
    }
}
