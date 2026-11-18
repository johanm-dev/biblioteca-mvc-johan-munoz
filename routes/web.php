<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LibroController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LibroController::class, 'index'])->name('inicio');

Route::resource('libros', LibroController::class)->except(['show']);
Route::resource('categorias', CategoriaController::class)->only(['index', 'create', 'store', 'destroy']);
