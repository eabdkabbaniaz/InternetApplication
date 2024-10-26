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
            $user = User::with('groups')->findOrFail($userID);
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
}
