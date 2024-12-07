<?php

namespace App\Services;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;

class AddressService implements AddressServiceInterface
{
    protected $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAll(): array
    {
        return $this->addressRepository->getAll()->toArray();
    }

    public function getById(int $id): array
    {
        return $this->addressRepository->getById($id)->toArray();
    }

    public function create(array $data): array
    {
        return $this->addressRepository->save($data)->toArray();
    }

    public function update(int $id, array $data): array
    {
        $address = $this->addressRepository->getById($id);
        $address->update($data);
        return $address->toArray();
    }

    public function delete(int $id): bool
    {
        return $this->addressRepository->delete($id);
    }
}
