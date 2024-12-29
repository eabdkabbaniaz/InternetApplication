<?php

namespace App\Listeners;

use App\Events\Log;
use App\Models\Logging;
use App\Repositories\LogRepository;

class Loglistener
{
    protected $logRepo;

    // protected $logRepo;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    
    public function handle(Log $event )
    {
         Logging::create($event->data);
// $log = Logging::create([
//     'user_id' => $event->userId,
//     'created_at' => now(),
//     'updated_at' => now(),
// ]);
    //   $logRepo->create($event->data);
    }


}
