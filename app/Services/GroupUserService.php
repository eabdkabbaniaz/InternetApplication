<?php

namespace App\Services;

use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;

class GroupUserService
{
    public function addUsersToGroup(int $groupId, array $userIds)
    {
        $groupUsers = [];

        foreach ($userIds as $userId) {
            $groupUsers[] = GroupUser::create([
                'group_id' => $groupId,
                'user_id' => $userId,
            ]);
        }

        return $groupUsers;
    }
    public function getUserRoleInGroup($groupID)
    {
        $userID = Auth::user()->id;

        $groupUser = GroupUser::where('user_id', $userID)
            ->where('group_id', $groupID)
            ->first();

        return $groupUser;
    }
}
