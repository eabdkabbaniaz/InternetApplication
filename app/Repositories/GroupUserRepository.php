<?php

namespace App\Repositories;

use App\Models\GroupUser;
use App\Models\User;

class GroupUserRepository
{
    // إضافة عدة مستخدمين إلى مجموعة
    public function addMultipleUsersToGroup(int $groupId, array $userIds)
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

    // استرجاع دور المستخدم في مجموعة معينة
    public function getUserRoleInGroup(int $groupId, int $userId)
    {
        return GroupUser::where('group_id', $groupId)
                        ->where('user_id', $userId)
                        ->first();
    }

    // إزالة مستخدم من مجموعة
    public function removeUserFromGroup(int $groupId, int $userId)
    {
        $groupUser = GroupUser::where('group_id', $groupId)
                              ->where('user_id', $userId)
                              ->first();
        if ($groupUser) {
            $groupUser->delete();
            return true;
        }
        return false;
    }

   

    public function getUserGroups(int $userId)
    {
        return User::with('groups')->findOrFail($userId);
    }
}
