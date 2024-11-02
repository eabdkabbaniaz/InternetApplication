<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckFileDelete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $userID = Auth::user()->id;
        $user =     User::find($userID);

        $groupId = $request->route('groupId');
        $fileId = $request->route('id');

        if (
            !$user ||
            (!$user->isAdmin($groupId) && !$this->isFileOwner($fileId, $userID))
        ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }

    private function isFileOwner($fileId, $userId)
    {
        $file = File::find($fileId);
        return $file && $file->user_id == $userId;
    }
}
