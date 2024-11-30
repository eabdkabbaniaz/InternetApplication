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
        $user = User::find($request->id);
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
    if($request->start==null)
{
    $start =" 2000-11-15";
    $end =Carbon::now();

}  
else{
    $start=$request->start;
    $end=$request->end;
}
$group=[];
      $Groups = Groups::where('id',$request->group_id)->with('files.Version.users','files.booking.user','files.users')->first();
   foreach($Groups->files as $u){
if($u->created_at >=$start &&$u->created_at <=$end ){
    $u['operation']="Add";
    $group[]=$u;
}
if(!$u->booking->isempty()){

    foreach($u->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end ){
            $file['name']=$u->name;
            $file['path']=$u->path;            
            $file['created_at']=$b->created_at;
            $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
    }}}
if(!$u->version->isempty()){
    foreach($u->version as $v){
        if($v->created_at >=$start &&$v->created_at <=$end )
        {
          $file =$v;
          $file['users']=$v->users;
          $file['operation']="update";
          $group[]=$file;
        }}}  
}
$data ['name']=  $Groups->name;
$data ['created_at']=  $Groups->created_at;
 $data['files']=$group;

return $data;

}
public static function generatefile(Request $request)
{
    if($request->start==null)
{
    $start =" 2000-11-15";
    $end =Carbon::now();

}  
else{
    $start=$request->start;
    $end=$request->end;
}
$group=[];
      $myfile = File::where('id',$request->file_id)->with('Version.users','booking.user','users')->first();
//    foreach($Groups as $u){
if($myfile->created_at >=$start &&$myfile->created_at <=$end ){
    $myfile['operation']="Add";
    $group[]=$myfile;
}
if(!$myfile->booking->isempty()){

    foreach($myfile->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end ){
            $file['name']=$myfile->name;
            $file['path']=$myfile->path;            
            $file['created_at']=$b->created_at;
            $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
    }}}
if(!$myfile->version->isempty()){
    foreach($myfile->version as $v){
        if($v->created_at >=$start &&$v->created_at <=$end )
        {
          $file =$v;
          $file['users']=$v->users;
          $file['operation']="update";
          $group[]=$file;
        }}}  

$data ['name']=  $myfile->name;
$data ['created_at']=  $myfile->created_at;
 $data['files']=$group;

return $data;

}
public static function Downloadfile(Request $request)
{
    if($request->start==null)
{
    $start =" 2000-11-15";
    $end =Carbon::now();

}  
else{
    $start=$request->start;
    $end=$request->end;
}
$group=[];
      $myfile = File::where('id',$request->file_id)->with('Version.users','booking.user','users')->first();
//    foreach($Groups as $u){
if($myfile->created_at >=$start &&$myfile->created_at <=$end ){
    $myfile['operation']="Add";
    $group[]=$myfile;
}
if(!$myfile->booking->isempty()){

    foreach($myfile->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end ){
            $file['name']=$myfile->name;
            $file['path']=$myfile->path;            
            $file['created_at']=$b->created_at;
            $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
    }}}
if(!$myfile->version->isempty()){
    foreach($myfile->version as $v){
        if($v->created_at >=$start &&$v->created_at <=$end )
        {
          $file =$v;
          $file['users']=$v->users;
          $file['operation']="update";
          $group[]=$file;
        }}}  

$data ['name']=  $myfile->name;
$data ['created_at']=  $myfile->created_at;
 $data['files']=$group;

 $pdf = \PDF::loadView('groupReport',compact('data'));   
 $filePath = 'public/user_'. time() . '.' . $request->ex;
  $ww= Storage::put($filePath, $pdf->output());
 return $pdf->download("walaa1.$request->ex");
 
}
public static function DownloadfilePDF(Request $request)
{
    if($request->start==null)
    {
        $start =" 2000-11-15";
        $end =Carbon::now();
    
    }  
    else{
        $start=$request->start;
        $end=$request->end;
    }
    $group=[];
      $Groups = Groups::where('id',$request->group_id)->with('files.Version.users','files.booking.user','files.users')->first();
   foreach($Groups->files as $u){
if($u->created_at >=$start &&$u->created_at <=$end ){
    $u['operation']="Add";
    $group[]=$u;
}
if(!$u->booking->isempty()){

    foreach($u->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end ){
            $file['name']=$u->name;
            $file['path']=$u->path;            
            $file['created_at']=$b->created_at;
            $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
    }}}
if(!$u->version->isempty()){
    foreach($u->version as $v){
        if($v->created_at >=$start &&$v->created_at <=$end )
        {
          $file =$v;
          $file['users']=$v->users;
          $file['operation']="update";
          $group[]=$file;
        }}}  
}
$data ['name']=  $Groups->name;
$data ['created_at']=  $Groups->created_at;
 $data['files']=$group;
