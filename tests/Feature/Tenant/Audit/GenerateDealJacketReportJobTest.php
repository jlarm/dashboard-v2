<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

beforeEach(function (): void {
    Pdf::fake();
});

it('renders the deal-jacket pdf view with the group and aggregated issue data', function (): void {
    $store = Store::query()->firstOrFail();
    $group = DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $store->id,
        'completed' => true,
    ]);

    // One jacket with two "no" responses (two issues).
    DealJacket::query()->create([
        'uuid' => (string) Str::uuid(),
        'deal_jacket_group_id' => $group->id,
        'user_id' => $this->consultant->id,
        'customer_name' => 'Customer A',
        'customer_deal_number' => 'A-001',
        'mileage' => 12345,
        'purchase_type' => 'finance',
        'vehicle_type' => 'new',
        'audit_date' => now()->subDay(),
        'date_of_deal_jacket' => now()->subDays(5),
        'responses' => [
            ['statement' => 'Signed disclosure?', 'answer' => 'yes'],
            ['statement' => 'Income verified?', 'answer' => 'no', 'comment' => 'Missing W2'],
            ['statement' => 'Insurance attached?', 'answer' => 'no', 'comment' => ''],
        ],
        'total_passed' => 1,
        'total_failed' => 2,
        'total_high_risk' => 0,
        'percentage' => 33,
    ]);

    new GenerateDealJacketReportJob($group, $this->consultant)->handle();

    Pdf::assertSaved(fn ($pdf, string $path): bool => str_ends_with($path, '-deal-jacket-report.pdf')
        && $pdf->viewName === 'dealer.audit.deal-jacket.pdf-report');

    Pdf::assertSaved(function ($pdf) use ($group): bool {
        $data = $pdf->viewData;

        return $data['dealJacketGroup']->id === $group->id
            && is_array($data['issuesByUser'])
            && is_array($data['dealJacketDetails'])
            && count($data['dealJacketDetails']) === 1;
    });
});

it('counts each customer issue under the assigned user when responses include nos', function (): void {
    $store = Store::query()->firstOrFail();
    $group = DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $store->id,
        'completed' => true,
    ]);

    DealJacket::query()->create([
        'uuid' => (string) Str::uuid(),
        'deal_jacket_group_id' => $group->id,
        'user_id' => $this->consultant->id,
        'customer_name' => 'Customer B',
        'customer_deal_number' => 'B-001',
        'mileage' => 0,
        'purchase_type' => 'cash',
        'vehicle_type' => 'used',
        'audit_date' => now()->subDay(),
        'date_of_deal_jacket' => now()->subDays(5),
        'responses' => [
            ['statement' => 'Signed disclosure?', 'answer' => 'no', 'comment' => 'Issue'],
            ['statement' => 'Income verified?', 'answer' => 'no', 'comment' => 'Issue'],
        ],
        'total_passed' => 0,
        'total_failed' => 2,
        'total_high_risk' => 0,
        'percentage' => 0,
    ]);

    new GenerateDealJacketReportJob($group, $this->consultant)->handle();

    Pdf::assertSaved(function ($pdf): bool {
        $issuesByUser = $pdf->viewData['issuesByUser'];
        $userName = $this->consultant->name;

        return ($issuesByUser[$userName] ?? null) === 2;
    });
});

it('uses "House" as the user label when a deal jacket has no user', function (): void {
    $store = Store::query()->firstOrFail();
    $group = DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $store->id,
        'completed' => true,
    ]);

    DealJacket::query()->create([
        'uuid' => (string) Str::uuid(),
        'deal_jacket_group_id' => $group->id,
        'user_id' => null,
        'customer_name' => 'Customer C',
        'customer_deal_number' => 'C-001',
        'mileage' => 0,
        'purchase_type' => 'cash',
        'vehicle_type' => 'used',
        'audit_date' => now()->subDay(),
        'date_of_deal_jacket' => now()->subDays(5),
        'responses' => [
            ['statement' => 'Signed?', 'answer' => 'no'],
        ],
        'total_passed' => 0,
        'total_failed' => 1,
        'total_high_risk' => 0,
        'percentage' => 0,
    ]);

    new GenerateDealJacketReportJob($group, $this->consultant)->handle();

    Pdf::assertSaved(function ($pdf): bool {
        $allUsers = $pdf->viewData['allUsers'];

        return in_array('House', $allUsers, true);
    });
});
