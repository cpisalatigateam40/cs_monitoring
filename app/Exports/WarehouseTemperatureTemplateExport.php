<?php

namespace App\Exports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class WarehouseTemperatureTemplateExport implements WithHeadings, WithEvents
{
    public function headings(): array
    {
        return [
            'warehouse',
            'temperature',
            'time',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Get all warehouses
                $warehouses = Warehouse::pluck('warehouse')->toArray();

                // Convert to comma-separated list for dropdown
                $list = '"' . implode(',', $warehouses) . '"';

                // Apply dropdown to first 500 rows (adjust as needed)
                for ($row = 2; $row <= 500; $row++) {
                    $validation = $sheet->getCell("A{$row}")->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1($list);
                }
            }
        ];
    }
}
