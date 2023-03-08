<?php

namespace Database\Seeders;

use App\Models\Dealer\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'name' => 'Liberty Kia',
            'slug' => 'liberty-kia',
            'address' => '921 S Milwaukee Ave',
            'city' => 'Libertyville',
            'state' => 'Illinois',
            'postal_code' => '60048',
            'phone' => '847-362-5000',
            'website' => 'https://www.libertykia.com/',
        ]);

        Store::create([
            'name' => 'Liberty Nissan',
            'slug' => 'liberty-nissan',
            'address' => '921 S Milwaukee Ave',
            'city' => 'Libertyville',
            'state' => 'Illinois',
            'postal_code' => '60048',
            'phone' => '847-362-5000',
            'website' => 'https://www.libertynissan.com/',
        ]);

        Store::create([
            'name' => 'Liberty Volkswagen',
            'slug' => 'liberty-volkswagen',
            'address' => '921 S Milwaukee Ave',
            'city' => 'Libertyville',
            'state' => 'Illinois',
            'postal_code' => '60048',
            'phone' => '847-362-5000',
            'website' => 'https://www.libertykia.com/',
        ]);
    }
}
