<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Illuminate\Http\Request;

class WarehouseRecapController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('plant')->get();

        $records = WarehouseTemperature::with('warehouse')->get();

        return view('warehouse.index', compact('warehouses', 'records'));
    }
}
