<?php

namespace App\Repositories;

use App\Models\Groups;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;

class GroupRepository
{

    public function getAllGroups()
    {
        return Groups::all();
    }

    public function createGroup(array $data)
    {
        $userID = Auth::user()->id;
        $group = Groups::create($data);

        GroupUser::create([
            'group_id' => $group->id,
            'user_id' => $userID,
            'is_Admin' => true,
        ]);

        return $group;
    }


    public function getGroupFiles($id)
    {
        return Groups::with('files')->find($id);
    }


    public function updateGroup($groupID, array $data)
    {
        $group = Groups::findOrFail($groupID);
        $group->update($data);
        return $group;
    }


    public function deleteGroup($id)
    {
        $group = Groups::find($id);
        if ($group) {
            $group->delete();
            return true;
        }
        return false;
    }
}
