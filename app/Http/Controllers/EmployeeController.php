<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPlant;
use App\Models\Plant;
use App\Models\User;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(['plants', 'department'])->get();
        $plants = Plant::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('master.employee.index', compact('employees', 'plants', 'departments', 'roles'));
    }

    public function store(Request $request)
    {
        // VALIDATION
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username',
            'password'         => 'required|string|min:6',
            'department_uuid'  => 'required|exists:departments,uuid',
            'jabatan'          => 'required|string|max:255',
            'role'             => 'required|string|exists:roles,name',
            'plant_uuid'       => 'required|array',
            'plant_uuid.*'     => 'exists:plants,uuid',
        ]);

        $department = DepartmentPlant::where('department_uuid', $request->department_uuid)
            ->where('plant_uuid', Auth::user()->department->plant_uuid)
            ->first();
        $email = $validated['username'] . '@gmail.com';

        // CREATE USER
        $user = User::create([
            'name'            => $validated['name'],
            'username'        => $validated['username'],
            'email'           => $email,
            'password'        => Hash::make($validated['password']),
            'department_uuid' => $department->uuid,
            'title'           => $validated['jabatan'],
            'status'          => 1,
        ]);

        // ASSIGN ROLE
        $user->assignRole($validated['role']);

        // SAVE MULTIPLE PLANT ACCESS
        foreach ($validated['plant_uuid'] as $plantUuid) {
            UserPlant::create([
                'user_uuid'  => $user->uuid,
                'plant_uuid' => $plantUuid,
            ]);
        }

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
    }
}
