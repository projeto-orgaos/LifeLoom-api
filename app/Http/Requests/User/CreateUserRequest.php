<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme as permissões do sistema
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|size:11|unique:users,cpf',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'mother_name' => 'required|string|max:255',
            'previous_diseases' => 'nullable|string',
            'password' => 'required|string|min:8',
            'profile_id' => 'required|exists:profiles,id',
            'phone' => 'required|string|max:15',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address' => 'required|array', // Valida que o endereço está presente como array
            'address.street' => 'required|string|max:255',
            'address.number' => 'nullable|string|max:10',
            'address.complement' => 'nullable|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|size:2',
            'address.zip_code' => 'required|string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O endereço de e-mail é obrigatório.',
            'email.unique' => 'Este endereço de e-mail já está em uso.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
            'cpf.unique' => 'Este CPF já está registrado.',
            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.before' => 'A data de nascimento deve ser uma data no passado.',
            'gender.required' => 'O gênero é obrigatório.',
            'gender.in' => 'O gênero deve ser male, female ou other.',
            'mother_name.required' => 'O nome da mãe é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'profile_id.required' => 'O perfil do usuário é obrigatório.',
            'profile_id.exists' => 'O perfil fornecido não existe.',
            'phone.required' => 'O número de telefone é obrigatório.',
            'blood_type.required' => 'O tipo sanguíneo é obrigatório.',
            'blood_type.in' => 'O tipo sanguíneo informado é inválido.',
            'address.required' => 'O endereço é obrigatório.',
            'address.street.required' => 'A rua do endereço é obrigatória.',
            'address.neighborhood.required' => 'O bairro do endereço é obrigatório.',
            'address.city.required' => 'A cidade do endereço é obrigatória.',
            'address.state.required' => 'O estado do endereço é obrigatório.',
            'address.state.size' => 'O estado deve conter exatamente 2 caracteres.',
            'address.zip_code.required' => 'O CEP do endereço é obrigatório.',
        ];
    }
}
