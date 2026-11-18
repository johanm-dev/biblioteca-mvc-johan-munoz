<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders de la biblioteca.
     */
    public function run(): void
    {
        $this->call([
            CategoriaSeeder::class,
            LibroSeeder::class,
        ]);
    }
}
