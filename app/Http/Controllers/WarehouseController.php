<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = [
            [
                'name' => 'Gudang Beku A',
                'branch' => 'Cabang A',
            ],
            [
                'name' => 'Gudang Utama',
                'branch' => 'Cabang B',
            ],
        ];

        $branches = ['Cabang A', 'Cabang B', 'Cabang C'];

        return view('master.warehouse.index', compact('warehouses', 'branches'));
    }
}