<?php

namespace App\Services;

use App\Http\Requests\Organ\UpdateOrganRequest;
use App\Repositories\Contracts\OrganRepositoryInterface;
use App\Services\Contracts\OrganServiceInterface;

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
        // Salvar no repositório
        return $this->repository->save($data);
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

    public function deleteByUserId(int $userId)
    {
        return $this->repository->deleteByUserId($userId);
    }
}
