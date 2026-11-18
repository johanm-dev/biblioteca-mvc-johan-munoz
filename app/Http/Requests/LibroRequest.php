<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroRequest extends FormRequest
{
    /**
     * Autoriza la petición para crear o actualizar un libro.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para los datos de un libro.
     */
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:3', 'max:150'],
            'autor' => ['required', 'string', 'min:2', 'max:120'],
            'anio' => ['required', 'integer', 'min:1500', 'max:' . date('Y')],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'disponible' => ['required', 'boolean'],
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     */
    public function messages(): array
    {
        $anioActual = date('Y');

        return [
            'titulo.required' => 'El título del libro es obligatorio.',
            'titulo.min' => 'El título debe tener al menos :min caracteres.',
            'titulo.max' => 'El título no puede superar los :max caracteres.',
            'autor.required' => 'El nombre del autor es obligatorio.',
            'autor.min' => 'El nombre del autor debe tener al menos :min caracteres.',
            'autor.max' => 'El nombre del autor no puede superar los :max caracteres.',
            'anio.required' => 'El año de publicación es obligatorio.',
            'anio.integer' => 'El año de publicación debe ser un número entero.',
            'anio.min' => 'El año de publicación debe ser mayor o igual a 1500.',
            'anio.max' => "El año de publicación no puede superar el año actual ({$anioActual}).",
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.integer' => 'La categoría seleccionada no es válida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe en el sistema.',
            'disponible.required' => 'Debes indicar si el libro está disponible.',
            'disponible.boolean' => 'El valor de disponibilidad debe ser verdadero o falso.',
        ];
    }
}
