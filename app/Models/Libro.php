<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'anio',
        'categoria_id',
        'disponible',
    ];

    protected $casts = [
        'anio' => 'integer',
        'disponible' => 'boolean',
    ];

    /**
     * Relación: un libro pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Filtra los libros por una categoría específica si se proporciona su ID.
     */
    public function scopeFiltrarPorCategoria(Builder $query, ?int $categoriaId): Builder
    {
        if ($categoriaId === null || $categoriaId <= 0) {
            return $query;
        }

        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Busca libros por coincidencia parcial en el título (insensible a mayúsculas).
     */
    public function scopeBuscarPorTitulo(Builder $query, ?string $busqueda): Builder
    {
        $termino = trim((string) $busqueda);

        if ($termino === '') {
            return $query;
        }

        return $query->whereRaw('LOWER(titulo) LIKE ?', ['%' . mb_strtolower($termino) . '%']);
    }

    /**
     * Consulta reutilizable del catálogo con categoría cargada, filtro y búsqueda.
     */
    public function scopeCatalogo(Builder $query, ?int $categoriaId = null, ?string $busqueda = null): Builder
    {
        return $query
            ->with('categoria')
            ->filtrarPorCategoria($categoriaId)
            ->buscarPorTitulo($busqueda)
            ->latest('id');
    }
}
