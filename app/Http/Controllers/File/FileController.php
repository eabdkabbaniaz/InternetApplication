<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Models\File;
use App\Models\GroupFile;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(FileStoreRequest $request)
    {
        $input = $request->all();
        $input['path'] = $this->uploadeimage($request);
        $data = [
            'name' => $request->name,
            'path' => $input['path'],
        ];
        $file = File::create($data);
        $fileID = $file->id;
        $groupFile = [];
        foreach ($request->groupsID  as $groupID) {
            $gFile =   GroupFile::create([
                'file_id' => $fileID,
                'group_id' => $groupID,
            ]);
            $groupFile[] = [$gFile];
        }
        return response()->json([
            'file' => $file,
            'groupFile' => $groupFile
        ]);
    }
    public function uploadeimage($request)
    {

        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/File/', $filename);
            return    $input['path'] = 'uploads/File/' . $filename;
        }
    }



 
    public function deActiveStatus(string $id)
    {
        $file =   File::find($id);
        if ($file) {
            $file->status=0;

            $file->save();
            return response()->json(['file'=>$file,'message'=>'تم تحرير الملف']);
        }
        return response()->json('file not found');
    }

    public function destroy(string $id)
    {
        $file =   File::find($id);
        if ($file) {
            $file->delete();
            return response()->json('you are delete successfully');
        }
        return response()->json('file not found');
    }
}
