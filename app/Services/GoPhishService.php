<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoPhishService
{
    public function getGroups($token, $ip)
    {
        $groups = Http::withoutVerifying()->get('https://'.$ip.':3333/api/groups/?api_key='.$token.'');

        return collect($groups->json())->pluck('id', 'name');
    }

    public function createOrUpdateGroup($groups, $userData, $tenant, $store, $token, $ip)
    {
        if (! array_key_exists('All '.$store->name.' Employees', $groups->toArray())) {
            $this->createGroup($groups, $userData, $tenant, $store, $token, $ip);
        } else {
            $this->updateGroup($groups->get('All '.$store->name.' Employees'), $userData, $ip, $token, $store);
        }
    }

    public function createGroup($groups, $userData, $tenant, $store, $token, $ip)
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

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function updateGroup($groupId, $userData, $ip, $token, $store = null)
    {
        try {
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

        } catch (\Exception $e) {
            Log::info('Error updating group');
            Log::error($e->getMessage());
        }
    }
}
