<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        $branches = [
            ['name' => 'Jakarta'],
            ['name' => 'Bandung'],
            ['name' => 'Surabaya'],
        ];

        return view('master.plant.index', compact('branches'));
    }
}