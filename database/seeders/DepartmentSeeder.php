<?php

namespace Database\Seeders;

use App\Models\Dealer\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create([
            'name' => 'Sales',
            'slug' => 'sales',
        ]);

        Department::create([
            'name' => 'Accounting',
            'slug' => 'accounting',
        ]);

        Department::create([
            'name' => 'Service',
            'slug' => 'service',
        ]);

        Department::create([
            'name' => 'Parts',
            'slug' => 'parts',
        ]);

        Department::create([
            'name' => 'Body Shop',
            'slug' => 'body-shop',
        ]);

        Department::create([
            'name' => 'Finance',
            'slug' => 'finance',
        ]);
    }
}
