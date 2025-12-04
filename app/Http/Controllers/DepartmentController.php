<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('master.department.index', compact('departments'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        // Simpan data
        Department::create([
            'department' => $request->department,
            'abbrivation' => $request->abbrivation ?? null, // kalau nanti kamu tambahkan
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        $department = Department::where('uuid', $uuid)->firstOrFail();

        $department->update([
            'department' => $request->department,
            'abbrivation' => $request->abbrivation ?? null,
        ]);

        return redirect()->back()->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy($uuid)
    {
        $department = Department::where('uuid', $uuid)->firstOrFail();
        $department->delete(); // soft delete

        return redirect()->back()->with('success', 'Departemen berhasil dihapus.');
    }
}
