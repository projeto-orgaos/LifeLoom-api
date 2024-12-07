<?php

namespace App\Services\Contracts;

interface OrganServiceInterface
{
    public function getAll();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getAvailableOrgans();
    public function getExpiredOrgans();
    public function getDonors();
    public function getWaitingList();
    public function getKPIs();

    public function getByUserId(int $userId);
}
