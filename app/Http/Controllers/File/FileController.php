<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Models\File;
use App\Models\GroupFile;
use App\Models\Groups;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FileController extends Controller
{
    public function store(FileStoreRequest $request)
    {
        try {
            $input = $request->all();
            $input['path'] = $this->uploadeimage($request);
            $file = File::create($input);
            return response()->json([
                'file' => $file,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload file: ' . $e->getMessage()
            ], 500);
        }
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
            $file->status = 0;

            $file->save();
            return response()->json(['file' => $file, 'message' => 'تم تحرير الملف']);
        }
        return response()->json('file not found');
    }

    public function destroy(string $id , $groupId)
    {
        
        $file =   File::find($id);
        if ($file) {
            $file->delete();
            return response()->json('you are delete successfully');
        }
        return response()->json('file not found');
    }


    public function updateFileInGroup(Request $request)
    {
        $group = Groups::findOrFail($request->groupId);
        if (Gate::allows('manage-group', $group->id)) {
            return response()->json(['message' => 'File updated successfully.']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function update(Request $request)
    {
        try {
        $fileID =  $request->id;
        $file = File::findOrFail($fileID);

        $data = $request->all();
       
        if ($request->hasFile('path')) {
        $data['path'] = $this->uploadeimage($request);
        $file->path = $data['path'];
        $file->save();

        DB::table("versions")->insert([
            'name' => $request->name,
            'file_id' => $fileID,
            'path' => $file->path,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        }
        
        $file->update($data);

        return response()->json([
            'file' => $file,
            'message' => 'File updated successfully!'
        ], 200);
          
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload file: ' . $e->getMessage()
            ], 500);
        }   
    }

    public function getVersions($id)
    {
        $filesVersions = Version::all();
        $versions = [];
    
        foreach ($filesVersions as $fileVersion) {
            if ($fileVersion->file_id == $id) {
                $versions[] = $fileVersion;
            }
        }
    
        return response()->json([
            'versions' => $versions
        ]);
    }
}
