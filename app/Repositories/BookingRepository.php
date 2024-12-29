<?php

namespace App\Repositories;

use App\Events\Log;
use App\Http\Responses\ResponseService;
use App\Models\Booking;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRepository 
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
                $log['file_id']=$file->id;
                $log['user_id']= $userID ;
                $log['Oprationid']='B';        
                event(new   Log($log));
            }

            DB::commit();
            return ResponseService::success("Files successfully reserved");

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::validation("An error occurred: " . $e->getMessage());
        }
    }

    
   
    public function getBookingsWithFiles(array $pivotIds)
    {
        return Booking::whereIn('id', $pivotIds)
            ->with([
                'file:id,name,group_id',
                'file.group:id,name'    
            ])
            ->get();
    }
    
    
    public function updateFilesStatus(array $fileIds)
    {
        File::whereIn('id', $fileIds)->update(['status' => 0]);
    }

   
    public function deleteBookings(array $pivotIds)
    {
        Booking::whereIn('id', $pivotIds)->delete();

    }

    public function getUserFilesInGroup($userId, $groupId)
{
    return User::with(['fileReservation' => function ($query) use ($groupId) {
        $query->where('group_id', $groupId);
    }])
    ->findOrFail($userId);  
}

}
