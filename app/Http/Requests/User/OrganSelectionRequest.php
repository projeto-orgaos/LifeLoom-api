<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OrganSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme as permissões do sistema
    }

    public function rules(): array
    {
        return [
            'organ_ids' => 'required|array|min:1',
            'organ_ids.*' => 'integer|exists:organ_types,id',
            'action' => 'required|string|in:add,remove',
        ];
    }

    public function messages(): array
    {
        return [
            'organ_ids.required' => 'É necessário informar pelo menos um órgão.',
            'organ_ids.array' => 'Os órgãos devem ser enviados como uma lista.',
            'organ_ids.*.exists' => 'Um ou mais tipos de órgão fornecidos são inválidos.',
            'action.required' => 'A ação é obrigatória.',
            'action.in' => 'A ação deve ser add (adicionar) ou remove (remover).',
        ];
    }
}
