<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use App\Models\Expedition;
use App\Models\Delivery;
use App\Models\DeliveryTemperature;

class DashboardController extends Controller
{
    public function index()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        $warehouses = Warehouse::with(['temps' => function ($q) use ($sevenDaysAgo) {
            $q->where('time', '>=', $sevenDaysAgo)
            ->orderBy('time', 'asc');
        }])->get();

        $warehouseAnalytics = [];

        foreach ($warehouses as $warehouse) {

            $temps = $warehouse->temps;

            // Total pembacaan
            $totalReadings = $temps->count();

            // Rata-rata suhu
            $avgTemp = $temps->avg('temperature');
            $avgTemp = $avgTemp !== null ? number_format($avgTemp, 1) : '-';

            // Kejadian suhu > -15°C
            $above15 = $temps->filter(fn($t) => $t->temperature > -15);
            $totalAbove15 = $above15->count();

            // Waktu tersering ketika suhu > -15°C (per jam)
            $mostFrequentTime = '-';
            if ($totalAbove15 > 0) {
                $mostFrequentTime = $above15
                    ->groupBy(fn($t) => \Carbon\Carbon::parse($t->time)->format('H:00'))
                    ->sortByDesc(fn($g) => $g->count())
                    ->keys()
                    ->first();
            }

            $warehouseAnalytics[] = [
                'name' => $warehouse->warehouse,
                'totalReadings' => $totalReadings,
                'avgTemp' => $avgTemp,
                'totalAbove15' => $totalAbove15,
                'mostFrequentTime' => $mostFrequentTime,
            ];
        }

        // === REKAP PENGIRIMAN (JOIN VERSION) ===
        $query = DeliveryTemperature::select(
                'delivery_temperatures.*',
                'deliveries.license_plate',
                'expeditions.expedition as expedition_name'
            )
            ->leftJoin('deliveries', 'deliveries.uuid', '=', 'delivery_temperatures.delivery_uuid')
            ->leftJoin('expeditions', 'expeditions.uuid', '=', 'deliveries.expedition_uuid')
            ->where('delivery_temperatures.time', '>=', $sevenDaysAgo) // pakai field TIME
            ->orderBy('delivery_temperatures.time', 'asc')
            ->get();

        // Group berdasarkan ekspedisi+kendaraan
        $grouped = $query->groupBy(function ($row) {
            return ($row->expedition_name ?? '-') . ' - ' . ($row->license_plate ?? '-');
        });

        $shipmentAnalytics = [];

        foreach ($grouped as $name => $temps) {

            // Total pembacaan
            $totalReadings = $temps->count();

            // Rata-rata suhu
            $avgTemp = round($temps->avg('temperature'), 1);

            // Kejadian suhu > -15
            $above15 = $temps->where('temperature', '>', -15);
            $totalAbove15 = $above15->count();

            // Waktu tersering (per jam)
            $mostFrequentTime = $above15
                ->groupBy(function ($t) {
                    return \Carbon\Carbon::parse($t->time)->format('H:00');
                })
                ->sortByDesc(fn($g) => count($g))
                ->keys()
                ->first() ?? '-';

            $shipmentAnalytics[] = [
                'name'             => $name,
                'totalReadings'    => $totalReadings,
                'avgTemp'          => $avgTemp,
                'totalAbove15'     => $totalAbove15,
                'mostFrequentTime' => $mostFrequentTime,
            ];
        }



        return view('dashboard.index', compact('warehouseAnalytics', 'shipmentAnalytics'));
    }
}