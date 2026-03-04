<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use App\Models\User;

class StoreCreator
{
    /**
     * @param  array{name: string, address: string, city: string, state: string, postal_code: string, phone: string, website: string}  $attributes
     */
    public function create(array $attributes): Store
    {
        $store = Store::query()->create([
            'name' => $attributes['name'],
            'address' => $attributes['address'],
            'city' => $attributes['city'],
            'state' => $attributes['state'],
            'postal_code' => $attributes['postal_code'],
            'phone' => $attributes['phone'],
            'website' => $attributes['website'],
        ]);

        StoreSettings::query()->create([
            'store_id' => $store->id,
            'name' => $store->name,
            'address' => $store->address,
            'city' => $store->city,
            'state' => $store->state,
            'postal_code' => $store->postal_code,
            'phone' => $store->phone,
            'website' => $store->website,
        ]);

        EmployeeList::query()->create(['store_id' => $store->id]);
        ScanSetting::query()->create(['store_id' => $store->id]);

        $this->syncUsersForFirstStore($store);

        return $store;
    }

    private function syncUsersForFirstStore(Store $store): void
    {
        if (Store::query()->count() !== 1) {
            return;
        }

        $users = User::query()->with('roles')->get();

        foreach ($users as $user) {
            if (! $user->hasAnyRole(['super-admin', 'Consultant'])) {
                $user->stores()->syncWithoutDetaching([$store->id]);
            }

            if ($user->current_store_id === null) {
                $user->update(['current_store_id' => $store->id]);
            }
        }
    }
}
