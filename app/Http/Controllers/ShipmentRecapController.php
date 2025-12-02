<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipmentRecapController extends Controller
{
    public function index()
    {
        return view('shipment.index');
    }
}