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




    // public function store(UserStoreRequest $request)
    // {
        
    //     try {
    //         $data = $request->all();
    //         $data['password'] =   Hash::make($request->password);
    //         $user = User::create($data);
    //         $userID = $user->id;
    //         GroupUser::create([
    //             'user_id' => $userID,
    //             'group_id' => $request->groupID
    //         ]);
    //         return response()->json([
    //             'user' => $user,
    //         ]);
    //     } catch (Exception $ex) {
    //         return $ex;
    //     }
    // }



    // في وحدة التحكم الخاصة بك:
public function showRequests()
{
     $requests = DB::table('telescope_entries')
        ->where('type', 'request')
        ->orderBy('created_at', 'desc')
        ->get();
        foreach($requests as $r){
            $array = explode(",", $r->content);
            // return $array[1];
            // $add[]=;
            $array1[] = explode(",", $array[1]);
        }
        // return $array1;
      foreach($array1 as $ar){
        // return $ar[0];
          $arr=  explode("/", $ar[0])  ;
          $array2[]= $arr[ count($arr) - 1  ];

      }

return $array2;

    return view('requests', compact('requests'));
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
