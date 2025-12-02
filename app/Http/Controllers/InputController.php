<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function index()
    {
        $warehouses = [
            'Gudang A',
            'Gudang B',
            'Gudang C'
        ];

        $expeditions = [
            'Ekspedisi Nusantara',
            'Trans Express',
            'Logistic Jaya'
        ];

        return view('input.index', compact('warehouses', 'expeditions'));
    }
}