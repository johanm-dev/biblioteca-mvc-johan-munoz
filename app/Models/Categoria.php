<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];

    /**
     * Relación: una categoría tiene muchos libros.
     */
    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class, 'categoria_id');
    }

    /**
     * Indica si la categoría tiene al menos un libro asociado.
     */
    public function tieneLibros(): bool
    {
        return $this->libros()->exists();
    }

    /**
     * Ordena alfabéticamente las categorías.
     */
    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('nombre');
    }

    /**
     * Incluye el conteo de libros por categoría ordenadas alfabéticamente.
     */
    public function scopeConConteoDeLibros(Builder $query): Builder
    {
        return $query->withCount('libros')->orderBy('nombre');
    }
}
