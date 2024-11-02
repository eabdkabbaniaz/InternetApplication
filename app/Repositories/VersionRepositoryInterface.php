<?php

namespace App\Repositories;

interface VersionRepositoryInterface
{
    public function Create($data);       
    public function getVersions($data);       
}
