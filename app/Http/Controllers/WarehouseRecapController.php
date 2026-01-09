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

        $baseQuery = WarehouseTemperature::with('warehouse');

        // Filter by warehouse
        if ($request->filled('warehouse') && $request->warehouse !== 'all') {
            $baseQuery->where('warehouse_uuid', $request->warehouse);
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $baseQuery->whereDate('time', '>=', $request->start_date);
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $baseQuery->whereDate('time', '<=', $request->end_date);
        }

        /* ===============================
        DATA GLOBAL (CHART + STAT)
        =============================== */
        $allRecords = (clone $baseQuery)
            ->orderBy('time', 'asc')
            ->get();

        $chartLabels = $allRecords->pluck('time')
            ->map(fn ($t) => \Carbon\Carbon::parse($t)->format('d-m H:i'));

        $chartData = $allRecords->pluck('temperature');

        /* ===============================
        DATA TABLE (PAGINATION)
        =============================== */
        $records = $baseQuery
            ->orderBy('time', 'desc')
            ->paginate(1)
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
