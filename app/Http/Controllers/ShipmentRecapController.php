<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class ShipmentRecapController extends Controller
{
    public function index()
    {
        $records = Delivery::with('expedition')->get();
        return view('shipment.index', compact('records'));
    }
}
