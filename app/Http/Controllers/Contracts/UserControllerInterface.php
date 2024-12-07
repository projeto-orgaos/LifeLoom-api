<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Requests\User\CreateUserRequest;

interface UserControllerInterface
{
    public function store(CreateUserRequest $request);
}
