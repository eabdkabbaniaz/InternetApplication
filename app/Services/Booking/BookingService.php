<?php

namespace App\Services\Booking;

use App\Http\Responses\ResponseService;
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
}
