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
    // {

    //}

    //exists:categories

    // public function store(Request $request)
    // {

    //     $validated = $request->validate([
    //         'filesID' => 'required|array',
    //     ]);
    //     $userID = Auth::user()->id;
    //     foreach ($request->filesID  as $fileID) {
    //         $booking =   Booking::create([
    //             'user_id' => $userID,
    //             'file_id' => $fileID,
    //         ]);
    //         $file = File::find($fileID);
    //         $file->status = 1;
    //         $file->save();
    //     }

    //     return response()->json('تم تاكيد الحجز بنجاح  ');
    // }



    //...................................................................................................................ز
    public function store(BookingRequest $request)
    {
        return $this->bookingService->store($request);
    }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'filesID' => 'required|array',
    //     ]);
    //     $userID = Auth::user()->id;
    //     $fileIds = $request->filesID;
    //     if (empty($fileIds)) {
    //         return ResponseService::error("No file IDs provided");
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $files = File::whereIn('id', $fileIds)->lockForUpdate()->get();
    //         foreach ($files as $file) {
    //             if ($file->status == 1) {
    //                 DB::rollBack();
    //                 $response = new Response();
    //                 return  ResponseService::error("Reservation cancelled because $file->name file were already reserved");
    //             }
    //             Booking::create([
    //                 'user_id' => $userID,
    //                 'file_id' => $file->id,
    //             ]);
    //             $file->status = 1;
    //             $file->save();
    //         }
    //         DB::commit();
    //         return ResponseService::success("Files successfully reserved");
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return  ResponseService::validation("An error occurred: " . $e->getMessage());
    //     }
    // }
}
