# Respuestas de entrega y autoevaluación MVC

- **Aprendiz:** Johan Smith Muñoz Castiblanco
- **Programa:** Análisis y Desarrollo de Software (ADSO) · Ficha `3478025`
- **Proyecto:** Biblioteca de Johan (Mitologías Colombianas)

---

## Sección 10 · Errores intencionales (E1 – E5)

### E1
```blade
@php
    $libros = \App\Models\Libro::all();
@endphp
@foreach ($libros as $libro) ... @endforeach
```
- **¿Qué está mal?** La vista está consultando directamente la base de datos usando la clase del modelo `Libro`.
- **¿En qué capa está?** En la capa **Vista** (`resources/views/`).
- **¿En qué capa debería estar?** La consulta debe originarse en el **Modelo** (`Libro::catalogo()`) y ser solicitada desde el **Controlador** (`LibroController@index`), el cual pasa `$libros` a la vista mediante `compact()`.

### E2
```php
Route::get('/libros', function () {
    $libros = DB::table('libros')->get();
    return view('libros.index', compact('libros'));
});
```
- **¿Qué está mal?** La ruta tiene una función anónima con lógica de acceso a datos (`DB::table('libros')`) y selección de vista.
- **¿En qué capa está?** En la capa **Ruta** (`routes/web.php`).
- **¿En qué capa debería estar?** La ruta solo debe asociar la URL `/libros` con `[LibroController::class, 'index']`. El **Controlador** coordina y pide los datos al **Modelo** (`Libro`).

### E3
```php
public function store(Request $request)
{
    Libro::create($request->all());
    return redirect('/libros');
}
```
- **¿Qué está mal?** Falta validar los datos antes de guardar y usa `$request->all()` sin filtrar, lo que permite recibir campos inesperados o datos inválidos (además de no enviar mensaje de confirmación).
- **¿En qué capa está?** En la capa **Controlador** (`app/Http/Controllers/`).
- **¿En qué capa debería estar?** La validación debe ejecutarse en el **Controlador** o delegarse a un **Form Request** (`LibroRequest`) usando `$request->validated()`, y el controlador debe redirigir con `->with('ok', ...)`.

### E4
```html
<form action="/libros" method="POST">
    <input type="text" name="titulo">
    <button>Guardar</button>
</form>
```
- **¿Qué está mal?** Al formulario `POST` le falta la directiva `@csrf` (token de protección contra falsificación de peticiones entre sitios). Al enviarlo, Laravel rechazará la petición con un error **419 Page Expired**.
- **¿En qué capa está?** En la capa **Vista** (`resources/views/`).
- **¿En qué capa debería estar?** Debe corregirse dentro de la misma **Vista**, agregando `@csrf` inmediatamente dentro de la etiqueta `<form>`.

### E5
```php
// Modelo Libro
public function categoria()
{
    return $this->hasMany(Categoria::class);
}
```
- **¿Qué está mal?** Un libro pertenece a una sola categoría, por lo que usar `hasMany` invierte la relación.
- **¿En qué capa está?** En la capa **Modelo** (`app/Models/Libro.php`).
- **¿En qué capa debería estar?** Debe corregirse en el mismo **Modelo `Libro`** cambiando la relación a `belongsTo(Categoria::class)`, mientras que `hasMany(Libro::class)` corresponde al modelo `Categoria`.

---

## Sección 11 · Preguntas de comprobación

1. **¿Qué responsabilidad tiene el controlador y qué no debería hacer?**
   El controlador recibe la petición HTTP, valida los datos (directamente o mediante un *Form Request*), solicita la información o acciones al modelo y retorna una vista Blade o una redirección. No debe contener HTML, escribir SQL manual ni encargarse de la lógica interna de presentación.

2. **¿Por qué no se hacen consultas a la base de datos dentro de una vista Blade?**
   Porque mezclar acceso a datos en la vista rompe la separación de responsabilidades: dificulta reutilizar consultas, complica el mantenimiento y la depuración, y hace que un cambio en la base de datos obligue a editar plantillas HTML.

