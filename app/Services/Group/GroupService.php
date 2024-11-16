<?php
namespace App\Services\Group;

use App\Http\Responses\ApiResponse;
use App\Repositories\GroupRepository;
use App\Actions\Group\CreateGroupAction;

class GroupService
{
    protected $groupRepository;
    protected $createGroupAction;

    public function __construct(GroupRepository $groupRepository, CreateGroupAction $createGroupAction)
    {
        $this->groupRepository = $groupRepository;
        $this->createGroupAction = $createGroupAction;
    }

    public function getAllGroups()
    {

        try {
            $groups =$this->groupRepository->getAllGroups();
            return ApiResponse::success($groups);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve groups.', 500);
        }
    }

    public function createGroup($data)
    {
        try {
            $group = $this->createGroupAction->execute($data);
            return ApiResponse::success($group, 'Group created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to create group.', 500);
        } 
       
    }

    public function getGroupFiles($id)
    {
        try {
            $groupFile = $this->groupRepository->getGroupFiles($id);
            return $groupFile
                ? ApiResponse::success($groupFile)
                : ApiResponse::error('Group files not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve group files.', 500);
        }

    }

    public function updateGroup($groupID, $data)
    {
        
        try {

            $group =$this->groupRepository->updateGroup($groupID, $data);
            return $group
                ? ApiResponse::success($group, 'Group updated successfully.')
                : ApiResponse::error('Group not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to update group.', 500);
        }

    }

    public function deleteGroup($id)
    {
        try {
            $deleted = $this->groupRepository->deleteGroup($id);
            return $deleted
                ? ApiResponse::success(null, 'Group deleted successfully.')
                : ApiResponse::error('Group not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete group.', 500);
        }
    }
       
    
}
