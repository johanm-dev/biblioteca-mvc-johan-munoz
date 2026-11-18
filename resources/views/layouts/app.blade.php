<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Biblioteca de Johan')</title>
    <link rel="stylesheet" href="{{ asset('css/biblioteca.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <div>
                <h1 class="brand-title">Biblioteca de Johan</h1>
                <p class="brand-subtitle">Colección personal de Mitologías Colombianas</p>
            </div>
            <nav class="nav-links" aria-label="Navegación principal">
                <a href="{{ route('libros.index') }}"
                   class="nav-link {{ request()->routeIs('libros.index') || request()->routeIs('inicio') ? 'active' : '' }}">
                    Catálogo de libros
                </a>
                <a href="{{ route('libros.create') }}"
                   class="nav-link {{ request()->routeIs('libros.create') ? 'active' : '' }}">
                    Registrar libro
                </a>
                <a href="{{ route('categorias.index') }}"
                   class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    Categorías
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('ok'))
            <div class="alert alert-ok" role="status">
                {{ session('ok') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('contenido')
    </main>

    <footer class="site-footer">
        Johan Smith Muñoz Castiblanco · Ficha 3478023 · 2026
    </footer>
</body>
</html>
