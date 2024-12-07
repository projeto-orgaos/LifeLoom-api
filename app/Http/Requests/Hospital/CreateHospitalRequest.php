<?php

namespace App\Http\Requests\Hospital;

use Illuminate\Foundation\Http\FormRequest;

class CreateHospitalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|unique:hospitals,registration_number',
            'phone' => 'nullable|string|max:15',
            'cnpj' => 'nullable|string|size:14|unique:hospitals,cnpj',
            'responsible' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:hospitals,email',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.number' => 'nullable|string|max:10',
            'address.complement' => 'nullable|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|size:2',
            'address.zip_code' => 'required|string|max:10',
        ];
    }
}
