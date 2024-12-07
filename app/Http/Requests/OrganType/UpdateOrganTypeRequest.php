<?php

namespace App\Http\Requests\OrganType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajuste conforme necessário para verificação de permissões.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'default_expiration_days' => 'sometimes|required|integer|min:1',
            'default_distance_limit' => 'sometimes|required|integer|min:1',
            'compatibility_criteria' => 'nullable|array',
            'is_post_mortem' => 'sometimes|required|boolean',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do tipo de órgão é obrigatório.',
            'default_expiration_days.required' => 'A validade padrão do órgão é obrigatória.',
            'default_expiration_days.integer' => 'A validade deve ser um número inteiro.',
            'default_distance_limit.required' => 'A distância máxima padrão é obrigatória.',
            'default_distance_limit.integer' => 'A distância máxima deve ser um número inteiro.',
            'is_post_mortem.required' => 'É necessário informar se o órgão é post-mortem.',
        ];
    }
}
