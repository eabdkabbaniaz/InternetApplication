<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    public function getAllUser()
    {
        return User::all();
    }

    public function createUser($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function findUser($data)
    {
        $user = User::where('email', $data)->first();    
        return $user;
    }

}
