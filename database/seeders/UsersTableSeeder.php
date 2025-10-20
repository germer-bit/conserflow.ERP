<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@test.com'], // criterio de búsqueda
            [
                'name' => 'Admin',
                'password' => Hash::make('Cc123456'),
                'role' => 'admin'
            ]
        );

        // Usuario normal
        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Usuario',
                'password' => Hash::make('password123'),
                'role' => 'user'
            ]
        );
    }
}
