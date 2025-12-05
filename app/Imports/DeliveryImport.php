<?php

namespace App\Imports;

use App\Models\DeliveryTemperature;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DeliveryImport implements WithMultipleSheets
{
    protected $delivery_uuid;

    public function __construct($delivery_uuid)
    {
        $this->delivery_uuid = $delivery_uuid;
    }

    public function sheets(): array
    {
        return [
            1 => new class($this->delivery_uuid) implements ToModel, WithHeadingRow {

                protected $delivery_uuid;

                public function __construct($delivery_uuid)
                {
                    $this->delivery_uuid = $delivery_uuid;
                }

                public function model(array $row)
                {
                    // Convert decimal -18,7 → -18.7
                    $temp = $row['temperaturec'] ?? null;
                    if (!empty($temp)) {
                        $temp = str_replace(',', '.', $temp);
                    }

                    return new DeliveryTemperature([
                        'delivery_uuid' => $this->delivery_uuid,
                        'temperature'   => $temp,
                        'time'          => $this->parseDate($row['time'] ?? null),
                    ]);
                }

                private function parseDate($value)
                {
                    if (empty($value)) return null;

                    // Excel numeric date
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
        ];
    }
}
