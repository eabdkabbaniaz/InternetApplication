<?php
namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    public function delete(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
}
