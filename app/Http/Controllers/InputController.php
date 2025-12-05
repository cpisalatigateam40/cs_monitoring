<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryTemplateExport;
use App\Exports\WarehouseTemperatureTemplateExport;
use App\Exports\WarehouseTemplateExport;
use App\Imports\DeliveryImport;
use App\Imports\WarehouseImport;
use App\Imports\WarehouseTemperatureImport;
use App\Models\Delivery;
use App\Models\DeliveryTemperature;
use App\Models\Expedition;
use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();

        $expeditions = Expedition::all();

        return view('input.index', compact('warehouses', 'expeditions'));
    }

    public function warehouseStore(Request $request)
    {
        $request->validate([
            'warehouse_uuid' => 'required',
            'temperature.*' => 'required|numeric',
            'time.*' => 'required|date',
        ]);

        foreach ($request->temperature as $i => $temp) {
            WarehouseTemperature::create([
                'warehouse_uuid' => $request->warehouse_uuid,
                'temperature' => $temp,
                'time' => $request->time[$i],
            ]);
        }

        return back()->with('success', 'Data suhu berhasil disimpan!');
    }

    public function deliveryStore(Request $request)
    {
        $request->validate([
            'expedition_uuid' => 'required',
            'license_plate' => 'required',
            'destination' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',

            // Dynamic fields
            'temperature.*' => 'required|numeric|between:-50,50',
            'time.*' => 'required|date',
        ]);

        // 1️⃣ Save main delivery data (1 row only)
        $delivery = Delivery::create([
            'expedition_uuid' => $request->expedition_uuid,
            'license_plate' => $request->license_plate,
            'destination' => $request->destination,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'plant_uuid' => Auth::user()->plant_uuid,
        ]);

        // 2️⃣ Save temperature logs (multiple rows)
        foreach ($request->temperature as $i => $temp) {
            DeliveryTemperature::create([
                'delivery_uuid' => $delivery->uuid,
                'temperature' => number_format($temp, 1, '.', ''),
                'time' => $request->time[$i],
            ]);
        }

        return back()->with('success', 'Data pengiriman berhasil disimpan!');
    }

    public function templateWarehouse()
    {
        return Excel::download(new WarehouseTemperatureTemplateExport, 'warehouse_temperature_template.xlsx');
    }

    public function templateDelivery()
    {
        return Excel::download(new DeliveryTemplateExport, 'delivery_temperature_template.xlsx');
    }


    // IMPORT
    public function importWarehouse(Request $request)
    {
        // Validasi input
        $request->validate([
            'excel_file' => 'required|file|max:20480',
            'warehouse_uuid' => 'required|string|exists:warehouses,uuid'
        ]);

        $file = $request->file('excel_file');

        // Ekstensi yang diizinkan
        $allowed = ['xls', 'xlsx', 'xlsm', 'ods', 'csv'];

        if (! in_array(strtolower($file->getClientOriginalExtension()), $allowed)) {
            return back()->with('error', 'Format file tidak didukung.');
        }

        /**
         * THERMOLOGGER FIX:
         * File berekstensi .xls tetapi format sebenarnya .xlsx (zip file)
         * Jika 4 byte pertama = PK\x03\x04 maka file itu sebenarnya XLSX
         */
        $firstBytes = file_get_contents($file->getRealPath(), false, null, 0, 4);

        if ($firstBytes === "PK\x03\x04") {

            // Buat file sementara dengan ekstensi .xlsx agar bisa dibaca Laravel-Excel
            $tmpPath = $file->getRealPath();
            $convertedPath = $tmpPath . '.xlsx';

            copy($tmpPath, $convertedPath);

            $pathToImport = $convertedPath;
        } else {
            // Jika file XLS asli
            $pathToImport = $file->getRealPath();
        }

        try {

            // import dengan warehouse_uuid
            Excel::import(
                new WarehouseTemperatureImport($request->warehouse_uuid),
                $pathToImport
            );

            return back()->with('success', 'Warehouse temperature imported successfully.');
        } catch (\Exception $e) {

            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function importDelivery(Request $request)
    {
        $request->validate([
            'excel_file'     => 'required|file|max:20480',
            'expedition_uuid' => 'required|string|exists:expeditions,uuid',
            'license_plate'   => 'required|string',
            'destination'     => 'required|string',
            'start_time'      => 'required|date',
            'end_time'        => 'required|date',
        ]);

        $file = $request->file('excel_file');

        $allowed = ['xls', 'xlsx', 'xlsm', 'ods', 'csv'];

        if (! in_array(strtolower($file->getClientOriginalExtension()), $allowed)) {
            return back()->with('error', 'Format file tidak didukung.');
        }

        // Detect thermologger .xls disguised as .xlsx
        $firstBytes = file_get_contents($file->getRealPath(), false, null, 0, 4);

        if ($firstBytes === "PK\x03\x04") {
            $tmpPath = $file->getRealPath();
            $convertedPath = $tmpPath . '.xlsx';
            copy($tmpPath, $convertedPath);
            $pathToImport = $convertedPath;
        } else {
            $pathToImport = $file->getRealPath();
        }

        try {
            // 1️⃣ SIMPAN DELIVERY DULU
            $delivery = Delivery::create([
                'expedition_uuid' => $request->expedition_uuid,
                'license_plate'   => $request->license_plate,
                'destination'     => $request->destination,
                'start_time'      => $request->start_time,
                'end_time'        => $request->end_time,
            ]);

            // 2️⃣ LALU IMPORT TEMPERATURE
            Excel::import(
                new DeliveryImport($delivery->uuid),
                $pathToImport
            );

            return back()->with('success', 'Delivery imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
