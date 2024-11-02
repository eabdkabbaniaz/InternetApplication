<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Models\Logging;

class LogSuccessfulLogout
{

    public function __construct()
    {
        
    }

    public function handle(UserLoggedOut $event)
    {
       Logging::where('user_id', $event->userId)->delete();
    }
}
