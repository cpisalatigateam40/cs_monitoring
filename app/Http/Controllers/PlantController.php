<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(Request $request, $uuid)
    {
        $validated = $request->validate([
            'plant' => 'required|string|max:255|unique:plants,plant,' . $uuid . ',uuid',
            'abbrivation' => 'required|string|max:10|unique:plants,abbrivation,' . $uuid . ',uuid',
        ]);

        $plant = Plant::where('uuid', $uuid)->firstOrFail();
        $plant->update($validated);

        return redirect()->back()->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy($uuid)
    {
        $plant = Plant::where('uuid', $uuid)->firstOrFail();
        $plant->delete();

        return redirect()->back()->with('success', 'Cabang berhasil dihapus.');
    }

    public function setPlant(Request $request)
    {
        $request->validate([
            'plant_id' => 'required'
        ]);

        $userPlantUuids = Auth::user()->plants()->pluck('plant_uuid')->toArray();

        // if not "all", check authorization
        if ($request->plant_id !== 'all' && !in_array($request->plant_id, $userPlantUuids)) {
            abort(403, 'Unauthorized plant selection.');
        }

        session(['selected_plant' => $request->plant_id]);

        return response()->json(['success' => true]);
    }
}
