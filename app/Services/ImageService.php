<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{


    public function uploadImage(Request $request, $fileInputName, $directory = '/uploads/File/')
    {
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);
            $name = $file->getClientOriginalName();
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = '/uploads/File/' . $filename;
            $dd = '/uploads/File';
           $file->move(public_path($dd),$filename);
            return $path;
        }
        return null;
    }

   
}
