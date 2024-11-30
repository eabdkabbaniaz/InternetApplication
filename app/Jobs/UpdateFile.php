<?php

namespace App\Jobs;

use App\Repositories\VersionRepository;
use App\Services\File\compareFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpdateFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $path =[];
    public $file;
    public $user_id;
    protected $compareFiles;
    protected $versionRepository;
    public function __construct($path,$user_id ,$file  ,VersionRepository $versionRepository ,compareFiles $compareFiles )
    {
        $this->compareFiles= $compareFiles;
        $this->versionRepository= $versionRepository;
        $this->path=$path;
        $this->user_id=$user_id;
        $this->file=$file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->path;
        $file = $this->file;
        $user_id = $this->user_id;
// $user =Auth::user()->id;
// echo 1;
// echo $user;
    $version=[];
         $diff=$this->compareFiles->compareFiles(public_path($path[0]),public_path($path[1])  );
        $version['name']= $file->name;
        $version['file_id']=$file->id;
        $version['path']=  $file['path'];
        $version['diff']=  $diff;
        $version['user_id']=  $user_id;
        $tete= $this->versionRepository->Create($version);
    }
}
