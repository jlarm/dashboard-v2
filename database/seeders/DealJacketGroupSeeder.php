<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DealJacketGroupSeeder extends Seeder
{
    private $financeManagers;

    public function run(): void
    {
        $stores = Store::all();

        if ($stores->isEmpty()) {
            $this->command->warn('No stores found for this tenant.');

            return;
        }

        $this->command->info("Found {$stores->count()} store(s) to seed");

        $this->createFinanceManagers();

        foreach ($stores as $store) {
            $this->command->info("Seeding store: {$store->name} (ID: {$store->id})");
            $this->seedStoreGroups($store->id);
        }

        $this->command->info('Deal Jacket Groups seeding completed for all stores!');
    }

    private function createFinanceManagers(): void
    {
        $financeDepartment = Department::query()->where('name', 'Finance')->first();
        $managerRole = Role::query()->where('name', 'Manager')->first();
        $stores = Store::all();

        if (! $financeDepartment) {
            $this->command->warn('Finance department not found. Users will be created without department.');
        }

        if (! $managerRole) {
            $this->command->warn('Manager role not found. Users will be created without role.');
        }

        $this->financeManagers = collect();

        for ($i = 1; $i <= 3; $i++) {
            $user = User::factory()->create([
                'name' => "Finance Manager {$i}",
                'email' => "finance.manager{$i}@example.com",
                'department_id' => $financeDepartment?->id,
            ]);

            if ($managerRole) {
                $user->assignRole($managerRole);
            }

            // Associate user with all stores if tenant has locations feature
            if (tenant('locations') && $stores->isNotEmpty()) {
                $user->stores()->attach($stores->pluck('id'));
            }

            $this->financeManagers->push($user);
        }

        $this->command->info("Created {$this->financeManagers->count()} finance managers");
    }

    private function seedStoreGroups(int $storeId): void
    {
        $now = Carbon::now();

        // Generate groups for the last 3 years, one per quarter
        for ($i = 0; $i < 12; $i++) {
            $quarterStart = $now->copy()->subQuarters($i)->startOfQuarter();

            // Create a DealJacketGroup for this quarter
            $group = DealJacketGroup::query()->create([
                'store_id' => $storeId,
                'completed' => true,
            ]);

            // Set created_at to be within this quarter
            $group->created_at = $quarterStart->copy()->addDays(random_int(0, 90));
            $group->save();

            // Create 10-20 deal jackets for this group
            $dealJacketCount = random_int(10, 20);

            for ($j = 0; $j < $dealJacketCount; $j++) {
                DealJacket::factory()
                    ->create([
                        'deal_jacket_group_id' => $group->id,
                        'audit_date' => $group->created_at->copy()->addDays(random_int(0, 7)),
                        'user_id' => $this->financeManagers->random()->id,
                    ]);
            }

            $this->command->comment("  Created group for Q{$quarterStart->quarter} {$quarterStart->year} with {$dealJacketCount} deal jackets");
        }
    }
}
