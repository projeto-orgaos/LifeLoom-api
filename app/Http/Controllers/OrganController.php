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
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="organ_type", type="string", example="Coração"),
     *                     @OA\Property(property="status", type="string", example="Available"),
     *                     @OA\Property(property="expiration_date", type="string", format="date", example="2024-12-31"),
     *                     @OA\Property(property="distance_limit", type="integer", example=300),
     *                     @OA\Property(property="hospital_id", type="integer", example=1),
     *                     @OA\Property(property="donor_id", type="integer", example=10),
     *                     @OA\Property(property="recipient_id", type="integer", example=15),
     *                     @OA\Property(property="matched_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
     *                     @OA\Property(property="completed_at", type="string", format="date-time", example="2024-12-02T15:00:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requisição inválida.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Erro ao processar a solicitação.")
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
     *     summary="Obter estatísticas sobre os órgãos",
     *     tags={"Órgãos"},
     *     @OA\Response(
     *         response=200,
     *         description="KPIs retornadas com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="KPIs obtidas com sucesso."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="total_organs", type="integer", example=120),
     *                 @OA\Property(property="available_organs", type="integer", example=50),
     *                 @OA\Property(property="expired_organs", type="integer", example=20),
     *                 @OA\Property(property="in_use", type="integer", example=30),
     *                 @OA\Property(property="donated_organs", type="integer", example=20)
     *             )
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
     *             required={"organ_type", "status", "expiration_date", "distance_limit", "hospital_id"},
     *             @OA\Property(property="organ_type", type="string", example="Coração"),
     *             @OA\Property(property="status", type="string", example="Available"),
     *             @OA\Property(property="expiration_date", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="distance_limit", type="integer", example=300),
     *             @OA\Property(property="hospital_id", type="integer", example=1),
     *             @OA\Property(property="donor_id", type="integer", example=10),
     *             @OA\Property(property="recipient_id", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Órgão criado com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Órgão registrado com sucesso."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="organ_type", type="string", example="Coração"),
     *                 @OA\Property(property="status", type="string", example="Available"),
     *                 @OA\Property(property="expiration_date", type="string", format="date", example="2024-12-31"),
     *                 @OA\Property(property="distance_limit", type="integer", example=300),
     *                 @OA\Property(property="hospital_id", type="integer", example=1),
     *                 @OA\Property(property="donor_id", type="integer", example=10),
     *                 @OA\Property(property="recipient_id", type="integer", example=15),
     *                 @OA\Property(property="matched_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
     *                 @OA\Property(property="completed_at", type="string", format="date-time", example="2024-12-02T15:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Erro ao processar a solicitação.")
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
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="organ_type", type="string", example="Coração"),
     *                     @OA\Property(property="status", type="string", example="Available"),
     *                     @OA\Property(property="expiration_date", type="string", format="date", example="2024-12-31"),
     *                     @OA\Property(property="distance_limit", type="integer", example=300),
     *                     @OA\Property(property="hospital_id", type="integer", example=1),
     *                     @OA\Property(property="donor_id", type="integer", example=10),
     *                     @OA\Property(property="recipient_id", type="integer", example=15),
     *                     @OA\Property(property="matched_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
     *                     @OA\Property(property="completed_at", type="string", format="date-time", example="2024-12-02T15:00:00Z")
     *                 )
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
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="João"),
     *                     @OA\Property(property="cpf", type="string", example="12345678901"),
     *                     @OA\Property(
     *                         property="organs",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=10),
     *                             @OA\Property(property="organ_type", type="string", example="Coração"),
     *                             @OA\Property(property="status", type="string", example="Donated"),
     *                             @OA\Property(property="expiration_date", type="string", format="date", example="2024-12-31"),
     *                             @OA\Property(property="hospital_id", type="integer", example=1)
     *                         )
     *                     )
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
     *     summary="Listar usuários na fila de espera por órgãos",
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
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Maria"),
     *                     @OA\Property(property="organ_requested", type="string", example="Rim"),
     *                     @OA\Property(property="status", type="string", example="Waiting")
     *                 )
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
