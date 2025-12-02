<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        $branches = Plant::all();

        return view('master.plant.index', compact('branches'));
    }
}
