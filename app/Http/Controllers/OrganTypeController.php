<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganType\CreateOrganTypeRequest;
use App\Http\Requests\OrganType\UpdateOrganTypeRequest;
use App\Services\Contracts\OrganTypeServiceInterface;
use Illuminate\Http\JsonResponse;

class OrganTypeController extends Controller
{
    protected $service;

    public function __construct(OrganTypeServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/organ-types",
     *     summary="Listar todos os tipos de órgãos",
     *     tags={"Tipos de Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipos de órgãos retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tipos de órgãos listados com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     example={
     *                         "id": 1,
     *                         "name": "Coração",
     *                         "description": "Órgão vital",
     *                         "default_expiration_days": 7,
     *                         "default_distance_limit": 500,
     *                         "compatibility_criteria": "",
     *                         "is_post_mortem": true
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index(): JsonResponse
    {
        $types = $this->service->getAll();
        return response()->json([
            'status' => 'success',
            'message' => 'Tipos de órgãos listados com sucesso.',
            'data' => $types,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organ-types/{id}",
     *     summary="Obter detalhes de um tipo de órgão",
     *     tags={"Tipos de Órgãos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de órgão",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de órgão retornado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tipo de órgão obtido com sucesso."),
     *             @OA\Property(property="data", type="object", example={
     *                 "id": 1,
     *                 "name": "Coração",
     *                 "description": "Órgão vital",
     *                 "default_expiration_days": 7,
     *                 "default_distance_limit": 500,
     *                 "compatibility_criteria": "",
     *                 "is_post_mortem": true
     *             })
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de órgão não encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Tipo de órgão não encontrado.")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $type = $this->service->getById($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Tipo de órgão obtido com sucesso.',
            'data' => $type,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/organ-types",
     *     summary="Criar um novo tipo de órgão",
     *     tags={"Tipos de Órgãos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "default_expiration_days", "default_distance_limit"},
     *             @OA\Property(property="name", type="string", example="Coração"),
     *             @OA\Property(property="description", type="string", example="Órgão vital"),
     *             @OA\Property(property="default_expiration_days", type="integer", example=7),
     *             @OA\Property(property="default_distance_limit", type="integer", example=500),
     *             @OA\Property(property="compatibility_criteria", type="string", example=""),
     *             @OA\Property(property="is_post_mortem", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de órgão criado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tipo de órgão criado com sucesso."),
     *             @OA\Property(property="data", type="object", example={
     *                 "id": 1,
     *                 "name": "Coração",
     *                 "description": "Órgão vital",
     *                 "default_expiration_days": 7,
     *                 "default_distance_limit": 500,
     *                 "compatibility_criteria": "",
     *                 "is_post_mortem": true
     *             })
     *         )
     *     )
     * )
     */
    public function store(CreateOrganTypeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $type = $this->service->create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Tipo de órgão criado com sucesso.',
            'data' => $type,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/organ-types/{id}",
     *     summary="Atualizar um tipo de órgão existente",
     *     tags={"Tipos de Órgãos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de órgão",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Coração Atualizado"),
     *             @OA\Property(property="description", type="string", example="Órgão vital atualizado"),
     *             @OA\Property(property="default_expiration_days", type="integer", example=8),
     *             @OA\Property(property="default_distance_limit", type="integer", example=600),
     *             @OA\Property(property="compatibility_criteria", type="string", example=""),
     *             @OA\Property(property="is_post_mortem", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de órgão atualizado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Tipo de órgão atualizado com sucesso."),
     *             @OA\Property(property="data", type="object", example={
     *                 "id": 1,
     *                 "name": "Coração Atualizado",
     *                 "description": "Órgão vital atualizado",
     *                 "default_expiration_days": 8,
     *                 "default_distance_limit": 600,
     *                 "compatibility_criteria": "",
     *                 "is_post_mortem": false
     *             })
     *         )
     *     )
     * )
     */
    public function update(UpdateOrganTypeRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $type = $this->service->update($id, $data);
        return response()->json([
            'status' => 'success',
            'message' => 'Tipo de órgão atualizado com sucesso.',
            'data' => $type,
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Tipo de órgão excluído com sucesso.',
        ]);
    }
}
