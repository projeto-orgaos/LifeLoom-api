<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
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
    public  function update(int $id, array $data)
    {
        $model = $this->getById($id);
        return $model->update($data);
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function delete(int $id)
    {
        $model = $this->getById($id);
        return $model->delete();
    }
}
