<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibroController extends Controller
{
    /**
     * Muestra el listado de libros con su categoría.
     */
    public function index(): View
    {
        $libros = Libro::with('categoria')->latest('id')->get();
        $categorias = Categoria::ordenadas()->get();

        return view('libros.index', compact('libros', 'categorias'));
    }

    /**
     * Muestra el formulario para registrar un nuevo libro.
     */
    public function create(): View
    {
        $categorias = Categoria::ordenadas()->get();

        return view('libros.create', compact('categorias'));
    }

    /**
     * Guarda un nuevo libro en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:150'],
            'autor' => ['required', 'string', 'min:2', 'max:120'],
            'anio' => ['required', 'integer', 'min:1500', 'max:' . date('Y')],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'disponible' => ['required', 'boolean'],
        ]);

        Libro::create($datos);

        return redirect()
            ->route('libros.index')
            ->with('ok', 'Libro registrado correctamente en la biblioteca.');
    }

    /**
     * Muestra el formulario para editar un libro existente.
     */
    public function edit(Libro $libro): View
    {
        $categorias = Categoria::ordenadas()->get();

        return view('libros.edit', compact('libro', 'categorias'));
    }

    /**
     * Actualiza los datos de un libro existente.
     */
    public function update(Request $request, Libro $libro): RedirectResponse
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:150'],
            'autor' => ['required', 'string', 'min:2', 'max:120'],
            'anio' => ['required', 'integer', 'min:1500', 'max:' . date('Y')],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'disponible' => ['required', 'boolean'],
        ]);

        $libro->update($datos);

        return redirect()
            ->route('libros.index')
            ->with('ok', 'Libro actualizado correctamente.');
    }

    /**
     * Elimina un libro de la biblioteca.
     */
    public function destroy(Libro $libro): RedirectResponse
    {
        $titulo = $libro->titulo;
        $libro->delete();

        return redirect()
            ->route('libros.index')
            ->with('ok', "El libro «{$titulo}» fue eliminado.");
    }
}
