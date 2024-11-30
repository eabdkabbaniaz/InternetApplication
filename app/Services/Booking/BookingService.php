<?php

namespace App\Services\Booking;

use App\Http\Responses\ResponseService;
use App\Models\Booking;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\DB;

class BookingService
{
    protected $repo;

    public function __construct(BookingRepository $BookingRepo)
    {
        $this->repo = $BookingRepo;
    }

    public function store($data)
    {
        $fileIds = $data->filesID;
        if (empty($fileIds)) {
            return ResponseService::error("No file IDs provided");
        }
        $files = File::whereIn('id', $fileIds)->lockForUpdate()->get();
        foreach ($files as $file) {
            if ($file->status == 1) {
                return ResponseService::error("Reservation cancelled because $file->name file were already reserved");
            }
        }
        return $this->repo->storeBooking($data, $files);
    }


      public function getBookingsByPivotIds(array $pivotIds)
      {
          return Booking::whereIn('id', $pivotIds)->get();
      }
  
      public function updateFilesStatus(array $fileIds)
      {
          File::whereIn('id', $fileIds)->update(['status' => 0]);
      }
  
      public function deleteBookings(array $pivotIds)
      {
          Booking::whereIn('id', $pivotIds)->delete();
      }

      public function cancelBooking(array $pivotIds)
      {
          DB::transaction(function () use ($pivotIds) {
              $bookings = $this->repo->getBookingsByPivotIds($pivotIds);
                $fileIds = $bookings->pluck('file_id')->toArray();
                $this->repo->updateFilesStatus($fileIds);
                $this->repo->deleteBookings($pivotIds);
          });
      }

      public function getUserFilesInGroup($userId, $groupId)
      {
          return $this->repo->getUserFilesInGroup($userId, $groupId);
      }
}
