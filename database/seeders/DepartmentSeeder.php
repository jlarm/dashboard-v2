<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dealer\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::query()->create([
            'name' => 'Sales',
            'slug' => 'sales',
        ]);

        Department::query()->create([
            'name' => 'Accounting',
            'slug' => 'accounting',
        ]);

        Department::query()->create([
            'name' => 'Service',
            'slug' => 'service',
        ]);

        Department::query()->create([
            'name' => 'Parts',
            'slug' => 'parts',
        ]);

        Department::query()->create([
            'name' => 'Body Shop',
            'slug' => 'body-shop',
        ]);

        Department::query()->create([
            'name' => 'Finance',
            'slug' => 'finance',
        ]);

        Department::query()->create([
            'name' => 'Porter/Driver',
            'slug' => 'porter-driver',
        ]);
    }
}
