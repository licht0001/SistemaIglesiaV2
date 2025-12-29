<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityType;

class ActivityTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            ['label' => 'Culto', 'value' => 'culto', 'sort_order' => 1],
            ['label' => 'Reunión de líderes', 'value' => 'reunion_lideres', 'sort_order' => 2],
            ['label' => 'Vigilia', 'value' => 'vigilia', 'sort_order' => 3],
            ['label' => 'Retiro', 'value' => 'retiro', 'sort_order' => 4],
        ];

        foreach ($defaults as $d) {
            ActivityType::updateOrCreate(
                ['value' => $d['value']],
                ['label' => $d['label'], 'is_active' => true, 'sort_order' => $d['sort_order']]
            );
        }
    }
}
