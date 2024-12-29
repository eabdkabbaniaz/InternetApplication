<?php

namespace App\Services;
// use Carbon;
use App\Http\Responses\ResponseService;
use App\Models\Groups;
use App\Models\Logging;
use App\Repositories\FileRepository;
use App\Repositories\GroupRepository;
use App\Repositories\LogRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class ReportService
{
    protected $logRepository;
    protected $fileRepository;
    protected $groupRepository;

    public function __construct(LogRepository $logRepository, FileRepository $fileRepository, GroupRepository $groupRepository)
    {
        $this->logRepository = $logRepository;
        $this->fileRepository = $fileRepository;
        $this->groupRepository = $groupRepository;

    }

    public function generatefilePDF($request)
    {
        $group = $this->groupRepository->findGroup($request->group_id);
        $file = $this->fileRepository->findFileByGroupId($request->group_id);
        $data = $this->logRepository->getGroupLog($request, $file);

        return [$group, $data];
    }


    public function generatefile($request)
    {
        $file = $this->fileRepository->findFileById($request->file_id);
        $data = $this->logRepository->getfileLog($request);
        return [$file, $data];
    }
    public function Downloadfile($request)
    {
        $data = $this->generatefile($request);
        $pdf = \PDF::loadView('groupReport', compact('data'));
        $filePath = 'public/user_' . time() . '.' . $request->ex;
        $ww = Storage::put($filePath, $pdf->output());
        return $pdf->download("walaa1.$request->ex");

    }
    public function DownloadfilePDF($request)
    {
        $data = $this->generatefilePDF($request);

        $pdf = \PDF::loadView('groupReport', compact('data'));
        $filePath = 'public/user_' . time() . '.' . $request->ex;
        $ww = Storage::put($filePath, $pdf->output());
        return $pdf->download("walaa1.$request->ex");

    }
    public function generateuserPDF($request)
    {

        $group = $this->groupRepository->findGroup($request->group_id);
        $file = $this->fileRepository->findFileByGroupId($request->group_id);
        $data = $this->logRepository->getUserLog($request, $file);
        return [$group, $data];


    }

    public function DownloaduserPDF($request)
    {
        $data = $this->generateuserPDF($request);
        $pdf = \PDF::loadView('groupReport', compact('data'));
        $filePath = 'public/user_' . time() . '.' . $request->ex;
        $ww = Storage::put($filePath, $pdf->output());
        return $pdf->download("report.$request->ex");

    }



}
