<?php

namespace App\Repositories\Contracts;

interface OrganRepositoryInterface
{

    public function getAvailableOrgans();
    public function getExpiredOrgans();
    public function getDonors();
    public function getWaitingList();
    public function getKPIs();

    public function getByUserId(int $userId);

    public function deleteByUserId(int $userId);
}
