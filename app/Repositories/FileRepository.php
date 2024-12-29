<?php

namespace App\Repositories;

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
    public function findFileByGroupId($id)
    {
        return $file = File::where('group_id',$id)->select('id');
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

    public function showfile($id)
    {
        // return $group->all();
     return  $file =File::with('users')->where('Active',0)->where('group_id',$id)->get();
  
    }
    public function showmywaitingfile($user_id)
    {
        // return $group->all();
     return  $file =File::where([['Active',0],['user_id',$user_id]])->get();
  
    }
    // public function ActiveFile($id)
    // {
    //  return  $file =File::where([['Active',0],['user_id',$user_id]])->get();
    // }
}
