<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;


class AuthController extends Controller
{

    protected $userService;


    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Autenticar um usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Usuário autenticado com sucesso."),
     *             @OA\Property(property="acess_token", type="string", example="1|abc123..."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="As credenciais fornecidas estão incorretas.")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'As credenciais fornecidas estão incorretas.',
            ], 401);
        }

        // Obtém o usuário autenticado
        $user = Auth::user();
        $user_complete = $this->userService->getFullById($user->id);

        // Gera o token de acesso
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário autenticado com sucesso.',
            'acess_token' => $token,
            'user' => $user_complete,
        ], 200);
    }


/**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Registrar um novo usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "profile_id", "phone", "blood_type", "address"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="profile_id", type="integer", example=1),
     *             @OA\Property(property="phone", type="string", example="62999999999"),
     *             @OA\Property(property="blood_type", type="string", example="O+"),
     *             @OA\Property(
     *                 property="address",
     *                 type="object",
     *                 required={"street", "neighborhood", "city", "state", "zip_code"},
     *                 @OA\Property(property="street", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="number", type="string", example="123"),
     *                 @OA\Property(property="complement", type="string", example="Apto 101"),
     *                 @OA\Property(property="neighborhood", type="string", example="Centro"),
     *                 @OA\Property(property="city", type="string", example="São Paulo"),
     *                 @OA\Property(property="state", type="string", example="SP"),
     *                 @OA\Property(property="zip_code", type="string", example="01000-000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Usuário criado com sucesso."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Erro de validação"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="O campo e-mail é obrigatório."))
     *             )
     *         )
     *     )
     * )
     */
    public function register(CreateUserRequest $request)
    {
        $user = $this->userService->create($request);
        return response()->json([
            'status' => 'success',
            'message' => 'Usuário criado com sucesso.',
            'data' => $user,
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Fazer logout do usuário",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso.',
        ], 200);
    }
}
