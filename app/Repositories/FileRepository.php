<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository implements FileRepositoryInterface
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

    public function deactivateFileStatus($file)
    {
        $file->status = 0;
        $this->saveFile($file);   // حفظ التعديلات
    }
    public function update($file ,$data)
    {
       return  $file->update($data);
    }
}
