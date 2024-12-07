<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Services\Contracts\AddressServiceInterface;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressServiceInterface $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * @OA\Get(
     *     path="/api/addresses",
     *     summary="Listar todos os endereços",
     *     tags={"Addresses"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de endereços retornada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Lista de endereços retornada com sucesso."),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="street", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="number", type="string", example="123"),
     *                 @OA\Property(property="neighborhood", type="string", example="Centro"),
     *                 @OA\Property(property="city", type="string", example="São Paulo"),
     *                 @OA\Property(property="state", type="string", example="SP"),
     *                 @OA\Property(property="zip_code", type="string", example="01000-000")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $addresses = $this->addressService->getAll();
        return response()->json([
            'status' => 'success',
            'message' => 'Lista de endereços retornada com sucesso.',
            'data' => $addresses,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/addresses/{id}",
     *     summary="Exibir detalhes de um endereço",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço retornado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Endereço retornado com sucesso."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="street", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="number", type="string", example="123"),
     *                 @OA\Property(property="neighborhood", type="string", example="Centro"),
     *                 @OA\Property(property="city", type="string", example="São Paulo"),
     *                 @OA\Property(property="state", type="string", example="SP"),
     *                 @OA\Property(property="zip_code", type="string", example="01000-000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Endereço não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Endereço não encontrado.")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $address = $this->addressService->getById($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Endereço retornado com sucesso.',
            'data' => $address,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/addresses",
     *     summary="Criar um novo endereço",
     *     tags={"Addresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"street", "neighborhood", "city", "state", "zip_code"},
     *             @OA\Property(property="street", type="string", example="Rua das Flores"),
     *             @OA\Property(property="number", type="string", example="123"),
     *             @OA\Property(property="complement", type="string", example="Apto 101"),
     *             @OA\Property(property="neighborhood", type="string", example="Centro"),
     *             @OA\Property(property="city", type="string", example="São Paulo"),
     *             @OA\Property(property="state", type="string", example="SP"),
     *             @OA\Property(property="zip_code", type="string", example="01000-000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Endereço criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Endereço criado com sucesso."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="street", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="number", type="string", example="123"),
     *                 @OA\Property(property="neighborhood", type="string", example="Centro"),
     *                 @OA\Property(property="city", type="string", example="São Paulo"),
     *                 @OA\Property(property="state", type="string", example="SP"),
     *                 @OA\Property(property="zip_code", type="string", example="01000-000")
     *             )
     *         )
     *     )
     * )
     */
    public function store(CreateAddressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $address = $this->addressService->create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Endereço criado com sucesso.',
            'data' => $address,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/addresses/{id}",
     *     summary="Atualizar um endereço existente",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string", example="Rua das Flores"),
     *             @OA\Property(property="number", type="string", example="123"),
     *             @OA\Property(property="complement", type="string", example="Apto 101"),
     *             @OA\Property(property="neighborhood", type="string", example="Centro"),
     *             @OA\Property(property="city", type="string", example="São Paulo"),
     *             @OA\Property(property="state", type="string", example="SP"),
     *             @OA\Property(property="zip_code", type="string", example="01000-000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Endereço atualizado com sucesso."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="street", type="string", example="Rua das Flores"),
     *                 @OA\Property(property="number", type="string", example="123"),
     *                 @OA\Property(property="neighborhood", type="string", example="Centro"),
     *                 @OA\Property(property="city", type="string", example="São Paulo"),
     *                 @OA\Property(property="state", type="string", example="SP"),
     *                 @OA\Property(property="zip_code", type="string", example="01000-000")
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateAddressRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $address = $this->addressService->update($id, $data);
        return response()->json([
            'status' => 'success',
            'message' => 'Endereço atualizado com sucesso.',
            'data' => $address,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/addresses/{id}",
     *     summary="Excluir um endereço existente",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do endereço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço excluído com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Endereço excluído com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Endereço não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Endereço não encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->addressService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Endereço excluído com sucesso.',
        ]);
    }
}
