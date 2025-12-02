<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(['plants', 'department'])->get();

        return view('master.employee.index', compact('employees'));
    }
}
