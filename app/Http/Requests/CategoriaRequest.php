<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{
    /**
     * Autoriza la petición para crear una categoría.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para una nueva categoría.
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:100', 'unique:categorias,nombre'],
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.min' => 'El nombre de la categoría debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre de la categoría no puede superar los :max caracteres.',
            'nombre.unique' => 'Ya existe una categoría registrada con ese nombre.',
        ];
    }
}
