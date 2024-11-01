<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    public function showProfile()
    {

        $userID = Auth::user()->id;
        $data = User::with('groups')->find($userID);
        return response()->json([
            'data' => $data
        ]);
    }
    public function showFile()
    {

        $userID = Auth::user()->id;
        $data = User::with('fileReservation')->find($userID);
        return response()->json([
            'data' => $data
        ]);
    }
}
