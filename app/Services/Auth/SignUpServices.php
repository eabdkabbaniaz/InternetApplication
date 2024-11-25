<?php
namespace App\Services\Auth;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use App\Http\Responses\ResponseService;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;
class SignUpServices
{
  protected $userRepository;
 

  public function __construct(UserRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }


    public function confirmAccount($data){
      try{
      $verificationCode = rand(100000, 999999);
      $data['verificationCode'] = (string)$verificationCode;
      Mail::raw("Your verification code is: {$verificationCode}", function ($message) use ($data) {
          $message->from('walaaalrehawi@gmail.com', 'walaa')
              ->to($data['email'])
              ->subject(' Verification Code ');    
      });
      return ResponseService::success("massege was sending", $data);
  } catch (Exception $e) {
      return ResponseService::validation("An error occurred: " . $e->getMessage());
  }

    }
    public function register($data){
      try {
        $data['password'] = Hash::make($data['password']);
        $user =$this->userRepository->createUser($data);
        $user['token'] = $user->createToken('user')->plainTextToken;
        event(new UserLoggedIn($user['id']));
        return ResponseService::success("User Register successfully", $user);
    } catch (Exception $e) {
        return ResponseService::validation("An error occurred: " . $e->getMessage());
    }   
    }


    public function Logout($data){
      try {
        $token = PersonalAccessToken::findToken($data->bearerToken());
        $user = $token->tokenable->id;
        $this->userRepository->logoutUser();
        event(new UserLoggedOut($user));
        return response()->json([
            'message'=>'logged out'
        ]);

      }
      catch (Exception $e) {
        return ResponseService::validation("An error occurred: " . $e->getMessage());
    }   
    }

  }

