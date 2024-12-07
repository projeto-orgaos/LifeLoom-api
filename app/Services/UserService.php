<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\Organ;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\OrganRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\OrganServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $organService;

    protected $addressService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OrganServiceInterface $organService,
        AddressServiceInterface $addressService
    ) {
        $this->userRepository = $userRepository;
        $this->organService = $organService;
        $this->addressService = $addressService;
    }

    /**
     * Retorna todos os usuários.
     */
    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Retorna um usuário pelo ID.
     */
    public function getById(int $id)
    {
        return $this->userRepository->getById($id);
    }

    /**
     * Cria um novo usuário.
     */
    public function create(CreateUserRequest $userRequest)
    {
        $data = $userRequest->validated();

        // Verifica se o endereço foi fornecido e usa o AddressService para criar
        if (isset($data['address'])) {
            $addressData = $data['address'];

            // Cria o endereço usando o AddressService
            $address = $this->addressService->create($addressData);

            // Associa o ID do endereço ao array de dados do usuário
            $data['address_id'] = $address['id'];
        }

        // Garante que a senha seja criptografada antes de salvar o usuário
        $data['password'] = Hash::make($data['password']);

        // Remove o array de endereço, pois ele já foi tratado
        unset($data['address']);

        // Cria o usuário utilizando o repositório
        return $this->userRepository->save($data);
    }



    /**
     * Atualiza os dados de um usuário.
     */
    public function update(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    /**
     * Exclui um usuário pelo ID.
     */
    public function delete(int $id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Retorna os órgãos associados a um usuário.
     */
    public function getOrgans(int $userId)
    {
        $user = $this->getById($userId);

        return $this->organService->getByUserId($userId, $user->profile_id);
    }

    /**
     * Atualiza os órgãos associados a um usuário.
     */
    public function updateOrgans(int $userId, array $organIds, string $action)
    {
        $user = $this->getById($userId);

        if ($action === 'add') {
            foreach ($organIds as $organTypeId) {
                $this->organService->create([
                    'organ_type_id' => $organTypeId,
                    'status' => 'Pending',
                    'donor_id' => $user->profile_id === 'donor' ? $userId : null,
                    'recipient_id' => $user->profile_id === 'recipient' ? $userId : null,
                ]);
            }
        } elseif ($action === 'remove') {
            foreach ($organIds as $organId) {
                $organ = $this->organService->getById($organId);
                if (
                    ($organ->donor_id === $userId && $user->profile_id === 'donor') ||
                    ($organ->recipient_id === $userId && $user->profile_id === 'recipient')
                ) {
                    $this->organService->delete($organId);
                }
            }
        }
    }

    /**
     * Retorna um usuário com todos os dados relacionados.
     */
    public function getFullById(int $id)
    {
        $user = $this->userRepository->getByIdWithProfile($id);

        return $user;
    }
}
