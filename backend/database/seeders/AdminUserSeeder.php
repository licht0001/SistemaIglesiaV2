<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@iglesia.local'],
            [
                'name' => 'Admin Iglesia',
                'password' => Hash::make('password123'),
            ]
        );

        if ($user->wasRecentlyCreated) {
            echo "Usuario creado: admin@iglesia.local / password123\n";
        } else {
            $user->password = Hash::make('password123');
            $user->save();
            echo "Usuario actualizado: admin@iglesia.local / password123\n";
        }
    }
}
