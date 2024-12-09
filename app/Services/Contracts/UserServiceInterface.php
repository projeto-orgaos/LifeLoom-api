<?php

namespace App\Services\Contracts;

use App\Http\Requests\User\CreateUserRequest;

interface UserServiceInterface
{
    public function getAll();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getOrgans(int $userId);
    public function updateOrgans(int $userId, array $organIds);


    public function getUsersByProfile(?int $profileId);
}
