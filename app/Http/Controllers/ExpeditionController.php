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

    public function update(Request $request, $uuid)
    {
        $validated = $request->validate([
            'expedition' => 'required|string|max:255|unique:expeditions,expedition,' . $uuid . ',uuid',
        ]);

        $expedition = Expedition::where('uuid', $uuid)->firstOrFail();
        $expedition->update($validated);

        return redirect()->back()->with('success', 'Ekspedisi berhasil diperbarui.');
    }

    public function destroy($uuid)
    {
        $expedition = Expedition::where('uuid', $uuid)->firstOrFail();
        $expedition->delete();

        return redirect()->back()->with('success', 'Ekspedisi berhasil dihapus.');
    }
}
