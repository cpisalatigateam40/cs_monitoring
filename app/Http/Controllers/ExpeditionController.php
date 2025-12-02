<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use Illuminate\Http\Request;

class ExpeditionController extends Controller
{
    public function index()
    {
        $expeditions = Expedition::all();

        return view('master.expedition.index', compact('expeditions'));
    }
}
