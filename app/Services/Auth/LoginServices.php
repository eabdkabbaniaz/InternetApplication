<?php

namespace App\Services\Auth;

use App\Http\Responses\ResponseService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
class LoginServices    
{
  protected $userRepository;
 

  public function __construct(UserRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }

    public function login($massege){
      $user =$this->userRepository->findUser($massege['email']);
      if (!$user) {
          return ResponseService::error("Invalid email.", "", 422);
      }
      if (!Hash::check($massege['password'], $user->password)) {
          return ResponseService::error("Invalid password.", "", 422);
      }
      $user['token'] = $user->createToken('User')->plainTextToken;
      return ResponseService::success('User login successfully.', $user);
      }  
}