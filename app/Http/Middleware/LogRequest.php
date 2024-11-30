<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Spatie\Activitylog\Models\Activity; 

class LogRequest
{

    public function handle(Request $request, Closure $next)
    {
        // Activity::create([
        //     'description' => 'Request to ' . $request->url() . ' using ' . $request->method(),
        //     'user_id' => auth()->check() ? auth()->id() : null, // ID المستخدم إذا كان مسجلاً
        //     'log_name' => 'custom_log', // اختيار اسم السجل
        // ]);

        return $next($request);
    }
}

