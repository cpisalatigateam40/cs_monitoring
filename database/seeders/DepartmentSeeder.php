<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'IT',
            'abbrivation' => 'IT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Logistik',
            'abbrivation' => 'LOG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Operasional',
            'abbrivation' => 'OPS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
