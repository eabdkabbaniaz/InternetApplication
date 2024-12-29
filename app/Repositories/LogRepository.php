<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Logging;


class LogRepository 
{
    public function create($data)
    {
        return Logging::create($data);
    }
    public function getUserLog($request , $file)
    {
       return $data = Logging::where([['created_at','>=',$request['start']],['created_at','<=',$request['end']],['user_id',$request['user_id']]])->whereIn('file_id',$file)->with('file','user')->get();   
    }
    public function getGroupLog($request , $file)
    {
       return  $data = Logging::where([['created_at','>=',$request->start],['created_at','<=',$request->end]])->whereIn('file_id',$file)->with('file','user')->get();
    }
    public function getfileLog($request)
    {
     return   $data = Logging::where([['created_at','>=',$request->start],['created_at','<=',$request->end],['file_id',$request->file_id]])->with('file','user')->get();
    }


   }