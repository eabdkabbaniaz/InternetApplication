<?php

namespace App\Jobs;

use App\Repositories\VersionRepository;
use App\Services\File\compareFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $path =[];
    public $file;
    protected $compareFiles;
    protected $versionRepository;
    public function __construct($path ,$file  ,VersionRepository $versionRepository ,compareFiles $compareFiles )
    {
        $this->compareFiles= $compareFiles;
        $this->versionRepository= $versionRepository;
        $this->path=$path;
        $this->file=$file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->path;
        $file = $this->file;

    $version=[];
        $diff=$this->compareFiles->compareFiles(public_path($path[0]),public_path($path[1])  );
        $version['name']= $file->name;
        $version['file_id']=$file->id;
        $version['path']=  $file['path'];
        $version['diff']=  $diff;
        $tete= $this->versionRepository->Create($version);
    }
}
