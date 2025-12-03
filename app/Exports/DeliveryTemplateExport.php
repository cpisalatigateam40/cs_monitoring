<?php

namespace App\Exports;

use App\Models\Expedition;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DeliveryTemplateExport implements WithHeadings, WithEvents
{
    public function headings(): array
    {
        return [
            'expedition',
            'license_plate',
            'destination',
            'start_time',
            'end_time',
            'duration',
            'temperature',
            'time',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Get expeditions
                $expeditions = Expedition::pluck('expedition')->toArray();

                // Convert to dropdown list format
                $list = '"' . implode(',', $expeditions) . '"';

                // Apply dropdown (column A)
                for ($row = 2; $row <= 500; $row++) {
                    $validation = $sheet->getCell("A{$row}")->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowDropDown(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setFormula1($list);
                }
            }
        ];
    }
}
