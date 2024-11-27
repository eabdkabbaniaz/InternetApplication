<?php

namespace App\Repositories;
use App\Http\Responses\ResponseService;


use App\Models\File;

class FileRepository 
{
    public function createFile(array $data)
    {
        return File::create($data);  // إنشاء ملف جديد
    }

    public function findFileById($id)
    {
        return File::find($id);     // إيجاد ملف بناءً على ID
    }

    public function saveFile($file)
    {
        $file->save();             // حفظ أي تعديلات على الملف
    }

    public function deleteFile($file)
    {
        $file->delete();           // حذف ملف
    }

    public function deactivateFileStatus($request, $fileIds)
    {
            foreach ($fileIds as $file) {
              
                $file->status = 0;
                $file->save();
            }

            return ResponseService::success("Files successfully unreserved");
    }

    public function update($file ,$data)
    {
       return  $file->update($data);
    }
}
