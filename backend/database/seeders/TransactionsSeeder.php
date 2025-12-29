<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumimos que ya existen miembros de ejemplo
        $memberId = DB::table('members')->value('id');

        DB::table('transactions')->insert([
            [
                'member_id' => $memberId,
                'type' => 'ingreso',
                'category' => 'diezmo',
                'sub_category' => 'fondo_general',
                'amount' => 500.00,
                'transaction_date' => '2025-12-05',
                'payment_method' => 'efectivo',
                'reference' => 'Sobre 001',
                'description' => 'Diezmo mensual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => null,
                'type' => 'egreso',
                'category' => 'gasto_operativo',
                'sub_category' => 'alquiler',
                'amount' => 800.00,
                'transaction_date' => '2025-12-06',
                'payment_method' => 'transferencia',
                'reference' => 'Factura 123',
                'description' => 'Alquiler del local',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
