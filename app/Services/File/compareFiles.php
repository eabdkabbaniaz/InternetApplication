<?php

namespace App\Services\File;

use App\Http\Requests\FileStoreRequest;
use App\Http\Responses\ResponseService;
use App\Models\Version;
use App\Repositories\FileRepositoryInterface;   // استخدام الواجهة
use App\Repositories\VersionRepository;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class compareFiles
{
    function extractText($filePath) {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        switch (strtolower($extension)) {
            case 'docx':
                return $this->extractTextFromWord($filePath);
            case 'xlsx':
                return $this->extractTextFromExcel($filePath);
            default:
                throw new Exception("Unsupported file type: $extension");
        }
    }

    function extractTextFromWord($filePath) {
        $phpWord = WordIOFactory::load($filePath);
        $text = '';
        $lineNumber = 1;

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= "[$lineNumber] " . $element->getText() . "\n";
                    $lineNumber++;
                }
            }
        }

        return $text;
    }

    function extractTextFromExcel($filePath) {
        $spreadsheet = SpreadsheetIOFactory::load($filePath);
        $text = '';

        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
            $rowIndex = $row->getRowIndex();
            foreach ($row->getCellIterator() as $cell) {
                $cellAddress = $cell->getColumn() . $rowIndex;
                $cellValue = $cell->getValue();
                $text .= "[$cellAddress] " . $cellValue . "\n";
            }
        }

        return $text;
    }

    function compareFiles() {
        $oldContent = $this->extractText("D:\InternetApp\InternetApp\public\New Microsoft Word Document (4).docx");
        $newContent = $this->extractText("D:\InternetApp\InternetApp\public\New Microsoft Word Document (5).docx");
        $diffOptions = [
            'context' => 0, 
            'ignoreLineEnding' => true,
            'ignoreWhitespace' => true,
        ];

        $diff = DiffHelper::calculate($oldContent, $newContent, 'Unified', $diffOptions);
        $lines = explode("\n", $diff);
        array_shift($lines); 

        $addedCount = 0;
        $removedCount = 0;
        $resultLines = [];

        foreach ($lines as $line) {
            if (strpos($line, '+') === 0) {
                $addedCount++;
                $content = substr($line, 1); 
                if (trim($content) === '') {
                    $resultLines[] = "A blank line has been added:";
                } else {
                    $resultLines[] = "Added to this line: $content";
                }
            } elseif (strpos($line, '-') === 0) {
                $removedCount++;
                $content = substr($line, 1); 
                if (trim($content) === '') {
                    $resultLines[] = "A blank line has been added:";
                } else {
                    $resultLines[] = "This line has been deleted: $content";
                }
            }
        }

        // إضافة عدد الأسطر الزائدة والمحذوفة في النهاية
        if ($addedCount > 0) {
            $resultLines[] = "Number of lines in addition: $addedCount)";
        }
        if ($removedCount > 0) {
            $resultLines[] = "(Number of deleted lines: $removedCount)";
        }

        $result = implode("\n", $resultLines);
        return $result;
    } 
}