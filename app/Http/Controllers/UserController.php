<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\OrganSelectionRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Lista todos os usuários",
     *     tags={"Usuários"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="cpf", type="string", example="12345678901"),
     *                 @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *                 @OA\Property(property="blood_type", type="string", example="O+")
     *             )
     *         )
     *     )
     * )
     */
    /**
     * Lista usuários filtrados pelo profile_id.
     */
    public function index(Request $request)
    {
        $profileId = $request->query('profile_id'); // Obtém o profile_id do filtro
        $users = $this->userService->getUsersByProfile($profileId);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuários listados com sucesso.',
            'data' => $users,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Cria um novo usuário",
     *     tags={"Usuários"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "cpf", "birth_date", "gender", "phone", "blood_type", "address_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1990-05-01"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *             @OA\Property(property="blood_type", type="string", example="O+"),
     *             @OA\Property(property="address_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *             @OA\Property(property="blood_type", type="string", example="O+")
     *         )
     *     )
     * )
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->create($data);
        return response()->json(['status' => 'success', 'data' => $user], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obter detalhes de um usuário",
     *     tags={"Usuários"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário retornados com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *             @OA\Property(property="blood_type", type="string", example="O+")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getById($id);
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Atualiza informações de um usuário",
     *     tags={"Usuários"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *             @OA\Property(property="email", type="string", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="+55 11 99999-9999")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->update($id, $data);
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Exclui um usuário",
     *     tags={"Usuários"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Usuário excluído com sucesso."
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->delete($id);
        return response()->json([], 204);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/organs",
     *     summary="Lista órgãos associados ao usuário",
     *     tags={"Usuários"},
     *     @OA\Response(
     *         response=200,
     *         description="Órgãos retornados com sucesso.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="type", type="string", example="Coração"),
     *                 @OA\Property(property="status", type="string", example="Pending")
     *             )
     *         )
     *     )
     * )
     */
    public function listOrgans(int $id): JsonResponse
    {


        $organs = $this->userService->getOrgans($id);
        return response()->json(['status' => 'success', 'data' => $organs]);
    }


    public function updateOrgans(OrganSelectionRequest $request, int $id): JsonResponse
    {
        //Get data from request without validation
        $data = $request->all();
        $this->userService->updateOrgans($id, $data['organ_ids']);
        return response()->json(['status' => 'success', 'message' => 'Órgãos atualizados com sucesso.']);
    }
}
