<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function store(CreateUserRequest $request): Response
    {
        $data = $request->validated();

        // Criação do usuário com hash da senha
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_id' => $data['profile_id'],
            'phone' => $data['phone'],
            'blood_type' => $data['blood_type'],
            'address_id' => null, // Será preenchido após criar o endereço
        ]);

        // Criação do endereço vinculado ao usuário
        $addressData = $data['address'];
        $address = $user->address()->create($addressData);

        // Atualiza o usuário com o ID do endereço criado
        $user->update(['address_id' => $address->id]);

        // Evento de registro do usuário
        event(new Registered($user));

        // Login automático após o registro (opcional)
        Auth::login($user);

        // Retorna uma resposta de sucesso sem conteúdo
        return response()->noContent(201);
    }
}
