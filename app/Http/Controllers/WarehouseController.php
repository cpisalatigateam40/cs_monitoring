<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('plant')->get();
        $branches = Plant::all();

        return view('master.warehouse.index', compact('warehouses', 'branches'));
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'warehouse'   => 'required|string|max:255',
            'plant_uuid'  => 'required|exists:plants,uuid',
        ]);

        // Create Warehouse
        Warehouse::create([
            'warehouse'  => $validated['warehouse'],
            'plant_uuid' => $validated['plant_uuid'],
        ]);

        return redirect()->back()->with('success', 'Gudang berhasil ditambahkan.');
    }
}
