<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\GroupFile;
use App\Models\Groups;
use App\Models\Logging;
use App\Models\User;
use App\Models\Version;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Storage;
use App\Models\File;
use View;

class ReportController extends Controller
{
    

    public static function downloadPDF(Request $request)
    {
        // $token = PersonalAccessToken::findToken($request->bearerToken());
        $user = User::find($request->id);
        // $startOfWeek = Carbon::now()->startOfMonth();
        // $endOfWeek = Carbon::now()->endOfMonth();
        $userdata = Logging::withTrashed()->whereBetween('created_at', [$request->start, $request->end])
                        ->orWhereBetween('deleted_at', [$request->start, $request->end])
                        ->where('user_id' ,$request->id)
                        ->get();              
 $name= $user->name;
 $pdf = \PDF::loadView('user_report',compact('userdata','name'  ));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("walaa.$request->ex");
}

public static function generatePDF(Request $request)
{
    

    
    // $token = PersonalAccessToken::findToken($request->bearerToken());
    $user = User::find($request->id);
    $userdata = Logging::withTrashed()->whereBetween('created_at', [$request->start, $request->end])
    ->orWhereBetween('deleted_at', [$request->start, $request->end])
    ->where('user_id' ,$request->id)
    ->get();             
$name= $user->name;
return ApiResponse::success($userdata , $name);

}
public static function generatefilePDF(Request $request)
{

    // if($request->start==null){
    //     $request->start =10-10-2020;
    //     $request->end = Carbon::now();
    // }

    // $token = PersonalAccessToken::findToken($request->bearerToken());
     $Group = Groups::where('id',$request->group_id)->with('files.Version','files.users')->first();
   foreach($Group->files as $u){
   if(!$u->version->isempty()){
    // return $user;
    $u['operation']="update";
   }
   else{
    $u['operation']="Add";


   }
}
return $Group;
// return view('groupReport',compact('Group'));
$pdf = \PDF::loadView('groupReport',compact('Group'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("walaa1.$request->ex");

// return ApiResponse::success($userdata , $name);

}












public static function generatfilePDF(Request $request)
{
    // $token = PersonalAccessToken::findToken($request->bearerToken());
     $Group = Version::where('file_id',$request->file_id)->with('files.Version','files.users')->first();
   foreach($Group->files as $u){
   if(!$u->version->isempty()){
    // return $user;
    $u['operation']="update";
   }
   else{
    $u['operation']="Add";

   }
}
// return $Group;
// return view('groupReport',compact('Group'));
$pdf = \PDF::loadView('groupReport',compact('Group'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("walaa1.$request->ex");

// return ApiResponse::success($userdata , $name);

}
}

