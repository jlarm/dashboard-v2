<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateDocsPillar;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

it('scores 0 when the store has no manuals', function (): void {
    $store = Store::query()->firstOrFail();

    $pillar = (new CalculateDocsPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBe(0.0);
    foreach (['isp', 'osha', 'red_flag', 'cms'] as $key) {
        expect($pillar->breakdown['types'][$key]['state'])->toBe('missing');
    }
});

it('scores 100 when all four manuals are signed and fresh', function (): void {
    $store = Store::query()->firstOrFail();
    $signedAt = CarbonImmutable::now()->subMonths(2);

    makeIsp($store, $signedAt);
    makeOsha($store, $signedAt);
    makeRedFlag($store, $signedAt);
    makeCms($store, $signedAt);

    $pillar = (new CalculateDocsPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->score)->toBe(100.0);
    foreach (['isp', 'osha', 'red_flag', 'cms'] as $key) {
        expect($pillar->breakdown['types'][$key]['state'])->toBe('fresh');
    }
});

it('treats manuals signed more than 12 months ago as half-credit', function (): void {
    $store = Store::query()->firstOrFail();

    makeIsp($store, CarbonImmutable::now()->subMonths(2));
    makeOsha($store, CarbonImmutable::now()->subMonths(2));
    makeRedFlag($store, CarbonImmutable::now()->subMonths(18));
    makeCms($store, CarbonImmutable::now()->subMonths(18));

    $pillar = (new CalculateDocsPillar())->handle($store, CarbonImmutable::now());

    // 1.0 + 1.0 + 0.5 + 0.5 = 3.0 / 4 = 75%
    expect($pillar->score)->toBe(75.0);
    expect($pillar->breakdown['types']['red_flag']['state'])->toBe('stale');
    expect($pillar->breakdown['types']['cms']['state'])->toBe('stale');
});

it('counts manuals without a signature as missing', function (): void {
    $store = Store::query()->firstOrFail();

    Isp::query()->create(['store_id' => $store->id, 'user_id' => $this->consultant->id]);

    $pillar = (new CalculateDocsPillar())->handle($store, CarbonImmutable::now());

    expect($pillar->breakdown['types']['isp']['state'])->toBe('missing');
});

function setSignedAt(Model $manual, CarbonImmutable $signedAt): Model
{
    $manual->newQuery()->where('id', $manual->id)->update([
        'created_at' => $signedAt,
        'updated_at' => $signedAt,
    ]);

    return $manual->refresh();
}

function makeIsp(Store $store, CarbonImmutable $signedAt): Isp
{
    $manual = Isp::query()->create([
        'store_id' => $store->id,
        'user_id' => App\Models\User::query()->where('email', 'test@test-tenant.localhost')->value('id'),
        'signature' => 'data:image/png;base64,signed',
    ]);

    setSignedAt($manual, $signedAt);

    return $manual;
}

function makeOsha(Store $store, CarbonImmutable $signedAt): Osha
{
    $manual = Osha::query()->create([
        'store_id' => $store->id,
        'user_id' => App\Models\User::query()->where('email', 'test@test-tenant.localhost')->value('id'),
        'signature' => 'data:image/png;base64,signed',
    ]);

    setSignedAt($manual, $signedAt);

    return $manual;
}

function makeRedFlag(Store $store, CarbonImmutable $signedAt): RedFlag
{
    $manual = RedFlag::query()->create([
        'store_id' => $store->id,
        'user_id' => App\Models\User::query()->where('email', 'test@test-tenant.localhost')->value('id'),
        'signature' => 'data:image/png;base64,signed',
    ]);

    setSignedAt($manual, $signedAt);

    return $manual;
}

function makeCms(Store $store, CarbonImmutable $signedAt): CmsManual
{
    $manual = CmsManual::query()->create([
        'store_id' => $store->id,
        'user_id' => App\Models\User::query()->where('email', 'test@test-tenant.localhost')->value('id'),
        'qi_name' => 'QI',
        'standard_dpp_rate' => '0',
        'acknowledgement_name' => 'Acknowledger',
        'acknowledgement_signature' => 'data:image/png;base64,signed',
    ]);

    setSignedAt($manual, $signedAt);

    return $manual;
}
