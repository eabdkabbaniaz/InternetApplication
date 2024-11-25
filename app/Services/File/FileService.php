<?php

namespace App\Services\File;

use App\Http\Requests\FileStoreRequest;
use App\Http\Responses\ResponseService;
use App\Jobs\UpdateFile;
use App\Models\Version;
use App\Repositories\FileRepository;
use App\Repositories\VersionRepository;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FileService
{
    protected $fileRepo;
    protected $imageService;
    public $versionRepository;
    public $compareFiles;

    public function __construct(compareFiles $compareFiles, FileRepository $fileRepo, ImageService $imageService ,VersionRepository $versionRepository)
    {
        $this->fileRepo = $fileRepo;         
        $this->imageService = $imageService;
        $this->versionRepository= $versionRepository;
        $this->compareFiles= $compareFiles;

    }

    public function storeFile(FileStoreRequest $request)
    {
        $input = $request->all();
        $input['path'] = $this->imageService->uploadImage($request, 'path', 'uploads/File/');
        $input['user_id'] = Auth::user()->id;
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
    public function update($request){
      
        try {
        $fileId= $request->id;
        $file=$this->fileRepo->findFileById($fileId);
        $path =$file->path;
        $data['path']= $this->imageService->uploadImage($request,  'path', 'uploads/File/');
  
        dispatch(new UpdateFile([$path,$data['path']] , $file , $this->versionRepository,$this->compareFiles ));

        return ResponseService::success('File updated successfully!');
        } 
        catch (\Exception $e) {
            return ResponseService::validation('Failed to upload file: '. $e->getMessage());

        }   
}

public function getVersions($id)
{
    try {
    $filesVersions = $this->versionRepository->getVersions($id);
    return ResponseService::success('version show succ',$filesVersions);
    } 
    catch (\Exception $e) {
        return ResponseService::validation('Failed to upload file: '. $e->getMessage());
    }   
}

}