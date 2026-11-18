<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de categorías antes que la de libros para respetar la clave foránea.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Revierte la creación de la tabla categorías.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
