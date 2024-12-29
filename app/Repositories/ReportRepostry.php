<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Logging;


class ReportRepostry 
{
    public function create($data)
    {
        return Logging::create($data);
    }


   }