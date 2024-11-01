<?php

namespace App\Repositories;

interface FileRepositoryInterface
{
    public function createFile(array $data);         // لإنشاء ملف جديد
    public function findFileById($id);               // لإيجاد ملف بناءً على ID
    public function saveFile($file);                 // لحفظ أي تعديلات في الملف
    public function deleteFile($file);               // لحذف ملف
    public function deactivateFileStatus($file);     // لتغيير حالة الملف إلى غير مفعل
}
