<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Hero
            ['key' => 'hero_logo', 'value' => null, 'type' => 'image', 'group' => 'hero'],

            // Registration URLs
            ['key' => 'reg_simposium_url', 'value' => 'https://simposium.diesfkgugm.id', 'type' => 'url', 'group' => 'registrasi'],
            ['key' => 'reg_handson_url', 'value' => 'https://ho.diesfkgugm.id', 'type' => 'url', 'group' => 'registrasi'],
            ['key' => 'reg_funrun_url', 'value' => 'https://funrun.diesfkgugm.id', 'type' => 'url', 'group' => 'registrasi'],
            ['key' => 'reg_pengmas_url', 'value' => 'https://pm.diesfkgugm.id', 'type' => 'url', 'group' => 'registrasi'],
            ['key' => 'reg_pitch_url', 'value' => 'https://simposium.diesfkgugm.id', 'type' => 'url', 'group' => 'registrasi'],

            // Registration toggle
            ['key' => 'registration_open', 'value' => '1', 'type' => 'boolean', 'group' => 'registrasi'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
