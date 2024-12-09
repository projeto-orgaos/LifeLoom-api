<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function getById(int $id);


    public function getByIdWithProfile(int $id);

    public function  findByProfile(?int $profileId);
}
