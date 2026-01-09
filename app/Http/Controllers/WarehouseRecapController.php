<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use Illuminate\Http\Request;

class WarehouseRecapController extends Controller
{
    // public function index(Request $request)
    // {
    //     $warehouses = Warehouse::with('plant')->get();

    //     $query = WarehouseTemperature::with('warehouse');

    //     // Filter by warehouse
    //     if ($request->filled('warehouse') && $request->warehouse != 'all') {
    //         $query->where('warehouse_uuid', $request->warehouse);
    //     }

    //     // Filter by start date
    //     if ($request->filled('start_date')) {
    //         $query->whereDate('time', '>=', $request->start_date);
    //     }

    //     // Filter by end date
    //     if ($request->filled('end_date')) {
    //         $query->whereDate('time', '<=', $request->end_date);
    //     }

    //     $records = $query->get();

    //     // === Data untuk Chart ===
    //     $chartLabels = $records->pluck('time')->map(function ($t) {
    //         return \Carbon\Carbon::parse($t)->format('d-m H:i');
    //     });

    //     $chartData = $records->pluck('temperature');

    //     return view('warehouse.index', compact('warehouses', 'records', 'chartLabels', 'chartData'));
    // }

    public function index(Request $request)
{
    $warehouses = Warehouse::with('plant')->get();

    /*
    =================================================
    1️⃣ QUERY GLOBAL (UNTUK TOTAL, STAT, CHART)
    =================================================
    */
    $globalQuery = WarehouseTemperature::with('warehouse');

    // Filter warehouse
    if ($request->filled('warehouse') && $request->warehouse !== 'all') {
        $globalQuery->where('warehouse_uuid', $request->warehouse);
    }

    // Filter tanggal
    if ($request->filled('start_date')) {
        $globalQuery->whereDate('time', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $globalQuery->whereDate('time', '<=', $request->end_date);
    }

    /*
    ===============================
    DATA GLOBAL (STAT + CHART)
    ===============================
    */
    $allRecords = (clone $globalQuery)
        ->orderBy('time', 'asc')
        ->get();

    $chartLabels = $allRecords->pluck('time')
        ->map(fn ($t) => \Carbon\Carbon::parse($t)->format('d-m H:i'));

    $chartData = $allRecords->pluck('temperature');

    /*
    =================================================
    2️⃣ QUERY TABLE (BOLEH FILTER SUHU)
    =================================================
    */
    $tableQuery = clone $globalQuery;

    if ($request->filled('temp_range')) {
        match ($request->temp_range) {
            'lt_-18'  => $tableQuery->where('temperature', '<', -18),
            '-18_-15' => $tableQuery->whereBetween('temperature', [-18, -15]),
            '-15_-10' => $tableQuery->whereBetween('temperature', [-15, -10]),
            '-10_0'   => $tableQuery->whereBetween('temperature', [-10, 0]),
            'gte_0'   => $tableQuery->where('temperature', '>=', 0),
            default   => null,
        };
    }

    $records = $tableQuery
        ->orderBy('time', 'desc')
        ->paginate(20)
        ->withQueryString();

    return view('warehouse.index', compact(
        'warehouses',
        'records',
        'allRecords',
        'chartLabels',
        'chartData'
    ));
}

}
