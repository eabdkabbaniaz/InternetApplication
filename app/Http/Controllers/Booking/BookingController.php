<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Responses\ResponseService;
use App\Models\Booking;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Booking\BookingService;

class BookingController extends Controller
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
  

    public function store(BookingRequest $request)
    {
        return $this->bookingService->store($request);
    }

    public function cancelBooking(Request $request)
    {
        $pivotIds = $request->input('pivot_ids'); 
        $this->bookingService->cancelBooking($pivotIds);  
       // return   event(new   FolderEvent('hello world'));
        return response()->json(['message' => 'Bookings canceled successfully']);
    }
        public function showFile($groupId)
        {
            $userID = Auth::user()->id;
            $data = $this->bookingService->getUserFilesInGroup($userID, $groupId);
    
            return response()->json([
                'data' => $data
            ]);
        }
   
}
