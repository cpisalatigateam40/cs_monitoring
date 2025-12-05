<?php

namespace App\Imports;

use App\Models\WarehouseTemperature;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WarehouseTemperatureImport implements WithMultipleSheets
{
    protected $warehouse_uuid;

    public function __construct($warehouse_uuid)
    {
        $this->warehouse_uuid = $warehouse_uuid;
    }

    /**
     * Tentukan hanya sheet ke-2 yang dipakai
     */
    public function sheets(): array
    {
        return [
            1 => new class($this->warehouse_uuid) implements ToModel, WithHeadingRow {

                protected $warehouse_uuid;

                public function __construct($warehouse_uuid)
                {
                    $this->warehouse_uuid = $warehouse_uuid;
                }

                public function model(array $row)
                {
                    // Convert -18,7 → -18.7
                    $temp = $row['temperaturec'] ?? null;
                    if (!empty($temp)) {
                        $temp = str_replace(',', '.', $temp);
                    }

                    return new WarehouseTemperature([
                        'warehouse_uuid' => $this->warehouse_uuid,
                        'temperature' => $temp,
                        'time' => $this->parseDate($row['time'] ?? null),
                    ]);
                }

                /**
                 * Parse Date / Time dari Thermologger
                 */
                private function parseDate($value)
                {
                    if (empty($value)) return null;

                    // Excel numeric date/time
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
                        'H:i'
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
        ];
    }
}
