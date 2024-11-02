<?php

namespace App\Repositories;

use App\Models\Groups;

interface GroupRepositoryInterface
{
    public function getAllGroups();
    public function createGroup(array $data);
    public function getGroupFiles($id);
    public function updateGroup($groupID, array $data);
    public function deleteGroup($id);
}
