<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'churchName' => 'Iglesia',
            'denomination' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'website' => '',
            'currency' => 'Bolivianos (Bs)',
            'timezone' => 'America/La_Paz',
            'messaging' => [
                'countryPrefix' => '591',
                'birthdayTemplate' => '¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}',
            ],
        ];

        Setting::updateOrCreate(
            ['key' => 'app'],
            ['value' => $defaults]
        );
    }
}
