<?php

namespace App\Imports;

use App\Models\Delivery;
use App\Models\Expedition;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryImport implements ToModel, WithHeadingRow
{
    /**
     * Transform each imported row into a Delivery model.
     */
    public function model(array $row)
    {
        // Find expedition by name (dropdown value from Excel)
        $expedition = Expedition::where('expedition', trim($row['expedition'] ?? ''))->first();

        // Skip row if expedition is not found
        if (!$expedition) {
            return null;
        }

        return new Delivery([
            'expedition_uuid' => $expedition->uuid,
            'license_plate'   => $row['license_plate'] ?? null,
            'destination'     => $row['destination'] ?? null,

            'start_time'      => $this->parseDate($row['start_time'] ?? null),
            'end_time'        => $this->parseDate($row['end_time'] ?? null),
            'duration'        => $row['duration'] ?? null,
            'temperature'     => $row['temperature'] ?? null,
            'time'            => $this->parseDate($row['time'] ?? null),
        ]);
    }

    /**
     * Convert any user Excel date/time format to standard Y-m-d H:i:s
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // CASE 1 — Excel Internal Serial Number
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // continue
            }
        }

        // CASE 2 — Manual Format Matching
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
                // try next
            }
        }

        // CASE 3 — Let Carbon guess format automatically
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null; // final fallback
        }
    }
}
