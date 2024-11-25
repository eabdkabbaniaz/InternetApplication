<?php

namespace App\Jobs;

use App\Repositories\VersionRepository;
use App\Services\File\compareFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // public $path =[];
    public $data;
    public   $verificationCode;
    public function __construct($data  ,  $verificationCode)
    {
 
        $this->data=$data;
        $this->verificationCode=$verificationCode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $verificationCode= $this ->verificationCode;
        $data=$this->data;
        // $verificationCode = rand(100000, 999999);
        // $data['verificationCode'] = (string)$verificationCode;
        Mail::raw("Your verification code is: {$verificationCode}", function ($message) use ($data) {
            $message->from('walaaalrehawi@gmail.com', 'walaa')
                ->to($data['email'])
                ->subject(' Verification Code ');    
        });    }
}
