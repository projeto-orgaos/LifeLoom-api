<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organ\CreateOrganRequest;
use App\Http\Requests\Organ\UpdateOrganRequest;
use App\Services\Contracts\OrganServiceInterface;
use Illuminate\Http\JsonResponse;

class OrganController extends Controller
{
    protected $service;

    public function __construct(OrganServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/organs",
     *     summary="Listar todos os órgãos",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de órgãos retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Órgãos listados com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object", example={"id": 1, "organ_type": "Coração", "status": "Available", "expiration_date": "2024-12-31", "distance_limit": 300, "hospital_id": 1})
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $organs = $this->service->getAll();
        return response()->json([
            'status' => 'success',
            'message' => 'Órgãos listados com sucesso.',
            'data' => $organs,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organs/kpi",
     *     summary="Obter estatísticas sobre órgãos",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="KPIs retornadas com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="KPIs obtidas com sucesso."),
     *             @OA\Property(property="data", type="object", example={
     *                 "total_organs": 120,
     *                 "available_organs": 50,
     *                 "expired_organs": 20,
     *                 "in_use": 30,
     *                 "donated_organs": 20
     *             })
     *         )
     *     )
     * )
     */
    public function kpi(): JsonResponse
    {
        $kpi = $this->service->getKPIs();
        return response()->json([
            'status' => 'success',
            'message' => 'KPIs obtidas com sucesso.',
            'data' => $kpi,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/organs",
     *     summary="Registrar um novo órgão",
     *     tags={"Órgãos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"organ_type_id", "status", "hospital_id"},
     *             @OA\Property(property="organ_type_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="Pending"),
     *             @OA\Property(property="hospital_id", type="integer", example=1),
     *             @OA\Property(property="donor_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Órgão registrado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Órgão registrado com sucesso."),
     *             @OA\Property(property="data", type="object", example={"id": 1, "organ_type": "Coração", "status": "Pending"})
     *         )
     *     )
     * )
     */
    public function store(CreateOrganRequest $request): JsonResponse
    {
        $data = $request->validated();
        $organ = $this->service->create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Órgão registrado com sucesso.',
            'data' => $organ,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/organs/available",
     *     summary="Listar órgãos disponíveis",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="Órgãos disponíveis listados com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Órgãos disponíveis listados com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object", example={"id": 1, "organ_type": "Coração", "status": "Available", "expiration_date": "2024-12-31", "hospital_id": 1})
     *             )
     *         )
     *     )
     * )
     */
    public function available(): JsonResponse
    {
        $organs = $this->service->getAvailableOrgans();
        return response()->json([
            'status' => 'success',
            'message' => 'Órgãos disponíveis listados com sucesso.',
            'data' => $organs,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organs/donors",
     *     summary="Listar todos os doadores registrados",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="Doadores listados com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Doadores listados com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     example={
     *                         "id": 1,
     *                         "name": "João",
     *                         "cpf": "12345678901",
     *                         "organs": ""
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function donors(): JsonResponse
    {
        $donors = $this->service->getDonors();
        return response()->json([
            'status' => 'success',
            'message' => 'Doadores listados com sucesso.',
            'data' => $donors,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organs/waiting-list",
     *     summary="Listar todos os usuários na fila de espera por órgãos",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de espera retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Lista de espera retornada com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object", example={"id": 1, "name": "Maria", "organ_requested": "Rim", "status": "Waiting"})
     *             )
     *         )
     *     )
     * )
     */
    public function waitingList(): JsonResponse
    {
        $waitingList = $this->service->getWaitingList();
        return response()->json([
            'status' => 'success',
            'message' => 'Lista de espera retornada com sucesso.',
            'data' => $waitingList,
        ]);
    }
}
