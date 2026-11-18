<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de libros relacionada con categorías.
     */
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->string('autor', 120);
            $table->integer('anio');
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Revierte la creación de la tabla libros.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
