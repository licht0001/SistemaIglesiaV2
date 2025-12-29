<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'name' => 'Culto general',
                'description' => 'Reunión principal de la iglesia.',
                'start_at' => '2025-12-25 19:30:00',
                'end_at' => '2025-12-25 21:00:00',
                'location' => 'Templo central',
                'type' => 'culto',
                'is_public' => true,
                'status' => 'programado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reunión de líderes',
                'description' => 'Planificación mensual de ministerios.',
                'start_at' => '2025-12-28 18:00:00',
                'end_at' => '2025-12-28 20:00:00',
                'location' => 'Salón anexo',
                'type' => 'reunion_lideres',
                'is_public' => false,
                'status' => 'programado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
