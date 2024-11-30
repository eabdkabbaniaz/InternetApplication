<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Models\Booking;
use App\Models\File;
use App\Models\GroupFile;
use App\Models\Groups;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\File\FileService;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function store(FileStoreRequest $request)
    {
        try {
            $file = $this->fileService->storeFile($request);
            return response()->json(['file' => $file]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload file: ' . $e->getMessage()], 500);
        }
    }


    public function deActiveStatus(string $id)
    {
        $result = $this->fileService->deactivateFileStatus($id);
        return response()->json($result['data'], $result['status']);
    }
    public function deActiveStatus1(string $id)
    {
        $result = $this->fileService->deactivateFileStatus($id);
        return response()->json($result['data'], $result['status']);
    }

    public function destroy($id)
    {
        $result = $this->fileService->deleteFile($id);
        return response()->json($result['data'], $result['status']);
    }

    public function update(Request $request, $id)
    {
        $file = File::find($id);
        if ($file) {
            $file->update($request->all());
            return "hjldsa";
        }
        return "kjdf";
        //return  $this->fileService->update($request);
    }

    public function getVersions($id)
    {
        return  $this->fileService->getVersions($id);
    }

    public function cancelBooking(Request $request)
{
 
    $pivotId = $request->input('pivot_id'); 
    DB::transaction(function () use ($pivotId) {
        $bookings = Booking::whereIn('id', $pivotId)->get();
        $fileIds = $bookings->pluck('file_id')->toArray();
        File::whereIn('id', $fileIds)->update(['status' => 0]);
        Booking::whereIn('id', $pivotId)->delete();
    });
}

}
