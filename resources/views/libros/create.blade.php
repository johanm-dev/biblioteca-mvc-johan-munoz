@extends('layouts.app')

@section('titulo', 'Registrar libro · Biblioteca de Johan')

@section('contenido')
    <div class="page-head">
        <div>
            <h2 class="page-title">Registrar nuevo libro</h2>
            <p class="page-subtitle">Agrega una obra sobre mitologías colombianas a tu biblioteca.</p>
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

        <form action="{{ route('libros.store') }}" method="POST" novalidate>
            @csrf

            @include('libros._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar libro</button>
                <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
