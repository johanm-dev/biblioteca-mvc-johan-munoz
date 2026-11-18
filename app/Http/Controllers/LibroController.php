<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibroRequest;
use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibroController extends Controller
{
    /**
     * Muestra el listado de libros con filtro por categoría, búsqueda por título y paginación.
     */
    public function index(Request $request): View
    {
        $categoriaId = $request->integer('categoria_id') ?: null;
        $busqueda = $request->string('buscar')->trim()->toString();

        $libros = Libro::catalogo($categoriaId, $busqueda)
            ->paginate(8)
            ->withQueryString();

        $categorias = Categoria::ordenadas()->get();

        return view('libros.index', compact('libros', 'categorias', 'categoriaId', 'busqueda'));
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
     * Guarda un nuevo libro previamente validado por LibroRequest.
     */
    public function store(LibroRequest $request): RedirectResponse
    {
        Libro::create($request->validated());

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
     * Actualiza los datos de un libro existente tras validar con LibroRequest.
     */
    public function update(LibroRequest $request, Libro $libro): RedirectResponse
    {
        $libro->update($request->validated());

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
