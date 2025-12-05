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
        $userPlants = Plant::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('master.employee.index', compact('employees', 'userPlants', 'departments', 'roles'));
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
        // dd($request);
        $email = $validated['username'] . '@gmail.com';

        $user = User::create([
            'name'            => $validated['name'],
            'username'        => $validated['username'],
            'email'           => $email,
            'password'        => Hash::make($validated['password']),
            'department_uuid' => $validated['department_uuid'],
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

    public function update(Request $request, $uuid)
    {
        // VALIDATION
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username,' . $uuid . ',uuid',
            'department_uuid'  => 'required|exists:departments,uuid',
            'jabatan'          => 'required|string|max:255',
            'plant_uuid'       => 'required|array',
            'plant_uuid.*'     => 'exists:plants,uuid',
        ]);

        // FIND USER
        $user = User::where('uuid', $uuid)->firstOrFail();

        // UPDATE MAIN USER DATA
        $user->update([
            'name'            => $validated['name'],
            'username'        => $validated['username'],
            'department_uuid' => $validated['department_uuid'],
            'title'           => $validated['jabatan'],
        ]);

        // UPDATE PLANTS (DELETE OLD → INSERT NEW)
        UserPlant::where('user_uuid', $user->uuid)->delete();

        foreach ($validated['plant_uuid'] as $plantUuid) {
            UserPlant::create([
                'user_uuid'  => $user->uuid,
                'plant_uuid' => $plantUuid,
            ]);
        }

        return redirect()->back()->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function destroy($uuid)
    {
        $department = User::where('uuid', $uuid)->firstOrFail();
        $users = UserPlant::where('user_uuid', $uuid)->get();
        foreach ($users as $user) {
            $user->delete();
        }
        $department->delete(); // soft delete

        return redirect()->back()->with('success', 'Departemen berhasil dihapus.');
    }
}
