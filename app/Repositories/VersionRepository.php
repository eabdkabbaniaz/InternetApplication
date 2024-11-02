<?php

namespace App\Repositories;

use App\Models\Version;

class VersionRepository implements VersionRepositoryInterface
{
    public function Create($data)
    {
        return Version::create($data);
    }

    public function getVersions($data)
    {
        return Version::where('file_id',$data)->get();
    }

}