<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Salatiga',
            'abbrivation' => 'SLT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Sragen',
            'abbrivation' => 'SRG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Banyumas',
            'abbrivation' => 'BMS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Pemalang',
            'abbrivation' => 'PML',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Kebumen',
            'abbrivation' => 'KBM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Banjarbaru',
            'abbrivation' => 'BJB',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Plant::create([
            'uuid' => Str::uuid(),
            'plant' => 'Balikpapan',
            'abbrivation' => 'BKN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
