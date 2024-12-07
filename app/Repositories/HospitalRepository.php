<?php

namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\Contracts\HospitalRepositoryInterface;

class HospitalRepository implements HospitalRepositoryInterface
{
    protected $model;

    public function __construct(Hospital $model)
    {
        $this->model = $model;
    }

    public function getAll(): iterable
    {
        return $this->model->with('address')->get();
    }

    public function getById(int $id): ?array
    {
        return $this->model->with('address')->findOrFail($id)->toArray();
    }

    public function create(array $data): array
    {
        return $this->model->create($data)->toArray();
    }

    public function update(int $id, array $data): array
    {
        $hospital = $this->model->findOrFail($id);
        $hospital->update($data);
        return $hospital->toArray();
    }

    public function delete(int $id): bool
    {
        $hospital = $this->model->findOrFail($id);
        return $hospital->delete();
    }
}
