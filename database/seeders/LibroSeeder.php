<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Database\Seeder;

class LibroSeeder extends Seeder
{
    /**
     * Puebla la colección inicial de libros sobre mitologías colombianas.
     */
    public function run(): void
    {
        $categorias = Categoria::pluck('id', 'nombre');

        $libros = [
            [
                'titulo' => 'Bachué y el origen de la humanidad',
                'autor' => 'Roberto Velandia',
                'anio' => 1992,
                'categoria' => 'Mitología Andina y Muisca',
                'disponible' => true,
            ],
            [
                'titulo' => 'El Dorado y los mitos muiscas',
                'autor' => 'Eduardo Posada',
                'anio' => 1925,
                'categoria' => 'Mitología Andina y Muisca',
                'disponible' => true,
            ],
            [
                'titulo' => 'La Madremonte y otros espantos del bosque',
                'autor' => 'Celso Román',
                'anio' => 1998,
                'categoria' => 'Espantos y Leyendas Populares',
                'disponible' => true,
            ],
            [
                'titulo' => 'La Patasola y los misterios de la montaña',
                'autor' => 'Agustín Jaramillo Londoño',
                'anio' => 1995,
                'categoria' => 'Espantos y Leyendas Populares',
                'disponible' => false,
            ],
            [
                'titulo' => 'El Mohán y las aguas del Magdalena',
                'autor' => 'Javier Ocampo López',
                'anio' => 2001,
                'categoria' => 'Espantos y Leyendas Populares',
                'disponible' => true,
            ],
            [
                'titulo' => 'La Llorona y ánimas de los caminos',
                'autor' => 'Euclides Jaramillo Arango',
                'anio' => 1989,
                'categoria' => 'Espantos y Leyendas Populares',
                'disponible' => true,
            ],
            [
                'titulo' => 'Desana: simbolismo de los indios tukano del Vaupés',
                'autor' => 'Gerardo Reichel-Dolmatoff',
                'anio' => 1986,
                'categoria' => 'Mitología Amazónica y Selva',
                'disponible' => true,
            ],
            [
                'titulo' => 'Yuruparí: mito y rito amazónico',
                'autor' => 'Maximiano José Roberto',
                'anio' => 1890,
                'categoria' => 'Mitología Amazónica y Selva',
                'disponible' => false,
            ],
            [
                'titulo' => 'El Hombre Caimán y relatos del Caribe',
                'autor' => 'Fabio Silva Vallejo',
                'anio' => 2004,
                'categoria' => 'Mitos del Caribe y Litoral',
                'disponible' => true,
            ],
            [
                'titulo' => 'Mitos y leyendas de Colombia',
                'autor' => 'Javier Ocampo López',
                'anio' => 2006,
                'categoria' => 'Mitos del Caribe y Litoral',
                'disponible' => true,
            ],
            [
                'titulo' => 'La Tunda y los cantos del Pacífico',
                'autor' => 'Alfredo Vanín',
                'anio' => 2000,
                'categoria' => 'Tradición Oral del Pacífico',
                'disponible' => true,
            ],
            [
                'titulo' => 'Los hijos de la Madre Tierra: mitos kogui',
                'autor' => 'Gerardo Reichel-Dolmatoff',
                'anio' => 1985,
                'categoria' => 'Cosmogonía de la Sierra Nevada',
                'disponible' => true,
            ],
        ];

        foreach ($libros as $item) {
            $categoriaId = $categorias[$item['categoria']] ?? null;
            if ($categoriaId === null) {
                continue;
            }

            Libro::firstOrCreate(
                ['titulo' => $item['titulo'], 'autor' => $item['autor']],
                [
                    'anio' => $item['anio'],
                    'categoria_id' => $categoriaId,
                    'disponible' => $item['disponible'],
                ]
            );
        }
    }
}
