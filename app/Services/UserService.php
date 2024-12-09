<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\Organ;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\OrganServiceInterface;
use App\Services\Contracts\OrganTypeServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $organService;

    protected $addressService;

    protected $organTypeService;

    public function __construct(
        UserRepositoryInterface   $userRepository,
        OrganServiceInterface     $organService,
        AddressServiceInterface   $addressService,
        OrganTypeServiceInterface $organTypeService
    )
    {
        $this->userRepository = $userRepository;
        $this->organService = $organService;
        $this->addressService = $addressService;
        $this->organTypeService = $organTypeService;
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
     * Retorna um usuário pelo ID.
     */

    /**
     * Cria um novo usuário.
     */
    public function create(array $data)
    {

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
    public function updateOrgans(int $userId, array $organIds)
    {
        DB::beginTransaction();

        try {
            // Obtém o usuário com as relações completas
            $user = $this->getById($userId);

            if (!$user) {
                throw new \InvalidArgumentException("Usuário com ID $userId não encontrado.");
            }

            // Verifica o perfil do usuário (Doador ou Receptor)
            $isDonor = $user->profile->description === 'Doador';
            $isRecipient = $user->profile->description === 'Receptor';

            if (!$isDonor && !$isRecipient) {
                throw new \InvalidArgumentException("Usuário com ID $userId não é doador nem receptor.");
            }

            // Remove os órgãos existentes associados ao usuário
            $this->organService->deleteByUserId($userId);

            // Adiciona os novos órgãos
            foreach ($organIds as $organTypeId) {
                // Verifica se o tipo de órgão existe
                $organType = $this->organTypeService->getById($organTypeId);

                if (!$organType) {
                    throw new \InvalidArgumentException("Tipo de órgão com ID $organTypeId não encontrado.");
                }

                // Cria o órgão associado ao usuário
                $organ = new Organ([
                    'organ_type_id' => $organTypeId,
                    'status' => $isDonor ? 'Pending' : 'Waiting',
                    'donor_id' => $isDonor ? $userId : null,
                    'recipient_id' => $isRecipient ? $userId : null,
                    'expiration_date' => $isRecipient ? now()->addMinutes($organType->default_preservation_time_minutes) : null,
                    'hospital_id' => null,
                    'matched_at' => null,
                    'completed_at' => null,
                ]);

                // Salva o órgão na base de dados
                $this->organService->create($organ->toArray());
            }

            // Confirma a transação
            DB::commit();
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            DB::rollBack();

            // Lança o erro para que possa ser tratado externamente
            throw $e;
        }
    }

    /**
     * Retorna um usuário com todos os dados relacionados.


    /**
     * Busca usuários por profile_id.
     */
    public function getUsersByProfile(?int $profileId)
    {
        return $this->userRepository->findByProfile($profileId);
    }

}
