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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expedition' => 'required|string|max:255',
        ]);

        Expedition::create([
            'expedition' => $validated['expedition'],
        ]);

        return redirect()->back()->with('success', 'Ekspedisi berhasil ditambahkan.');
    }
}
