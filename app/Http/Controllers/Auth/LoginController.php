<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('user')->plainTextToken;
            $success['name'] =  $user->name;
            return response()->json([
                'success' => $success,
                'message' => 'User login successfully.'
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised',
                'message' => 'Invalid email or password.'
            ], 401);
        }
    }
//.................................................................................................................................

    public function Register(Request $request)
    {
          try {
            if(User::where('email',$request->email)->first()){
                return  ResponseService::validation("email is already exist " ); 
            }
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            $token =  $user->createToken('user')->plainTextToken;
            return ResponseService::success("User Register successfully",$token);
        } catch ( Exception $e) {
            return  ResponseService::validation("An error occurred: " . $e->getMessage());        }
           
        } 
    
    
}
