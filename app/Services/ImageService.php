<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{
// $fileInputName  هاد اسم المتغير اللي عم تبعتو من البوست مان 
// directory  المكان اللي بدك تخزن فيه 

    public function uploadImage(Request $request, $fileInputName, $directory = "/uploads/File/")
    {
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);
            $name = $file->getClientOriginalName(); // هنا يتم الحصول على الاسم الأصلي للملف
            $filename = $name .'-'.time() . '.' . $file->getClientOriginalExtension();
            $path = $directory . $filename;
            $file->move(public_path($directory), $filename);
            return $path;
        }
        return null;
    }

   
}
