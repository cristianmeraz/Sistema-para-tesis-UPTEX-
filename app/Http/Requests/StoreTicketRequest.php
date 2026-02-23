<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'area_id' => 'required|exists:areas,id_area',
            'prioridad_id' => 'required|exists:prioridades,id_prioridad',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título del ticket es obligatorio',
            'titulo.max' => 'El título no puede exceder 200 caracteres',
            'descripcion.required' => 'La descripción del ticket es obligatoria',
            'area_id.required' => 'Debe seleccionar un área',
            'area_id.exists' => 'El área seleccionada no existe',
            'prioridad_id.required' => 'Debe seleccionar una prioridad',
            'prioridad_id.exists' => 'La prioridad seleccionada no existe',
        ];
    }
}
