<?php

namespace App\Http\Requests\Hospital;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'registration_number' => 'nullable|string|unique:hospitals,registration_number,' . $this->route('hospital'),
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:hospitals,email,' . $this->route('hospital'),
            'address_id' => 'sometimes|required|exists:addresses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',

            'registration_number.string' => 'O campo número de registro deve ser uma string.',
            'registration_number.unique' => 'O número de registro já está em uso.',

            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.max' => 'O campo telefone deve ter no máximo 15 caracteres.',

            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está em uso.',

            'address_id.required' => 'O campo endereço é obrigatório.',
            'address_id.exists' => 'O endereço selecionado é inválido.',
        ];
    }
}
