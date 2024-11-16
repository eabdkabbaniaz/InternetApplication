<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function uploadImage(Request $request, $fileInputName, $directory = "/uploads/File/")
    {
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);
            $name = $file->getClientOriginalName();
            $filename = $name .'-'.time() . '.' . $file->getClientOriginalExtension();
            $path = $directory . $filename;
            $file->move(public_path($directory), $filename);
            return $path;
        }
        return null;
    }

   
}
