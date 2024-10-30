<?php
namespace App\Services\Group;

use App\Repositories\GroupRepositoryInterface;
use App\Actions\Group\CreateGroupAction;

class GroupService
{
    protected $groupRepository;
    protected $createGroupAction;

    public function __construct(GroupRepositoryInterface $groupRepository, CreateGroupAction $createGroupAction)
    {
        $this->groupRepository = $groupRepository;
        $this->createGroupAction = $createGroupAction;
    }

    public function getAllGroups()
    {
        return $this->groupRepository->getAllGroups();
    }

    public function createGroup($data)
    {
        return $this->createGroupAction->execute($data);
    }

    public function getGroupFiles($id)
    {
        return $this->groupRepository->getGroupFiles($id);
    }

    public function updateGroup($groupID, $data)
    {
        return $this->groupRepository->updateGroup($groupID, $data);
    }

    public function deleteGroup($id)
    {
        return $this->groupRepository->deleteGroup($id);
    }
}
