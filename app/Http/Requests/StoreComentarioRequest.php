<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contenido' => 'required|string|min:3|max:5000',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'contenido.required' => 'El comentario no puede estar vacío',
            'contenido.min' => 'El comentario debe tener al menos 3 caracteres',
            'contenido.max' => 'El comentario no puede exceder 5000 caracteres',
        ];
    }
}
