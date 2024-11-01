<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Services\File\FileService;
use Illuminate\Http\Request;

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

    public function destroy($id)
    {
        $result = $this->fileService->deleteFile($id);
        return response()->json($result['data'], $result['status']);
    }
}
