<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Solo crea productos si NO estás en entorno local (puedes cambiar esto si quieres)
        if (app()->environment() !== 'local') {
            Producto::factory(20)->create();
        }

        // Primero se crean los roles, luego se crean los usuarios y se asignan roles
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
