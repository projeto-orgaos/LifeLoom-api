<?php

namespace App\Http\Requests\Organ;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Modifique conforme a lógica de permissões
    }

    public function rules(): array
    {
        return [
            'organ_type_id' => 'sometimes|required|exists:organ_types,id',
            'status' => 'sometimes|required|in:Pending,Available,Donated,In Use,Expired',
            'hospital_id' => 'sometimes|required|exists:hospitals,id',
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
            'organ_type_id.exists' => 'O tipo de órgão fornecido não existe.',
            'status.in' => 'O status fornecido não é válido.',
            'hospital_id.exists' => 'O hospital fornecido não existe.',
            'donor_id.exists' => 'O doador fornecido não existe.',
        ];
    }
}
