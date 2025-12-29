<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $currentMonth = Carbon::now()->month;
        
        $members = [];

        // 1. Crear 5 miembros con cumpleaños este mes
        for ($i = 0; $i < 5; $i++) {
            $year = $faker->year();
            // Asegurar que el día sea válido para el mes (ej: no 30 de febrero)
            $day = $faker->numberBetween(1, 28); 
            $birthDate = Carbon::createFromDate($year, $currentMonth, $day)->format('Y-m-d');

            $members[] = [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName() . ' ' . $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => '6' . $faker->numberBetween(1000000, 9999999), // Teléfono estilo Bolivia
                'birth_date' => $birthDate,
                'gender' => $faker->randomElement(['M', 'F']),
                'marital_status' => $faker->randomElement(['single', 'married']),
                'city' => 'Cochabamba',
                'address' => $faker->address(),
                'baptism_date' => $faker->date('Y-m-d', '-1 year'),
                'membership_date' => $faker->date('Y-m-d', '-6 months'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 2. Crear 20 miembros adicionales aleatorios
        for ($i = 0; $i < 20; $i++) {
            $members[] = [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName() . ' ' . $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => '7' . $faker->numberBetween(1000000, 9999999), 
                'birth_date' => $faker->date('1970-01-01', '2005-12-31'),
                'gender' => $faker->randomElement(['M', 'F']),
                'marital_status' => $faker->randomElement(['single', 'married', 'widowed']),
                'city' => 'Cochabamba',
                'address' => $faker->address(),
                'baptism_date' => $faker->optional(0.6)->date('Y-m-d', '-1 year'),
                'membership_date' => $faker->date('Y-m-d', '-1 month'),
                'status' => $faker->randomElement(['active', 'active', 'inactive']), // Más probabilidad de activos
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('members')->insert($members);
    }
}
