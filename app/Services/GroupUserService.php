<?php

namespace App\Services;

use App\Http\Responses\ApiResponse;
use App\Models\GroupUser;
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

    public function addUsersToGroup(int $groupId, array $userIds)
    {
        return $this->groupUserRepository->addMultipleUsersToGroup($groupId, $userIds);
    }

    public function getUserRoleInGroup(int $groupId)
    {
        $userID = Auth::user()->id;
        return $this->groupUserRepository->getUserRoleInGroup($groupId, $userID);
    }

    public function removeUserFromGroup(int $groupId, int $userId)
    {
        return $this->groupUserRepository->removeUserFromGroup($groupId, $userId);
    }

    public function getUserGroups(int $userId)
    {
      
        return $this->groupUserRepository->getUserGroups($userId);
    }

    public function getUsersNotInGroup(int $groupId)
    {
        return $this->userRepository->getUsersNotInGroup($groupId);
    }
    public function getUserwaiting(int $groupId)
    {
        try {
            $user =$this->groupUserRepository->getUserwaiting($groupId);
                return ApiResponse::success( $user, "Show succ");
        } catch (\Exception $e) {
            return ApiResponse::error(['error' => $e->getMessage()], 200);
        }
         
    }

    public function Acceptinvitation( $groupId)
    {
        try {
            $group = $this->groupUserRepository->find($groupId);
            $data['isAccept']=1;
             $response= $this->groupUserRepository->Acceptinvitation($group ,$data);
                return ApiResponse::success(   $response , "Show succ");
        } catch (\Exception $e) {
            return ApiResponse::error(['error' => 'Failed to remove user from group: ' . $e->getMessage()], 200);
        }
       
    }
    // public function showWaitUser( $groupId)
    // {
    //     try {
    //         $group = $this->groupUserRepository->showWaitUser($groupId);
        
    //             return ApiResponse::success(   $group , "Show succ");
    //     } catch (\Exception $e) {
    //         return ApiResponse::error(['error' => 'Failed to remove user from group: ' . $e->getMessage()], 200);
    //     }
       
    // }
    public function showWaitgroup( )
    {
        try
        {
            $user = Auth::user()->id;
            $group = $this->groupUserRepository->showWaitgroup($user);
            return ApiResponse::success(   $group , "Show succ");
        } 
        catch (\Exception $e)
        {
            return ApiResponse::error(['error' => 'Failed to remove user from group: ' . $e->getMessage()], 200);
        }
       
    }
}
