<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryTemplateExport;
use App\Exports\WarehouseTemperatureTemplateExport;
use App\Exports\WarehouseTemplateExport;
use App\Imports\DeliveryImport;
use App\Imports\WarehouseImport;
use App\Imports\WarehouseTemperatureImport;
use App\Models\Delivery;
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
            'temperature' => 'required|numeric',
            'time' => 'required|date',
        ]);

        WarehouseTemperature::create([
            'warehouse_uuid' => $request->warehouse_uuid,
            'temperature' => $request->temperature,
            'time' => $request->time,
        ]);

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
            'duration' => 'required|numeric|min:0',
            'temperature' => 'required|numeric|between:-50,50',
            'time' => 'required|date',
        ]);
        Delivery::create([
            'expedition_uuid' => $request->expedition_uuid,
            'license_plate' => $request->license_plate,
            'destination' => $request->destination,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'temperature' => number_format($request->temperature, 1, '.', ''),
            'time' => $request->time,
            'plant_uuid' => Auth::user()->plant_uuid,
        ]);

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
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new WarehouseTemperatureImport, $request->file('excel_file'));
            return back()->with('success', 'Warehouse temperature imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function importDelivery(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DeliveryImport, $request->file('excel_file'));
            return back()->with('success', 'Delivery data imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
