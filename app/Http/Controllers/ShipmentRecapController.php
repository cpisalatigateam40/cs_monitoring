<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryTemperature;
use App\Models\Expedition;
use Illuminate\Http\Request;

class ShipmentRecapController extends Controller
{
    // public function index(Request $request)
    // {
    //     $expeditions = Expedition::all();

    //     // Query builder
    //     $query = DeliveryTemperature::select(
    //         'delivery_temperatures.*',
    //         'deliveries.license_plate',
    //         'expeditions.expedition as expedition_name'
    //     )
    //     ->leftJoin('deliveries', 'deliveries.uuid', '=', 'delivery_temperatures.delivery_uuid')
    //     ->leftJoin('expeditions', 'expeditions.uuid', '=', 'deliveries.expedition_uuid');


    //     // Filter ekspedisi
    //     if ($request->filled('expedition') && $request->expedition != 'all') {
    //         $query->whereHas('delivery', function ($q) use ($request) {
    //             $q->where('expedition_uuid', $request->expedition);
    //         });
    //     }

    //     // Filter tanggal
    //     if ($request->filled('start_date')) {
    //         $query->whereDate('time', '>=', $request->start_date);
    //     }

    //     if ($request->filled('end_date')) {
    //         $query->whereDate('time', '<=', $request->end_date);
    //     }

    //     // Order & Get
    //     $records = $query->orderBy('time', 'asc')->get();

    //     // dd($records->first());


    //     // Chart
    //     $chartLabels = $records->pluck('time')
    //         ->map(fn($t) => \Carbon\Carbon::parse($t)->format('d-m H:i'));

    //     $chartData = $records->pluck('temperature');

    //     return view('shipment.index', compact(
    //         'records',
    //         'expeditions',
    //         'chartLabels',
    //         'chartData'
    //     ));
    // }

    public function index(Request $request)
    {
        $expeditions = Expedition::all();

        /*
        =================================================
        1️⃣ QUERY GLOBAL (UNTUK STAT & CHART)
        =================================================
        */
        $globalQuery = DeliveryTemperature::select(
            'delivery_temperatures.*',
            'deliveries.license_plate',
            'expeditions.expedition as expedition_name'
        )
        ->leftJoin('deliveries', 'deliveries.uuid', '=', 'delivery_temperatures.delivery_uuid')
        ->leftJoin('expeditions', 'expeditions.uuid', '=', 'deliveries.expedition_uuid');

        // Filter ekspedisi
        if ($request->filled('expedition') && $request->expedition !== 'all') {
            $globalQuery->where('deliveries.expedition_uuid', $request->expedition);
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
        $chartRecords = (clone $globalQuery)
            ->orderBy('time', 'asc')
            ->get();

        $chartLabels = $chartRecords->pluck('time')
            ->map(fn ($t) => \Carbon\Carbon::parse($t)->format('d-m H:i'));

        $chartData = $chartRecords->pluck('temperature');

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

        return view('shipment.index', compact(
            'records',
            'expeditions',
            'chartLabels',
            'chartData',
            'chartRecords'
        ));
    }


}
