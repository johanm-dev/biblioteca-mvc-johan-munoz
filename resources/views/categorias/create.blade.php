@extends('layouts.app')

@section('titulo', 'Nueva categoría · Biblioteca de Johan')

@section('contenido')
    <div class="page-head">
        <div>
            <h2 class="page-title">Nueva categoría</h2>
            <p class="page-subtitle">Crea una nueva rama o tradición mítica para clasificar tus libros.</p>
        </div>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver a categorías</a>
    </div>

    <div class="card">
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categorias.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre de la categoría</label>
                <input type="text"
                       id="nombre"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       class="form-control @error('nombre') is-invalid @enderror"
                       placeholder="Ej. Mitología de los Llanos Orientales">
                @error('nombre')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar categoría</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
