<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\GroupFile;
use App\Models\Groups;
use App\Models\Logging;
use App\Models\User;
use App\Models\Version;
use App\Services\ReportService;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Storage;
use App\Models\File;
use View;

class ReportController extends Controller
{
    protected $reportServices;

    public function __construct(ReportService $reportServices)
    {
        $this->reportServices = $reportServices;
    }


public  function generatefilePDF(Request $request)
{
   return $this->reportServices->generatefilePDF($request);

}
public  function generatefile(Request $request)
{
    return $this->reportServices->generatefile($request);

}
public  function Downloadfile(Request $request)
{
    return $this->reportServices->Downloadfile($request);

 
}
public  function DownloadfilePDF(Request $request){
    return $this->reportServices->DownloadfilePDF($request);

}
public  function generateuserPDF(Request $request){
    return $this->reportServices->generateuserPDF($request);

}
public  function DownloaduserPDF(Request $request)
{
    return $this->reportServices->DownloaduserPDF($request);
 
}















}

