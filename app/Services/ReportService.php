<?php

namespace App\Services;
// use Carbon;
use App\Http\Responses\ResponseService;
use App\Models\Groups;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class ReportService
{

    public  function generatefilePDF( $request)
    {
        
        if($request->start==null)
    {
        $start =" 2000-11-15";
        $end =Carbon::now();
    }  else{
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

    
    public  function generatefile( $request)
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
public  function Downloadfile( $request)
{
    $data = $this->generatefile($request);

 $pdf = \PDF::loadView('groupReport',compact('data'));   
 $filePath = 'public/user_'. time() . '.' . $request->ex;
  $ww= Storage::put($filePath, $pdf->output());
 return $pdf->download("walaa1.$request->ex");
 
}
public  function DownloadfilePDF( $request)
{
  $data = $this->generatefilePDF($request);

$pdf = \PDF::loadView('groupReport',compact('data'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("walaa1.$request->ex");

}
public  function generateuserPDF( $request)
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
public  function DownloaduserPDF( $request)
{
  $data =$this->generateuserPDF($request);
$pdf = \PDF::loadView('groupReport',compact('data'));   
$filePath = 'public/user_'. time() . '.' . $request->ex;
 $ww= Storage::put($filePath, $pdf->output());
return $pdf->download("report.$request->ex");


}



}
