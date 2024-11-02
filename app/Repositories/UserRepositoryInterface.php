<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUser();
    public function createUser($massege);
    public function findUser($massege);
    // public function Logout();
    // public function deleteUser($massege);
}
