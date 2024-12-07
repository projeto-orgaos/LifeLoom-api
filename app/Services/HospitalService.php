<?php

namespace App\Services;

use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Services\Contracts\HospitalServiceInterface;

class HospitalService implements HospitalServiceInterface
{
    protected $hospitalRepository;

    public function __construct(HospitalRepositoryInterface $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
    }

    public function getAll(): iterable
    {
        return $this->hospitalRepository->getAll();
    }

    public function getById(int $id): array
    {
        return $this->hospitalRepository->getById($id);
    }

    public function create(array $data): array
    {
        return $this->hospitalRepository->create($data);
    }

    public function update(int $id, array $data): array
    {
        return $this->hospitalRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->hospitalRepository->delete($id);
    }
}
