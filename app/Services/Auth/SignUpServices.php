<?php
namespace App\Services\Auth;
use App\Http\Responses\ResponseService;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
      $data['verificationCode'] = $verificationCode;
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
        return ResponseService::success("User Register successfully", $user);
    } catch (Exception $e) {
        return ResponseService::validation("An error occurred: " . $e->getMessage());
    }   
    }

  }

