<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
     * Usa 'sometimes' porque no todos los campos son necesarios en updates
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|string|max:200',
            'descripcion' => 'sometimes|string',
            'area_id' => 'sometimes|exists:areas,id_area',
            'prioridad_id' => 'sometimes|exists:prioridades,id_prioridad',
            'estado_id' => 'sometimes|exists:estados,id_estado',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'titulo.max' => 'El título no puede exceder 200 caracteres',
            'area_id.exists' => 'El área seleccionada no existe',
            'prioridad_id.exists' => 'La prioridad seleccionada no existe',
            'estado_id.exists' => 'El estado seleccionado no existe',
        ];
    }
}
