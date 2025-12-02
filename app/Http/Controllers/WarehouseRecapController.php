<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseRecapController extends Controller
{
    public function index()
    {
        $warehouses = ['Gudang A', 'Gudang B', 'Gudang C'];

        $records = [
            [
                'timestamp' => now()->subHours(1),
                'warehouse_name' => 'Gudang A',
                'temperature' => -20.5
            ],
            [
                'timestamp' => now()->subHours(3),
                'warehouse_name' => 'Gudang B',
                'temperature' => -14.2
            ],
            [
                'timestamp' => now()->subHours(5),
                'warehouse_name' => 'Gudang C',
                'temperature' => -9.8
            ],
        ];

        return view('warehouse.index', compact('warehouses', 'records'));
    }
}