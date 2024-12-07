<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hospital\CreateHospitalRequest;
use App\Http\Requests\Hospital\UpdateHospitalRequest;
use App\Services\AddressService;
use App\Services\Contracts\HospitalServiceInterface;
use Illuminate\Http\JsonResponse;

class HospitalController extends Controller
{
    protected $hospitalService;

    protected $addressService;

    public function __construct(HospitalServiceInterface $hospitalService,
                                AddressService $addressService)
    {
        $this->hospitalService = $hospitalService;
        $this->addressService = $addressService;
    }

    /**
     * @OA\Get(
     *     path="/api/hospitals",
     *     summary="Listar todos os hospitais",
     *     tags={"Hospitais"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de hospitais retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Hospitais listados com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object", example={"id": 1, "name": "Hospital Central", "phone": "123456789", "email": "hospital@exemplo.com"})
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $hospitals = $this->hospitalService->getAll();
        return response()->json([
            'status' => 'success',
            'message' => 'Hospitais listados com sucesso.',
            'data' => $hospitals,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/hospitals/{id}",
     *     summary="Obter um hospital pelo ID",
     *     tags={"Hospitais"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do hospital",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital retornado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Hospital obtido com sucesso."),
     *             @OA\Property(property="data", type="object", example={"id": 1, "name": "Hospital Central", "phone": "123456789", "email": "hospital@exemplo.com"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital não encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Hospital não encontrado.")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $hospital = $this->hospitalService->getById($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Hospital obtido com sucesso.',
            'data' => $hospital,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/hospitals",
     *     summary="Criar um novo hospital",
     *     tags={"Hospitais"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "address_id"},
     *             @OA\Property(property="name", type="string", example="Hospital Central"),
     *             @OA\Property(property="registration_number", type="string", example="12345"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="email", type="string", example="hospital@exemplo.com"),
     *             @OA\Property(property="address_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hospital criado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Hospital criado com sucesso."),
     *             @OA\Property(property="data", type="object", example={"id": 1, "name": "Hospital Central", "phone": "123456789", "email": "hospital@exemplo.com"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos.")
     *         )
     *     )
     * )
     */
    public function store(CreateHospitalRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Verifica e cria o endereço
        if (isset($data['address'])) {
            $addressData = $data['address'];

            // Cria o endereço usando o AddressService
            $address = $this->addressService->create($addressData);

            // Associa o ID do endereço ao hospital
            $data['address_id'] = $address['id'];
        }

        // Cria o hospital
        unset($data['address']); // Remove o array de endereço, já processado
        $hospital = $this->hospitalService->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Hospital criado com sucesso.',
            'data' => $hospital,
        ], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/hospitals/{id}",
     *     summary="Atualizar um hospital existente",
     *     tags={"Hospitais"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do hospital",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Hospital Atualizado"),
     *             @OA\Property(property="phone", type="string", example="987654321"),
     *             @OA\Property(property="email", type="string", example="novoemail@exemplo.com"),
     *             @OA\Property(property="address_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital atualizado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Hospital atualizado com sucesso."),
     *             @OA\Property(property="data", type="object", example={"id": 1, "name": "Hospital Atualizado", "phone": "987654321", "email": "novoemail@exemplo.com"})
     *         )
     *     )
     * )
     */
    public function update(UpdateHospitalRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $hospital = $this->hospitalService->update($id, $data);
        return response()->json([
            'status' => 'success',
            'message' => 'Hospital atualizado com sucesso.',
            'data' => $hospital,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/hospitals/{id}",
     *     summary="Excluir um hospital",
     *     tags={"Hospitais"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do hospital",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Hospital excluído com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital não encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Hospital não encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->hospitalService->delete($id);
        return response()->json([], 204);
    }
}
