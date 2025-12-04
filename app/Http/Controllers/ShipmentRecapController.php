<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Expedition;
use Illuminate\Http\Request;

class ShipmentRecapController extends Controller
{
    public function index(Request $request)
    {
        $expeditions = Expedition::all();

        $query = Delivery::with('expedition');

        // Filter by expedition
        if ($request->filled('expedition') && $request->expedition != 'all') {
            $query->where('expedition_uuid', $request->expedition);
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $records = $query->get();

        return view('shipment.index', compact('records', 'expeditions'));
    }
}