$pdf = \PDF::loadView('groupReport',compact('data'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("walaa1.$request->ex");

}
public static function generateuserPDF(Request $request)
{
    if($request->start==null)
    {
        $start =" 2000-11-15";
        $end =Carbon::now();
    
    }  
    else{
        $start=$request->start;
        $end=$request->end;
    }
    $group=[];
     $Groups = Groups::where('id',$request->group_id)->with('files.Version.users','files.booking.user','files.users')->first();
   foreach($Groups->files as $u){
if($u->created_at >=$start &&$u->created_at <=$end &&$u->user_id==$request->user_id){
    $u['operation']="Add";
    $group[]=$u;
}
if(!$u->booking->isempty()){
    foreach($u->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end &&$b->user_id==$request->user_id ){
            
            $file['name']=$u->name;
            $file['path']=$u->path;
            $file['created_at']=$b->created_at;
        $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
  
    }
            }

}
    if(!$u->version->isempty()){
    foreach($u->version as $v){
if($v->created_at >=$start &&$v->created_at <=$end &&$v->user_id==$request->user_id ){
    {
        $file =$v;
        $file['users']=$v->users;
        // return $file;
            $file['operation']="update";
        $group[]=$file;
    }
}
    }

}
$data ['name']=  $Groups->name;
$data ['created_at']=  $Groups->created_at;
 $data['files']=$group;
   }
return $data;

}
public static function DownloaduserPDF(Request $request)
{
    if($request->start==null)
    {
        $start =" 2000-11-15";
        $end =Carbon::now();
    
    }  
    else{
        $start=$request->start;
        $end=$request->end;
    }
    $group=[];
     $Groups = Groups::where('id',$request->group_id)->with('files.Version.users','files.booking.user','files.users')->first();
   foreach($Groups->files as $u){
if($u->created_at >=$start &&$u->created_at <=$end &&$u->user_id==$request->user_id){
    $u['operation']="Add";
    $group[]=$u;
}
if(!$u->booking->isempty()){
    foreach($u->booking as $b){
        if($b->created_at >=$start &&$b->created_at <=$end &&$b->user_id==$request->user_id ){
            
            $file['name']=$u->name;
            $file['path']=$u->path;
            $file['created_at']=$b->created_at;
        $file['users']=$b->user;
            $file['operation']="booking";
            $group[]=$file;
  
    }
            }

}
    if(!$u->version->isempty()){
    foreach($u->version as $v){
if($v->created_at >=$start &&$v->created_at <=$end &&$v->user_id==$request->user_id ){
    {
        $file =$v;
        $file['users']=$v->users;
        // return $file;
            $file['operation']="update";
        $group[]=$file;
    }
}
    }

}
$data ['name']=  $Groups->name;
$data ['created_at']=  $Groups->created_at;
 $data['files']=$group;
   }
$pdf = \PDF::loadView('groupReport',compact('data'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("report.$request->ex");


}



// public static function generatekPDF(Request $request)
// {
//     // $token = PersonalAccessToken::findToken($request->bearerToken());
//     $user = User::find($request->id);
//     $userdata = Logging::withTrashed()->whereBetween('created_at', [$request->start, $request->end])
//     ->orWhereBetween('deleted_at', [$request->start, $request->end])
//     ->where('user_id' ,$request->id)
//     ->get();             
// $name= $user->name;
// return ApiResponse::success($userdata , $name);

// }













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

