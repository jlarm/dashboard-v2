<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\GetManualsSummary;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use App\Models\User;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->user = User::query()->create([
        'name' => 'Manual Author '.uniqid(),
        'email' => 'manual-author-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
});

it('reports every manual as inactive when none are signed', function (): void {
    $summary = resolve(GetManualsSummary::class)->handleForStore($this->store);

    expect($summary->isp)->toBeFalse();
    expect($summary->osha)->toBeFalse();
    expect($summary->red_flag)->toBeFalse();
    expect($summary->cms)->toBeFalse();
});

it('flags ISP as active when a signed manual exists', function (): void {
    Isp::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->user->id,
    ]);

    $summary = resolve(GetManualsSummary::class)->handleForStore($this->store);

    expect($summary->isp)->toBeTrue();
    expect($summary->osha)->toBeFalse();
});

it('reports manuals per-store and ignores rows from other stores', function (): void {
    $otherStore = Store::query()->create(['name' => 'Other '.uniqid(), 'slug' => 'other-'.uniqid()]);
    Osha::query()->create([
        'store_id' => $otherStore->id,
        'user_id' => $this->user->id,
    ]);

    $summary = resolve(GetManualsSummary::class)->handleForStore($this->store);

    expect($summary->osha)->toBeFalse();
});

it('flags every manual as active when each type is signed', function (): void {
    Isp::query()->create(['store_id' => $this->store->id, 'user_id' => $this->user->id]);
    Osha::query()->create(['store_id' => $this->store->id, 'user_id' => $this->user->id]);
    RedFlag::query()->create(['store_id' => $this->store->id, 'user_id' => $this->user->id]);
    CmsManual::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->user->id,
        'qi_name' => 'QI Test',
        'standard_dpp_rate' => 0,
        'acknowledgement_name' => 'Acknowledger',
        'acknowledgement_signature' => 'sig',
    ]);

    $summary = resolve(GetManualsSummary::class)->handleForStore($this->store);

    expect($summary->isp)->toBeTrue();
    expect($summary->osha)->toBeTrue();
    expect($summary->red_flag)->toBeTrue();
    expect($summary->cms)->toBeTrue();
});
