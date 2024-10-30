<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Mail\AccountConfirmationMail;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Mail;

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

    // public function Register(Request $request)
    // {
    //       try {
    //         if(User::where('email',$request->email)->first()){
    //             return  ResponseService::validation("email is already exist " ); 
    //         }
    //         $data = $request->all();
    //         $data['password'] = FacadesHash::make($request->password);
    //         $user = User::create($data);
    //         $token =  $user->createToken('user')->plainTextToken;
    //         return ResponseService::success("User Register successfully",$token);
    //     } catch ( Exception $e) {
    //         return  ResponseService::validation("An error occurred: " . $e->getMessage());        }
           
    //     } 
    
    // في ملف AuthController.php
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $input=$request->all();
    $input['confirmation_code']=  rand(100000, 999999);
 
    $user = User::create(
        $input
    );
    Mail::to($user->email)->send(new AccountConfirmationMail($user->confirmation_code));

    return response()->json([
        'message' => 'تم تسجيلك بنجاح. الرجاء التحقق من بريدك الإلكتروني للحصول على رمز التأكيد.',
    ], 201);
}

public function confirmAccount(Request $request)
{
    $request->validate(['confirmation_code' => 'required|integer']);

    $user = User::where('confirmation_code', $request->confirmation_code)->first();

    if (!$user) {
        return response()->json(['error' => 'رمز التأكيد غير صحيح.'], 400);
    }
    $user->confirmed = true;
    $user->confirmation_code = 0;
    $user->save();
    return response()->json(['message' => 'تم تأكيد حسابك بنجاح!'], 200);
}
}
