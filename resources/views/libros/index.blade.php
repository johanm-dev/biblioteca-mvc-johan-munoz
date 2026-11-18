@extends('layouts.app')

@section('titulo', 'Catálogo · Biblioteca de Johan')

@section('contenido')
    <div class="page-head">
        <div>
            <h2 class="page-title">Catálogo de Mitologías Colombianas</h2>
            <p class="page-subtitle">Explora, registra, actualiza y organiza los libros de tu biblioteca.</p>
        </div>
        <a href="{{ route('libros.create') }}" class="btn btn-primary">+ Registrar libro</a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($libros as $libro)
                        <tr>
                            <td><strong>{{ $libro->titulo }}</strong></td>
                            <td>{{ $libro->autor }}</td>
                            <td>{{ $libro->anio }}</td>
                            <td>
                                <span class="badge badge-cat">{{ $libro->categoria->nombre }}</span>
                            </td>
                            <td>
                                @if ($libro->disponible)
                                    <span class="badge badge-ok">Disponible</span>
                                @else
                                    <span class="badge badge-no">Prestado</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('libros.edit', $libro) }}" class="btn btn-secondary btn-sm">Editar</a>
                                    <form action="{{ route('libros.destroy', $libro) }}"
                                          method="POST"
                                          class="inline-form"
                                          data-confirm="¿Seguro que deseas eliminar el libro «{{ $libro->titulo }}»?"
                                          onsubmit="return confirm(this.dataset.confirm);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                No hay libros registrados todavía en el catálogo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
