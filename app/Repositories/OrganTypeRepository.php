<?php

namespace App\Repositories;

use App\Models\OrganType;
use App\Repositories\Contracts\OrganTypeRepositoryInterface;

class OrganTypeRepository extends BaseRepository implements  OrganTypeRepositoryInterface
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



    public function delete(int $id)
    {
        $type = $this->getById($id);
        $type->delete();
        return $type;
    }
}
