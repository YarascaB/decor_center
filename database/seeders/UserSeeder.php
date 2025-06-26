<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica si ya existe el usuario
        $user = User::firstOrCreate(
            ['email' => 'admin@decorcenter.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('*Admin123'),
            ]
        );

        // Asigna el rol admin
        $user->syncRoles(['admin']);
    }
}
