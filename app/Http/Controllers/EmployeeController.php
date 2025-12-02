<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = [
            ['name' => 'Budi Santoso', 'position' => 'Admin Gudang'],
            ['name' => 'Siti Nuraini', 'position' => 'Staff QC'],
            ['name' => 'Agus Triyono', 'position' => 'Checker'],
        ];

        return view('master.employee.index', compact('employees'));
    }
}