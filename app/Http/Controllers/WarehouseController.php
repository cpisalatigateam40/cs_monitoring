<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('plant')->get();

        return view('master.warehouse.index', compact('warehouses', 'branches'));
    }
}
