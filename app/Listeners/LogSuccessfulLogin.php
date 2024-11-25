<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\Logging;

class LogSuccessfulLogin
{
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
    public function handle(UserLoggedIn $event)
    {
$log = Logging::create([
    'user_id' => $event->userId,
    'created_at' => now(),
    'updated_at' => now(),
]);
      
    }


}
