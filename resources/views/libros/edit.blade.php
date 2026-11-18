@extends('layouts.app')

@section('titulo', 'Editar libro · Biblioteca de Johan')

@section('contenido')
    <div class="page-head">
        <div>
            <h2 class="page-title">Editar libro</h2>
            <p class="page-subtitle">Actualiza la información de «{{ $libro->titulo }}».</p>
        </div>
        <a href="{{ route('libros.index') }}" class="btn btn-secondary">Volver al catálogo</a>
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

        <form action="{{ route('libros.update', $libro) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            @include('libros._form', ['libro' => $libro])

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Actualizar libro</button>
                <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
