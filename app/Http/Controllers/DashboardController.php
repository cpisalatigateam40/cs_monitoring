<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warehouse;
use App\Models\WarehouseTemperature;
use App\Models\Expedition;
use App\Models\Delivery;

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

        // === REKAP PENGIRIMAN / EKSPEDISI ===

        $expeditions = Expedition::with(['deliveries' => function ($q) use ($sevenDaysAgo) {
            $q->where('created_at', '>=', $sevenDaysAgo)
            ->orderBy('created_at', 'asc');
        }])->get();


        $shipmentAnalytics = [];

        foreach ($expeditions as $expedition) {

            $deliveries = $expedition->deliveries;

            // Total pembacaan
            $totalReadings = $deliveries->count();

            // Rata-rata suhu
            $avgTemp = $deliveries->avg('temperature');
            $avgTemp = $avgTemp !== null ? number_format($avgTemp, 1) : '-';

            // Kejadian suhu > -15°C
            $above15 = $deliveries->filter(fn($d) => $d->temperature > -15);
            $totalAbove15 = $above15->count();

            // Jam tersering suhu > -15°C
            $mostFrequentTime = '-';
            if ($totalAbove15 > 0) {
                $mostFrequentTime = $above15
                    ->groupBy(fn($t) => \Carbon\Carbon::parse($t->time)->format('H:00'))
                    ->sortByDesc(fn($g) => $g->count())
                    ->keys()
                    ->first();
            }

            // PERBAIKAN DI SINI --- gunakan `$expedition->expedition`
            // serta hindari error ketika deliveries kosong
            $shipmentAnalytics[] = [
                'name' => ($expedition->expedition ?? '-') . 
                        ' - ' . 
                        ($deliveries->first()->license_plate ?? '-'),
                'totalReadings' => $totalReadings,
                'avgTemp' => $avgTemp,
                'totalAbove15' => $totalAbove15,
                'mostFrequentTime' => $mostFrequentTime,
            ];
        }


        return view('dashboard.index', compact('warehouseAnalytics', 'shipmentAnalytics'));
    }
}