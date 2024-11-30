<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    
    public function showFile($groupId)
    {
        $userID = Auth::user()->id;
        $data = User::with(['fileReservation' => function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        }])->find($userID);

        return response()->json([
            'data' => $data
        ]);
    }
}
