<?php

namespace App\Services\File;

use App\Events\Log;
use App\Http\Requests\FileStoreRequest;
use App\Http\Responses\ResponseService;
use App\Jobs\UpdateFile;
use App\Models\Groups;
use App\Models\GroupUser;
use App\Models\Version;
use App\Repositories\FileRepository;
use App\Repositories\VersionRepository;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Request;

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
        $input['name'] = $request->name;
        $input['group_id'] = $request->group_id;
        $input['path'] = $this->imageService->uploadImage($request, 'path', 'uploads/File/');
        $input['user_id'] = Auth::user()->id;
        $input['Active'] = $request->admaiId;
     
        // $admin = GroupUser::where([['group_id',$request->group_id],['is_admin',1]])->first();
        $file= $this->fileRepo->createFile($input );
        $data['file_id']=$file->id;
        $data['user_id']= $input['user_id'] ;
        $data['Oprationid']='A';

        event(new Log($data));
        return   $file;
        //send notification 
    }
    public function showfile($id)
    {

        try {
         $file= $this->fileRepo->showfile($id);
        return ResponseService::success('show successfully.', $file);    
    } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload file: ' . $e->getMessage()], 500);
        }
       
    // send notification 
    }
    public function showmywaitingfile( )
    {

        try {
            $user=Auth::user()->id;
            $file = $this->fileRepo->showmywaitingfile($user);
        return ResponseService::success('show successfully.', $file);    
    } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload file: ' . $e->getMessage()], 500);
        }
       
    // send notification 
    }
    public function ActiveFile( $id)
    {
        try {
            $data['Active']=1;
            $file=$this->fileRepo->findFileById($id);
            $active = $this->fileRepo->update($file, $data);
        return ResponseService::success('Active successfully.', $active);    
    } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload file: ' . $e->getMessage()], 500);
        }
       
    // send notification 
    }
 

    // public function storeFile(FileStoreRequest $request)
    // {
    //     $input = $request->all();
    //     $input['path'] = $this->imageService->uploadImage($request, 'path', 'uploads/File/');
    //     $input['user_id'] = Auth::user()->id;
    //     return $this->fileRepo->showfile():
    // }


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
        $user_id = Auth::user()->id;
        
        dispatch(new UpdateFile([$path,$data['path']] ,$user_id, $file , $this->versionRepository,$this->compareFiles ));
        $file=$this->fileRepo->update($file , $data);
        $Log['file_id']=$fileId;
        $Log['user_id']=  $user_id ;
        $Log['Oprationid']='U';

        event(new   Log($Log));
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