3. **¿Qué ventaja tiene definir la relación entre libro y categoría en el modelo?**
   Permite centralizar cómo se conectan las tablas en un único lugar (`Libro::categoria()` y `Categoria::libros()`), facilita cargar relaciones de forma eficiente (`with('categoria')` evitando consultas repetidas) y hace el código más expresivo y reutilizable en cualquier controlador.

4. **Recorrido ordenado al escribir `/libros` en el navegador:**
   1) El navegador envía una petición `GET /libros`.
   2) `routes/web.php` identifica la ruta y la envía a `LibroController@index`.
   3) `LibroController@index` lee los parámetros de filtro/búsqueda y llama al scope `Libro::catalogo(...)` y `Categoria::ordenadas()`.
   4) Los modelos consultan PostgreSQL mediante Eloquent y devuelven los resultados paginados con su categoría asociada.
   5) `LibroController@index` pasa `$libros`, `$categorias`, `$categoriaId` y `$busqueda` a `view('libros.index', ...)`.
   6) Blade renderiza `libros/index.blade.php` heredando `layouts/app.blade.php` y devuelve el HTML final al navegador.

5. **Si cambiaras de MySQL a SQLite (o PostgreSQL), ¿qué capas del MVC tendrías que modificar? ¿Por qué?**
   En principio **ninguna capa de MVC** (ni rutas, ni vistas, ni controladores, ni los modelos estándar con Eloquent), solo la configuración de entorno (`.env` y `config/database.php`), porque Eloquent y las migraciones abstraen el motor SQL. (Como buena práctica, en `Libro::scopeBuscarPorTitulo` se usó `LOWER(titulo) LIKE ?` para que la búsqueda funcione igual sin importar mayúsculas en PostgreSQL o SQLite).

6. **¿Para qué sirve `$fillable` en un modelo?**
   Define la lista blanca de atributos que pueden asignarse de forma masiva (`Libro::create(...)` o `$libro->update(...)`), protegiendo la aplicación contra vulnerabilidades de asignación masiva (*mass assignment*).

7. **¿Por qué el archivo `.env` no se sube a GitHub?**
   Porque contiene credenciales y configuraciones sensibles y propias de cada máquina (como `APP_KEY` y `DB_PASSWORD` de PostgreSQL). Subirlo expondría secretos en el repositorio y generaría conflictos entre entornos locales y producción.

8. **¿Cuál es la diferencia entre `git add`, `git commit` y `git push`?**
   - `git add`: prepara (*stage*) los archivos modificados o nuevos para incluirlos en la siguiente versión.
   - `git commit`: guarda una instantánea permanente en el historial local de Git con un mensaje descriptivo.
   - `git push`: envía los *commits* locales hacia el repositorio remoto en GitHub.

---

## Sección 14 · Autoevaluación MVC

- **Modelo (`app/Models/Libro.php` y `app/Models/Categoria.php`):** Ubiqué en los modelos las relaciones (`belongsTo` y `hasMany`), la regla `tieneLibros()` en `Categoria` para impedir borrar categorías con obras asociadas, y los *query scopes* reutilizables `filtrarPorCategoria`, `buscarPorTitulo` y `catalogo` en `Libro`, porque toda consulta y regla sobre los datos pertenece a la capa de datos.
- **Vista (`resources/views/layouts/app.blade.php`, `libros/*.blade.php` y `categorias/*.blade.php`):** Dejé en las vistas únicamente la estructura HTML, el layout compartido con «Biblioteca de Johan» y el pie de página, los formularios con `@csrf`, `@method` y `@error`, y la presentación de tablas sin ninguna consulta a modelos ni bloques `@php`, porque la vista solo debe mostrar información.
- **Controlador (`app/Http/Controllers/LibroController.php` y `CategoriaController.php`) y Form Requests (`app/Http/Requests/`):** Ubiqué en los controladores únicamente la coordinación de cada petición (invocar `Libro::catalogo(...)`, delegar reglas de validación en español a `LibroRequest` y `CategoriaRequest`, ejecutar acciones en el modelo y redirigir con mensajes flash `ok`/`error`), manteniendo controladores delgados y rutas en `routes/web.php` sin funciones anónimas.
