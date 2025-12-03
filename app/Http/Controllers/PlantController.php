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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant'        => 'required|string|max:255',
            'abbrivation'  => 'required|string|max:50',
        ]);

        Plant::create([
            'plant'        => $validated['plant'],
            'abbrivation'  => $validated['abbrivation'],
        ]);

        return redirect()->back()->with('success', 'Cabang berhasil ditambahkan.');
    }
}
