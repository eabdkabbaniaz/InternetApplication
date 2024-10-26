<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Models\Groups;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group = Groups::all();
        return response()->json([
            'group' => $group
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupStoreRequest $request)
    {
        $userID = Auth::user()->id;
        $data = $request->all();
        $group = Groups::create($data);
        GroupUser::create([
             'group_id' => $group->id,
            'user_id' => $userID,
            'is_Admin' => true,
        ]);
        return response()->json([
            'group' => $group,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showAllFiles(string $id)
    {
        $groupFile =      Groups::with('files')->find($id);
        return response()->json(['groupFile' => $groupFile]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $groupID =  $request->id;
        $group = Groups::findOrFail($groupID);

        $data = $request->all();
        $group->update($data);

        return response()->json([
            'group' => $group,
            'message' => 'User updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group =   Groups::find($id);
        if ($group) {
            $group->delete();
            return response()->json('you are delete successfully');
        }
        return response()->json('group not found');
    }
}
