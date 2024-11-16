<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\GroupUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {

        $userID =  $request->id;
        $user = User::findOrFail($userID);

        $data = $request->all();
        $data['password'] = Hash::make($request['password']);
        $user->update($data);

        return response()->json([
            'user' => $user,
            'message' => 'User updated successfully!'
        ], 200);
    }


    public function destroy(string $id)
    {
        $user =   User::find($id);
        if ($user) {
            $user->delete();
            return response()->json('you are delete successfully');
        }
        return response()->json('user not found');
    }
}
