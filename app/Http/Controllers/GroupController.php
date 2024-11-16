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
            return  $this->groupService->getAllGroups();    
    }

    public function store(GroupStoreRequest $request)
    {
          return $this->groupService->createGroup($request->validated());
    }

    public function showAllFiles(string $id)
    {
          return $this->groupService->getGroupFiles($id);
    }

    public function update(Request $request,$groupId)
    {
       return $this->groupService->updateGroup($groupId, $request->all());
    }


    public function destroy(string $id)
    {
       return $this->groupService->deleteGroup($id);
    }
}
