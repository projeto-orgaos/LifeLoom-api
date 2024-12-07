<?php

namespace App\Services\Contracts;

interface HospitalServiceInterface
{
    public function getAll(): iterable;
    public function getById(int $id): array;
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function delete(int $id): bool;
}
