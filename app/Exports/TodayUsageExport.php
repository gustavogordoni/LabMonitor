<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Usage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TodayUsageExport
{
    public function download()
    {
        $fileName = 'uso_computadores.xlsx';
        $filePath = storage_path("app/public/{$fileName}");
        
        if (file_exists($filePath)) {
            $spreadsheet = IOFactory::load($filePath);
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['Aluno','Prontuário', 'Curso', 'Data', 'Computador', 'Início', 'Término', 'Duração'], null, 'A1');
        }

        $sheet = $spreadsheet->getActiveSheet();
        $lastRow = $sheet->getHighestRow() + 1;

        $usos = Usage::with(['user', 'computer'])
            ->whereDate('start_time', now()->toDateString())
            ->whereNotNull('end_time')
            ->get()
            ->map(function ($uso) {
                return [
                    $uso->user->name,
                    $uso->user->enrollment,
                    $uso->user->course,
                    $uso->start_time->format('d/m/Y'),
                    $uso->computer->label,
                    $uso->start_time->format('H:i'),
                    $uso->end_time->format('H:i'),
                    $uso->start_time->diffForHumans($uso->end_time, true),
                ];
            })
            ->toArray();

        $sheet->fromArray($usos, null, "A{$lastRow}");
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        
        return Response::download($filePath);
    }
}
