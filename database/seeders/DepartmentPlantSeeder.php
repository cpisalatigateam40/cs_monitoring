<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentPlant;
use App\Models\Plant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentPlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plant = Plant::first();
        $department = Department::first();

        DepartmentPlant::create([
            'uuid' => Str::uuid(),
            'department_uuid' => $department->uuid,
            'plant_uuid' => $plant->uuid,
            'visible' => '1'
        ]);
    }
}
