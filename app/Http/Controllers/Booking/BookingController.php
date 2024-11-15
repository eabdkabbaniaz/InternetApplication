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
   
}
