<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    /**
     * Lista las categorías junto con la cantidad de libros asociados.
     */
    public function index(): View
    {
        $categorias = Categoria::conConteoDeLibros()->get();

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create(): View
    {
        return view('categorias.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:100', 'unique:categorias,nombre'],
        ]);

        Categoria::create($datos);

        return redirect()
            ->route('categorias.index')
            ->with('ok', 'Categoría creada correctamente.');
    }

    /**
     * Elimina una categoría solo si no tiene libros asociados.
     */
    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->tieneLibros()) {
            return redirect()
                ->route('categorias.index')
                ->with('error', "No se puede eliminar la categoría «{$categoria->nombre}» porque tiene libros asociados.");
        }

        $nombre = $categoria->nombre;
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('ok', "La categoría «{$nombre}» fue eliminada.");
    }
}
