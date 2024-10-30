<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Models\File;
use App\Models\GroupFile;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    public function store(FileStoreRequest $request)
    {
        try {
            $input = $request->all();
            $input['path'] = $this->uploadeimage($request);
            $input['user_id'] =  Auth::user()->id;
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

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);
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
}
