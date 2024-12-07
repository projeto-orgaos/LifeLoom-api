<?php


namespace App\Services\Contracts;

interface AuthServiceInterface
{
    public function login(array $credentials): array;
}
