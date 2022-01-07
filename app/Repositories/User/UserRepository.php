<?php

namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface 
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    
    public function all() 
    {
        return $this->userModel->get();
    }

    public function allNotAdmin()
    {
        return $this->userModel->notAdmin()->get();
    }

}