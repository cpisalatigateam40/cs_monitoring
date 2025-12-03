<?php

namespace Database\Seeders;

use App\Models\DepartmentPlant;
use App\Models\Plant;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserPlant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = DepartmentPlant::first();

        $user1 = User::create([
            'uuid' => Str::uuid(),
            'username' => 'superadmin',
            'name' => 'superadmin',
            'email' => 'superadmin@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('cpi12345'),
            'department_uuid' => $department->uuid,
            'status' => 1
        ]);

        $user2 = User::create([
            'uuid' => Str::uuid(),
            'username' => 'yosi.pratama',
            'name' => 'Yosi Pratama',
            'email' => 'yosi.pratama@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('cpi12345'),
            'department_uuid' => $department->uuid,
            'status' => 1
        ]);

        $user1->syncRoles('Superadmin');
        $user2->syncRoles('Superadmin');

        $plants = Plant::all();

        foreach ($plants as $plant) {
            UserPlant::create([
                'plant_uuid' => $plant->uuid,
                'user_uuid' => $user1->uuid
            ]);

            UserPlant::create([
                'plant_uuid' => $plant->uuid,
                'user_uuid' => $user2->uuid
            ]);
        }
    }
}
