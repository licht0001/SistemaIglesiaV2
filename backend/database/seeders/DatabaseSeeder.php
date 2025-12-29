<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario de prueba
        User::factory()->create([
            'name' => 'Admin Iglesia',
            'email' => 'admin@iglesia.local',
        ]);

        $this->call([
            SettingsSeeder::class,
            MembersSeeder::class,
            MinistriesSeeder::class,
            ActivityTypesSeeder::class,
            EventsSeeder::class,
            TransactionsSeeder::class,
        ]);
    }
}
