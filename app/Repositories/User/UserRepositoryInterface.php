<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepository;

interface UserRepositoryInterface 
{
    public function all();

    public function allNotAdmin();

}

