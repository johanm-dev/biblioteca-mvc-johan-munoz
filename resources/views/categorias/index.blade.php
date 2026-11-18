@extends('layouts.app')

@section('titulo', 'Categorías · Biblioteca de Johan')

@section('contenido')
    <div class="page-head">
        <div>
            <h2 class="page-title">Categorías de Mitologías</h2>
            <p class="page-subtitle">Administra las categorías de la colección. Solo pueden eliminarse si no tienen libros.</p>
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">+ Nueva categoría</a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Libros asociados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td><strong>{{ $categoria->nombre }}</strong></td>
                            <td>
                                <span class="badge {{ $categoria->libros_count > 0 ? 'badge-cat' : 'badge-no' }}">
                                    {{ $categoria->libros_count }} {{ $categoria->libros_count === 1 ? 'libro' : 'libros' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      class="inline-form"
                                      data-confirm="¿Seguro que deseas eliminar la categoría «{{ $categoria->nombre }}»?"
                                      onsubmit="return confirm(this.dataset.confirm);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty-state">
                                No hay categorías registradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
