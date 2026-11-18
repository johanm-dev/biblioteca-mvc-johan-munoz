<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Puebla las categorías temáticas sobre mitologías colombianas.
     */
    public function run(): void
    {
        $categorias = [
            'Mitología Andina y Muisca',
            'Espantos y Leyendas Populares',
            'Mitología Amazónica y Selva',
            'Mitos del Caribe y Litoral',
            'Tradición Oral del Pacífico',
            'Cosmogonía de la Sierra Nevada',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
