<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Models\Logging;

class LogSuccessfulLogout
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
    public function handle(UserLoggedOut $event)
    {
       Logging::where('user_id', $event->userId)->delete();
    }
}
