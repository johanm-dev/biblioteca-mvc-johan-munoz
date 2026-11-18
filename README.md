# Biblioteca de Johan · Mitologías Colombianas

Aplicación web desarrollada en **Laravel 12** aplicando el patrón arquitectónico **MVC (Modelo – Vista – Controlador)** para la administración de una biblioteca personal temática sobre **Mitologías Colombianas**.

- **Aprendiz:** Johan Smith Muñoz Castiblanco
- **Programa:** Análisis y Desarrollo de Software (ADSO) — SENA
- **Ficha:** 3478025
- **Base de datos:** PostgreSQL (`biblioteca_johan_munoz`)

## Arquitectura MVC del proyecto

- **Rutas (`routes/web.php`):** Conectan cada URL únicamente con métodos de `LibroController` y `CategoriaController`, sin funciones anónimas con lógica.
- **Modelos (`app/Models/Libro.php`, `app/Models/Categoria.php`):** Definen las relaciones (`belongsTo` / `hasMany`), asignación masiva (`$fillable`), conversión de tipos (`$casts`), reglas sobre los datos (`tieneLibros()`) y *query scopes* reutilizables (`filtrarPorCategoria`, `buscarPorTitulo`, `catalogo`).
- **Controladores (`app/Http/Controllers/`):** Reciben las peticiones, delegan la validación a *Form Requests* (`app/Http/Requests/`), consultan a los modelos y retornan vistas Blade o redirecciones con mensajes de sesión.
- **Vistas (`resources/views/`):** Utilizan un layout compartido (`layouts/app.blade.php`) y muestran datos únicamente mediante directivas Blade, sin consultas ni lógica de negocio.

## Requisitos previos

- PHP 8.2 o superior (con extensión `pdo_pgsql` habilitada)
- Composer
- PostgreSQL 15+ (probado en PostgreSQL 17)

## Cómo ejecutar el proyecto

1. Clonar el repositorio y entrar a la carpeta del proyecto:
   ```bash
   git clone https://github.com/johanm-dev/biblioteca-mvc-johan-munoz.git
   cd biblioteca-mvc-johan-munoz
   ```

2. Instalar las dependencias de PHP:
   ```bash
   composer install
   ```

3. Copiar `.env.example` a `.env` y configurar tu contraseña de PostgreSQL (`DB_PASSWORD`):
   ```powershell
   Copy-Item .env.example .env
   ```
   Asegúrate de que en `.env` estén los datos de tu base PostgreSQL:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=biblioteca_johan_munoz
   DB_USERNAME=postgres
   DB_PASSWORD=tu_contrasena_postgres
   ```

4. Crear la base de datos en PostgreSQL (desde pgAdmin o con `psql`):
   ```sql
   CREATE DATABASE biblioteca_johan_munoz;
   ```

5. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Ejecutar las migraciones y cargar la colección inicial de Mitologías Colombianas:
   ```bash
   php artisan migrate --seed
   ```

7. Iniciar el servidor de desarrollo:
   ```bash
   php artisan serve
   ```
   Luego abre en tu navegador: `http://127.0.0.1:8000`

## Pruebas automatizadas

Para ejecutar la suite de pruebas (usa SQLite en memoria según `phpunit.xml`):
```bash
php artisan test
```
