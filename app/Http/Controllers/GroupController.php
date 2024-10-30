<?php
namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Services\Group\GroupService;
use App\Http\Responses\ApiResponse; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

   
    public function index()
    {
        try {
            $groups = $this->groupService->getAllGroups();
            return ApiResponse::success($groups);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve groups.', 500);
        }
    }

   
    public function store(GroupStoreRequest $request)
    {
        try {
            $data = $request->validated(); 
            $group = $this->groupService->createGroup($data);
            return ApiResponse::success($group, 'Group created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to create group.', 500);
        }
    }

   
    public function showAllFiles(string $id)
    {
        try {
            $groupFile = $this->groupService->getGroupFiles($id);
            return $groupFile 
                ? ApiResponse::success($groupFile) 
                : ApiResponse::error('Group files not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve group files.', 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $groupID = $request->id;
            $data = $request->all(); 
           return $group = $this->groupService->updateGroup($groupID, $data);
            return $group 
                ? ApiResponse::success($group, 'Group updated successfully.')
                : ApiResponse::error('Group not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to update group.', 500);
        }
    }

   
    public function destroy(string $id)
    {
        try {
            $deleted = $this->groupService->deleteGroup($id);
            return $deleted 
                ? ApiResponse::success(null, 'Group deleted successfully.') 
                : ApiResponse::error('Group not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete group.', 500);
        }
    }
}
