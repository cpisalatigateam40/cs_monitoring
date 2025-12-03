<?php

namespace App\Imports;

use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WarehouseTemperatureImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $warehouse = Warehouse::where('warehouse', trim($row['warehouse'] ?? ''))->first();

        if (!$warehouse) {
            return null;
        }

        return new WarehouseTemperature([
            'warehouse_uuid' => $warehouse->uuid,
            'temperature'    => $row['temperature'] ?? null,
            'time'           => $this->parseDate($row['time'] ?? null),
        ]);
    }

    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
            }
        }

        $formats = [
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'd-m-Y H:i',
            'd/m/Y H:i',
            'm/d/Y H:i',
            'd-m-Y',
            'd/m/Y',
            'Y-m-d',
            'H:i',
        ];

        foreach ($formats as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, trim($value))
                    ->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
            }
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
