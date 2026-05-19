<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Store;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\Tenant;

class GoPhishService
{
    /**
     * @return Collection<string, int|string>
     */
    public function getGroups(string $token, string $ip): Collection
    {
        $groups = Http::withoutVerifying()->get('https://'.$ip.':3333/api/groups/?api_key='.$token.'');

        return collect($groups->json())->pluck('id', 'name');
    }

    /**
     * @param  Collection<string, int|string>  $groups
     * @param  array<int, array<string, mixed>>  $userData
     */
    public function createOrUpdateGroup(Collection $groups, array $userData, Tenant $tenant, Store $store, string $token, string $ip): void
    {
        if (! array_key_exists('All '.$store->name.' Employees', $groups->toArray())) {
            $this->createGroup($groups, $userData, $tenant, $store, $token, $ip);
        } else {
            $this->updateGroup($groups->get('All '.$store->name.' Employees'), $userData, $ip, $token, $store);
        }
    }

    /**
     * @param  Collection<string, int|string>  $groups
     * @param  array<int, array<string, mixed>>  $userData
     */
    public function createGroup(Collection $groups, array $userData, Tenant $tenant, Store $store, string $token, string $ip): void
    {
        try {
            $requestBody = [
                'name' => 'All '.$store->name.' Employees',
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'.$ip.':3333/api/groups/', $requestBody);

            if ($response->status() === 200) {
                Log::info($store->name.' Group Created');
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $userData
     */
    public function updateGroup(int|string $groupId, array $userData, string $ip, string $token, ?Store $store = null): void
    {
        try {
            $groupId = (string) $groupId;

            $requestBody = [
                'id' => $groupId,
                'name' => 'All '.$store->name.' Employees',
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->put('https://'.$ip.':3333/api/groups/'.$groupId.'', $requestBody);

            if ($response->status() === 200) {
                Log::info($store->name.' Group Updated');
            }

        } catch (Exception $e) {
            Log::info('Error updating group');
            Log::error($e->getMessage());
        }
    }
}
