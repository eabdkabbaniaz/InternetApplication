<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository 
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

    public function getUsersNotInGroup(int $groupId)
    {
        return User::whereDoesntHave('groups', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->get();
    }

}
