<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


    /**
     * Retorna dados completos do usuário pelo ID, adiciona tambem os orgãos do usuário e o tipo de orgão relacionado.
     * @param int $id
     */
    public function getById(int $id)
    {
        $user = $this->model->with(['profile', 'address'])->find($id);

        if (!$user) {
            return null;
        }

        $user->organs = $user->allOrgans();

        return $user;
    }

    public function getAll()
    {
        return $this->model->with('profile', 'address')->get();
    }
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getByIdWithProfile(int $id)
    {
        return $this->model->with('profile')->find($id);
    }

    /**
     * Busca usuários pelo profile_id.
     * Se o profile_id não for informado, retorna todos os usuários.
     */
    public function findByProfile(?int $profileId)
    {
        $query = $this->model->query();

        if ($profileId !== null) {
            $query->where('profile_id', $profileId);
        }

        return $query->with(['profile', 'address'])->get(); // Inclui o relacionamento com o perfil
    }
}

