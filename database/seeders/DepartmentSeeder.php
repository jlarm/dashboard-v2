<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dealer\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Sales', 'slug' => 'sales'],
            ['name' => 'Accounting', 'slug' => 'accounting'],
            ['name' => 'Service', 'slug' => 'service'],
            ['name' => 'Parts', 'slug' => 'parts'],
            ['name' => 'Body Shop', 'slug' => 'body-shop'],
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Porter/Driver', 'slug' => 'porter-driver'],
        ];

        foreach ($departments as $department) {
            Department::query()->firstOrCreate(['name' => $department['name']], $department);
        }
    }
}
