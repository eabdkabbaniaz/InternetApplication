<?php

namespace App\Services\Booking;

use App\Events\FolderEvent;
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

   

    public function cancelBooking(array $pivotIds, $groupId)
    {
        DB::beginTransaction();
        try {
            $bookings = $this->repo->getBookingsWithFiles($pivotIds);
            $fileIds = $bookings->pluck('file.id')->toArray();
            $fileNames = $bookings->pluck('file.name')->toArray();
            $groupName = $bookings->first()?->file?->group?->name ?? 'No Group';
            $this->repo->updateFilesStatus($fileIds);
            $this->repo->deleteBookings($pivotIds);
            event(new FolderEvent("تم فك حجز الملفات التالية", $fileNames, $groupId, $groupName));
            DB::commit();
            return ResponseService::success("Bookings canceled successfully");
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseService::error("Failed to cancel bookings");
        }
    }


    public function getUserFilesInGroup($userId, $groupId)
    {
        try {
            $data = $this->repo->getUserFilesInGroup($userId, $groupId);
            return ResponseService::success("Files retrieved successfully", $data);
        } catch (\Exception $e) {
            return ResponseService::error("Failed to retrieve files");
        }
    }
}
