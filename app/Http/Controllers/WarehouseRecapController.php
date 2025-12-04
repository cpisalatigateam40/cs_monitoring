<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Illuminate\Http\Request;

class WarehouseRecapController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::with('plant')->get();

        $query = WarehouseTemperature::with('warehouse');

        // Filter by warehouse
        if ($request->filled('warehouse') && $request->warehouse != 'all') {
            $query->where('warehouse_uuid', $request->warehouse);
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $query->whereDate('time', '>=', $request->start_date);
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $query->whereDate('time', '<=', $request->end_date);
        }

        $records = $query->get();

        return view('warehouse.index', compact('warehouses', 'records'));
    }
}
