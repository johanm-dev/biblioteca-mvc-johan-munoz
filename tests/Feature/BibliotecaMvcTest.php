<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Libro;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BibliotecaMvcTest extends TestCase
{
    use RefreshDatabase;

    public function test_listado_inicial_muestra_personalizacion_y_datos_sembrados(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Biblioteca de Johan');
        $response->assertSee('Johan Smith Muñoz Castiblanco · Ficha 3478023 · 2026');
        $response->assertSee('Cosmogonía de la Sierra Nevada');
        $response->assertSee('Los hijos de la Madre Tierra: mitos kogui');
    }

    public function test_puede_registrar_libro_valido_y_muestra_mensaje_de_exito(): void
    {
        $categoria = Categoria::create(['nombre' => 'Mitos del Caribe']);

        $response = $this->post(route('libros.store'), [
            'titulo' => 'El Hombre Caimán de Plato',
            'autor' => 'Fabio Silva Vallejo',
            'anio' => 2004,
            'categoria_id' => $categoria->id,
            'disponible' => '1',
        ]);

        $response->assertRedirect(route('libros.index'));
        $response->assertSessionHas('ok');
        $this->assertDatabaseHas('libros', [
            'titulo' => 'El Hombre Caimán de Plato',
            'categoria_id' => $categoria->id,
            'disponible' => true,
        ]);
    }

    public function test_validacion_de_libro_muestra_errores_en_espanol(): void
    {
        $response = $this->from(route('libros.create'))->post(route('libros.store'), [
            'titulo' => 'ab',
            'autor' => '',
            'anio' => 1400,
            'categoria_id' => 9999,
            'disponible' => '1',
        ]);

        $response->assertRedirect(route('libros.create'));
        $response->assertSessionHasErrors([
            'titulo' => 'El título debe tener al menos 3 caracteres.',
            'autor' => 'El nombre del autor es obligatorio.',
            'anio' => 'El año de publicación debe ser mayor o igual a 1500.',
            'categoria_id' => 'La categoría seleccionada no existe en el sistema.',
        ]);
    }

    public function test_puede_editar_y_eliminar_un_libro(): void
    {
        $categoria = Categoria::create(['nombre' => 'Espantos Populares']);
        $libro = Libro::create([
            'titulo' => 'La Patasola',
            'autor' => 'Agustín Jaramillo',
            'anio' => 1995,
            'categoria_id' => $categoria->id,
            'disponible' => true,
        ]);

        $this->get(route('libros.edit', $libro))
            ->assertOk()
            ->assertSee('La Patasola');

        $updateResponse = $this->put(route('libros.update', $libro), [
            'titulo' => 'La Patasola y otros relatos',
            'autor' => 'Agustín Jaramillo Londoño',
            'anio' => 1996,
            'categoria_id' => $categoria->id,
            'disponible' => '0',
        ]);

        $updateResponse->assertRedirect(route('libros.index'));
        $updateResponse->assertSessionHas('ok');
        $this->assertDatabaseHas('libros', [
            'id' => $libro->id,
            'titulo' => 'La Patasola y otros relatos',
            'disponible' => false,
        ]);

        $deleteResponse = $this->delete(route('libros.destroy', $libro));
        $deleteResponse->assertRedirect(route('libros.index'));
        $deleteResponse->assertSessionHas('ok');
        $this->assertDatabaseMissing('libros', ['id' => $libro->id]);
    }

    public function test_administra_categorias_y_bloquea_borrado_si_tiene_libros(): void
    {
        $this->post(route('categorias.store'), ['nombre' => 'Mitos del Pacífico'])
            ->assertRedirect(route('categorias.index'))
            ->assertSessionHas('ok');

        $categoria = Categoria::where('nombre', 'Mitos del Pacífico')->firstOrFail();

        Libro::create([
            'titulo' => 'La Tunda',
            'autor' => 'Alfredo Vanín',
            'anio' => 2000,
            'categoria_id' => $categoria->id,
            'disponible' => true,
        ]);

        $this->delete(route('categorias.destroy', $categoria))
            ->assertRedirect(route('categorias.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);

        $vacia = Categoria::create(['nombre' => 'Categoría Vacía']);
        $this->delete(route('categorias.destroy', $vacia))
            ->assertRedirect(route('categorias.index'))
            ->assertSessionHas('ok');

        $this->assertDatabaseMissing('categorias', ['id' => $vacia->id]);
    }

    public function test_filtra_por_categoria_y_busca_por_titulo_con_paginacion(): void
    {
        $this->seed(DatabaseSeeder::class);
        $espantos = Categoria::where('nombre', 'Espantos y Leyendas Populares')->firstOrFail();

        $response = $this->get(route('libros.index', [
            'categoria_id' => $espantos->id,
            'buscar' => 'madremonte',
        ]));

        $response->assertOk();
        $response->assertSee('La Madremonte y otros espantos del bosque');
        $response->assertDontSee('Bachué y el origen de la humanidad');
    }

    public function test_reglas_mvc_sin_consultas_en_vistas_ni_cierres_en_rutas(): void
    {
        $rutas = File::get(base_path('routes/web.php'));
        $this->assertStringNotContainsString('function (', $rutas);
        $this->assertStringNotContainsString('function(', $rutas);

        foreach (File::allFiles(resource_path('views')) as $archivo) {
            $contenido = File::get($archivo->getPathname());
            $this->assertStringNotContainsString('App\\Models', $contenido);
            $this->assertStringNotContainsString('DB::', $contenido);
            $this->assertStringNotContainsString('@php', $contenido);
        }
    }
}
