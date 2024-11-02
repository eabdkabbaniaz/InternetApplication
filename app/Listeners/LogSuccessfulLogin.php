<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class LogSuccessfulLogin
{
   
    public function __construct()
    {
    }

    public function handle(Login $event)
    {
        DB::table('loggings')->insert([
            'user_id' => $event->user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
