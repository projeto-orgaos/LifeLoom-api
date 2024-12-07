<?php

namespace App\Repositories;

use App\Models\OrganType;
use App\Repositories\Contracts\OrganTypeRepositoryInterface;

class OrganTypeRepository implements OrganTypeRepositoryInterface
{
    protected $model;

    public function __construct(OrganType $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $type = $this->getById($id);
        $type->update($data);
        return $type;
    }

    public function delete(int $id)
    {
        $type = $this->getById($id);
        $type->delete();
        return $type;
    }
}
