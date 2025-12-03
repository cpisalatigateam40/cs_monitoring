<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Expedition;
use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Illuminate\Http\Request;

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
        ]);

        return back()->with('success', 'Data pengiriman berhasil disimpan!');
    }
}
