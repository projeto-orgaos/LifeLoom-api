<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme as permissões do sistema
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->route('id'),
            'cpf' => 'nullable|string|size:11|unique:users,cpf,' . $this->route('id'),
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'mother_name' => 'nullable|string|max:255',
            'previous_diseases' => 'nullable|string',
            'profile_id' => 'nullable|exists:profiles,id',
            'phone' => 'nullable|string|max:15',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address_id' => 'nullable|exists:addresses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este endereço de e-mail já está em uso.',
            'cpf.unique' => 'Este CPF já está registrado.',
            'birth_date.before' => 'A data de nascimento deve ser uma data no passado.',
            'gender.in' => 'O gênero deve ser male, female ou other.',
            'profile_id.exists' => 'O perfil fornecido não existe.',
            'blood_type.in' => 'O tipo sanguíneo informado é inválido.',
            'address_id.exists' => 'O endereço fornecido não existe.',
        ];
    }
}
