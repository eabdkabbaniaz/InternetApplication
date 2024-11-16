<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUsersToGroupRequest;
use App\Models\Groups;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Services\GroupUserService;
use Illuminate\Support\Facades\Response;
use App\Http\Responses;
use App\Http\Responses\ApiResponse;

class UserGroupController extends Controller
{


    protected $groupUserService;

    public function __construct(GroupUserService $groupUserService)
    {
        $this->groupUserService = $groupUserService;
    }
    public function store(AddUsersToGroupRequest $request)
    {
        try {
            $groupId = $request->groupId;
            $group = Groups::findOrFail($groupId);
            $groupUsers = $this->groupUserService->addUsersToGroup($groupId, $request->users);
            return Response::json([
                'group' => $group,
                'groupUsers' => $groupUsers,
            ], 201);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to add users to group: ' . $e->getMessage()], 500);
        }
    }
    public function show(Request $request)
    {
        try {
            $userID = Auth::user()->id;
            $user = $this->groupUserService->getUserGroups($userID);
            return Response::json([
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to add users to group: ' . $e->getMessage()], 500);
        }
    }

    public function getRoleUser($groupID)
    {
        try {
            $groupUser = $this->groupUserService->getUserRoleInGroup($groupID);
            if (!$groupUser) {
                return Response::json(['error' => 'User not found in the group'], 404);
            }
            $role = $groupUser->is_admin ? 'is admin' : 'is user';
            return Response::json([
                'user' => $groupUser,
                'role' => $role,
            ], 200);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to retrieve user role: ' . $e->getMessage()], 500);
        }
    }
    public function removeUser($groupId, $userId)
    {
        try {
            $removed = $this->groupUserService->removeUserFromGroup($groupId, $userId);
            if ($removed) {
                return ApiResponse::success('', "تمت إزالة المستخدم من المجموعة بنجاح.");
            } else {
                return ApiResponse::success('', "المستخدم غير موجود في هذه المجموعة.");
            }
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to remove user from group: ' . $e->getMessage()], 500);
        }
    }
    public function getUserByGroupId($groupId)
    {
        try {
            $removed = Groups::with('users')->findorFail($groupId);
            if ($removed) {
                return ApiResponse::success('', "تمت إزالة المستخدم من المجموعة بنجاح.");
            } else {
                return ApiResponse::success('', "المستخدم غير موجود في هذه المجموعة.");
            }
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to remove user from group: ' . $e->getMessage()], 500);
        }
    }

    public function getUsersNotInGroup($groupId)
    {
        try {
            $users = $this->groupUserService->getUsersNotInGroup($groupId);

            return Response::json([
                'users' => $users,
            ], 200);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to retrieve users: ' . $e->getMessage()], 500);
        }
    }
}
