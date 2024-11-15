<?php

namespace App\Services;

use App\Repositories\GroupUserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;


class GroupUserService
{
    protected $groupUserRepository;
    protected $userRepository;

    public function __construct(GroupUserRepository $groupUserRepository, UserRepository $userRepository)
    {
        $this->groupUserRepository = $groupUserRepository;
     
        $this->userRepository = $userRepository;
    }

    // إضافة مستخدمين إلى مجموعة
    public function addUsersToGroup(int $groupId, array $userIds)
    {
        return $this->groupUserRepository->addMultipleUsersToGroup($groupId, $userIds);
    }

    // استرجاع دور المستخدم في مجموعة معينة
    public function getUserRoleInGroup(int $groupId)
    {
        $userID = Auth::user()->id;
        return $this->groupUserRepository->getUserRoleInGroup($groupId, $userID);
    }

    // إزالة مستخدم من مجموعة
    public function removeUserFromGroup(int $groupId, int $userId)
    {
        return $this->groupUserRepository->removeUserFromGroup($groupId, $userId);
    }

    // استرجاع مجموعات المستخدم
    public function getUserGroups(int $userId)
    {
      
        return $this->groupUserRepository->getUserGroups($userId);
    }

    public function getUsersNotInGroup(int $groupId)
    {
        return $this->userRepository->getUsersNotInGroup($groupId);
    }
}
