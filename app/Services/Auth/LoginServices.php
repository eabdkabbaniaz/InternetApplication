<?php

namespace App\Services\Auth;

use App\Events\UserLoggedIn;
use App\Http\Responses\ResponseService;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
class LoginServices    
{
  protected $userRepository;
 

  public function __construct(UserRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }

    public function login($massege){
      try{
      $user =$this->userRepository->findUser($massege['email']);
      if (!$user) {
          return ResponseService::error("Invalid email.", "", 422);
      }
      if (!Hash::check($massege['password'], $user->password)) {
          return ResponseService::error("Invalid password.", "", 422);
      }
      $user['token'] = $user->createToken('User')->plainTextToken;
      // return $user->id;
      event(new UserLoggedIn($user['id']));
      return ResponseService::success('User login successfully.', $user);
         }
         catch (Exception $e) {
          return ResponseService::validation("An error occurred: " . $e->getMessage());
      }   

        }  

            }