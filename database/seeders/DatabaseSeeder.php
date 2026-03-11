<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@diesfkgugm.id'],
            ['name' => 'Admin', 'password' => bcrypt('admin123')]
        );

        $this->call([
            SettingsSeeder::class,
            EventPriceSeeder::class,
        ]);
    }
}
