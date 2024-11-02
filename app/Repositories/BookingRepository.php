<?php

namespace App\Repositories;

use App\Http\Responses\ResponseService;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRepository implements BookingRepositoryInterface
{
    public function storeBooking($data, $files)
    {
        $userID = Auth::user()->id;

        DB::beginTransaction();
        try {
            foreach ($files as $file) {
                Booking::create([
                    'user_id' => $userID,
                    'file_id' => $file->id,
                ]);
                
                $file->status = 1;
                $file->save();
            }

            DB::commit();
            return ResponseService::success("Files successfully reserved");

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::validation("An error occurred: " . $e->getMessage());
        }
    }
}
