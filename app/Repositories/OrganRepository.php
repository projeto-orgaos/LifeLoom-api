<?php

namespace App\Repositories;

use App\Models\Organ;
use App\Repositories\Contracts\OrganRepositoryInterface;
use App\Repositories\BaseRepository;

class OrganRepository extends BaseRepository implements OrganRepositoryInterface
{
    public function __construct(Organ $model)
    {
        parent::__construct($model);
    }


    public function getAll()
    {

        return $this->model->with(['type', 'hospital', 'donor', 'recipient'])->get();
    }

    public function getById(int $id)
    {
        return $this->model->with(['type', 'hospital', 'donor', 'recipient'])->find($id);
    }

    /**
     * Retorna todos os órgãos disponíveis para doação.
     */
    public function getAvailableOrgans()
    {
        return $this->model->where('status', 'Available')
            ->whereDate('expiration_date', '>=', now())
            ->with(['type', 'hospital'])
            ->get();
    }

    /**
     * Retorna todos os órgãos expirados.
     */
    public function getExpiredOrgans()
    {
        return $this->model->where('status', 'Expired')
            ->orWhereDate('expiration_date', '<', now())
            ->with(['type', 'hospital'])
            ->get();
    }

    /**
     * Retorna todos os usuários registrados como doadores e seus órgãos.
     */
    public function getDonors()
    {
        return $this->model->where('status', 'Pending')
            ->with(['donor', 'type'])
            ->get()
            ->groupBy('donor_id');
    }

    /**
     * Retorna todos os usuários na lista de espera.
     */
    public function getWaitingList()
    {
        return $this->model->where('status', 'Waiting')
            ->with(['recipient', 'type'])
            ->get()
            ->groupBy('recipient_id');
    }

    /**
     * Retorna os KPIs sobre órgãos.
     */
    public function getKPIs()
    {
        return [
            'total_organs' => $this->model->count(),
            'available_organs' => $this->model->where('status', 'Available')->count(),
            'expired_organs' => $this->model->where('status', 'Expired')->count(),
            'in_use' => $this->model->where('status', 'In Use')->count(),
            'donated_organs' => $this->model->where('status', 'Donated')->count(),
        ];
    }

    public function getByUserId(int $userId)
    {
        return $this->model->where('donor_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with('type')
            ->get();
    }

    public function deleteByUserId(int $userId)
    {
        return $this->model
            ->where('donor_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->delete();
    }
}
