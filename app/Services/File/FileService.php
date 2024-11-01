<?php

namespace App\Services\File;

use App\Http\Requests\FileStoreRequest;
use App\Repositories\FileRepositoryInterface;   // استخدام الواجهة
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;

class FileService
{
    protected $fileRepo;
    protected $imageService;

    public function __construct(FileRepositoryInterface $fileRepo, ImageService $imageService)
    {
        $this->fileRepo = $fileRepo;           // حقن الواجهة
        $this->imageService = $imageService;
    }

    public function storeFile(FileStoreRequest $request)
    {
        $input = $request->all();

        // تحميل الصورة باستخدام ImageService
        $input['path'] = $this->imageService->uploadImage($request, 'path', 'uploads/File/');
        $input['user_id'] = Auth::user()->id;

        // إنشاء الملف باستخدام ملف `FileRepository`
        return $this->fileRepo->createFile($input);
    }

    public function deactivateFileStatus($id)
    {
        $file = $this->fileRepo->findFileById($id);
        if ($file) {
            $this->fileRepo->deactivateFileStatus($file);
            return ['data' => ['file' => $file, 'message' => 'تم تحرير الملف'], 'status' => 200];
        }
        return ['data' => ['error' => 'File not found'], 'status' => 404];
    }

    public function deleteFile($id)
    {
        $file = $this->fileRepo->findFileById($id);
        if ($file) {
            $this->fileRepo->deleteFile($file);
            return ['data' => ['message' => 'File deleted successfully'], 'status' => 200];
        }
        return ['data' => ['error' => 'File not found'], 'status' => 404];
    }
}
