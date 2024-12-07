<?php

namespace App\Services;

use App\Repositories\Contracts\OrganTypeRepositoryInterface;
use App\Services\Contracts\OrganTypeServiceInterface;

class OrganTypeService implements OrganTypeServiceInterface
{
    protected $repository;

    public function __construct(OrganTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function create(array $data)
    {
        return $this->repository->save($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
