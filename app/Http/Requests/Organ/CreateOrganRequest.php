<?php

namespace App\Http\Requests\Organ;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Modifique conforme a lógica de permissões
    }

    public function rules(): array
    {
        return [
            'organ_type_id' => 'required|exists:organ_types,id',
            'status' => 'required|in:Pending,Available,Donated,In Use,Expired',
            'hospital_id' => 'required|exists:hospitals,id',
            'donor_id' => 'nullable|exists:users,id',
            'recipient_id' => 'nullable|exists:users,id',
            'expiration_date' => 'nullable|date|after_or_equal:today',
            'distance_limit' => 'nullable|integer|min:1',
            'matched_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:matched_at',
        ];
    }

    public function messages(): array
    {
        return [
            'organ_type_id.required' => 'O tipo de órgão é obrigatório.',
            'status.in' => 'O status fornecido não é válido.',
            'hospital_id.required' => 'O hospital é obrigatório.',
            'donor_id.exists' => 'O doador fornecido não existe.',
            'expiration_date.after_or_equal' => 'A data de validade deve ser hoje ou uma data futura.',
        ];
    }
}
