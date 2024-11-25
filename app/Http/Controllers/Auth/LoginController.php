<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Services\Auth\LoginServices;
use App\Services\Auth\SignUpServices;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginServices;
    protected $signUpServices;
 

  public function __construct(LoginServices $loginServices,SignUpServices $signUpServices)
  {
      $this->loginServices = $loginServices;
      $this->signUpServices = $signUpServices;
  }
 
    public function login(Request $request)
    {
        return $this->loginServices->login($request);    
}
    public function confirmAccount(SignUpRequest $request)
    {
        return $this->signUpServices->confirmAccount($request->validated());    
    }
    public function Register(SignUpRequest $request)
    {
            return $this->signUpServices->register($request->validated());          
    }


    public function logout(Request $request){
     return $this->signUpServices->Logout($request);
    }

}
