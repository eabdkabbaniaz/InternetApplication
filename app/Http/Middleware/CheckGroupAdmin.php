<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupAdmin
{
   
    public function handle(Request $request, Closure $next)
    {
      
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Authentication required. Please log in.'
            ], 401);
        }
    
        $userID = Auth::id(); 
        $user = User::find($userID);
    
        if (!$user) {
            return response()->json([
                'message' => 'User not found. Please log in with a valid account.'
            ], 404);
        }
    
        $groupId = $request->route('groupId'); 
    
        if (!$user->isAdmin($groupId)) {
            return response()->json([
                'message' => 'Unauthorized. You do not have admin access to this group.'
            ], 403);
        }
    
        return $next($request);
    }
    
}
