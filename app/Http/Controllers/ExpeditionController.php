<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpeditionController extends Controller
{
    public function index()
    {
        $expeditions = [
            ['name' => 'JNE'],
            ['name' => 'J&T Express'],
            ['name' => 'SiCepat'],
        ];

        return view('master.expedition.index', compact('expeditions'));
    }
}