<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function save(array $data);
    public function delete(int $id);

}
