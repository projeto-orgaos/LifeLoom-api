<?php

namespace App\Repositories\Contracts;

interface OrganTypeRepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function save(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
