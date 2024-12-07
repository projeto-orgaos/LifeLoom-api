<?php

namespace App\Services;

use App\Http\Requests\Organ\CreateOrganRequest;
use App\Http\Requests\Organ\UpdateOrganRequest;
use App\Repositories\Contracts\OrganRepositoryInterface;
use App\Services\Contracts\OrganServiceInterface;
use Illuminate\Validation\ValidationException;

class OrganService implements OrganServiceInterface
{
    protected $repository;

    public function __construct(OrganRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retorna todos os órgãos.
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Retorna um órgão pelo ID.
     */
    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Cria um novo órgão com validação.
     */
    public function create(array $data)
    {
        $request = new CreateOrganRequest($data);
        $validated = $request->validated();

        // Popula valores padrão, se necessário, do tipo de órgão
        if (!isset($validated['expiration_date'])) {
            $validated['expiration_date'] = now()->addDays($validated['type']->default_expiration_days);
        }

        if (!isset($validated['distance_limit'])) {
            $validated['distance_limit'] = $validated['type']->default_distance_limit;
        }

        return $this->repository->create($validated);
    }

    /**
     * Atualiza um órgão existente com validação.
     */
    public function update(int $id, array $data)
    {
        $organ = $this->repository->getById($id);

        $request = new UpdateOrganRequest($data);
        $validated = $request->validated();

        return $this->repository->update($id, $validated);
    }

    /**
     * Exclui um órgão pelo ID.
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Retorna todos os órgãos disponíveis.
     */
    public function getAvailableOrgans()
    {
        return $this->repository->getAvailableOrgans();
    }

    /**
     * Retorna todos os órgãos expirados.
     */
    public function getExpiredOrgans()
    {
        return $this->repository->getExpiredOrgans();
    }

    /**
     * Retorna todos os doadores registrados.
     */
    public function getDonors()
    {
        return $this->repository->getDonors();
    }

    /**
     * Retorna a lista de espera de órgãos.
     */
    public function getWaitingList()
    {
        return $this->repository->getWaitingList();
    }

    /**
     * Retorna os KPIs sobre órgãos.
     */
    public function getKPIs()
    {
        return $this->repository->getKPIs();
    }

    public function getByUserId(int $userId)
    {
        return $this->repository->getByUserId($userId);
    }
}
