<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibroCategoriaModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_relaciones_entre_categoria_y_libro(): void
    {
        $categoria = Categoria::create(['nombre' => 'Mitología Andina']);
        $libro = Libro::create([
            'titulo' => 'Bachué y el origen',
            'autor' => 'Roberto Velandia',
            'anio' => 1992,
            'categoria_id' => $categoria->id,
            'disponible' => true,
        ]);

        $this->assertTrue($libro->categoria->is($categoria));
        $this->assertCount(1, $categoria->libros);
        $this->assertTrue($categoria->tieneLibros());
    }

    public function test_categoria_vacia_informa_que_no_tiene_libros(): void
    {
        $categoria = Categoria::create(['nombre' => 'Tradición Llanera']);

        $this->assertFalse($categoria->tieneLibros());
    }

    public function test_scopes_de_filtro_y_busqueda_combinados(): void
    {
        $andina = Categoria::create(['nombre' => 'Mitología Andina']);
        $selva = Categoria::create(['nombre' => 'Mitología Amazónica']);

        Libro::create([
            'titulo' => 'El Dorado y los mitos muiscas',
            'autor' => 'Eduardo Posada',
            'anio' => 1925,
            'categoria_id' => $andina->id,
            'disponible' => true,
        ]);

        Libro::create([
            'titulo' => 'El Dorado en la selva',
            'autor' => 'Autor Selva',
            'anio' => 2005,
            'categoria_id' => $selva->id,
            'disponible' => true,
        ]);

        $resultados = Libro::catalogo($andina->id, 'dorado')->get();

        $this->assertCount(1, $resultados);
        $this->assertSame('El Dorado y los mitos muiscas', $resultados->first()->titulo);
    }
}
