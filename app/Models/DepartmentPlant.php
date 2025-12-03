<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DepartmentPlant extends Model
{
    use HasFactory, HasUuid;

    protected $table = "department_plants";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'department_uuid',
        'plant_uuid'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_uuid', 'uuid');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_uuid', 'uuid');
    }

    public static function getFilteredPlant(?string $plantUuid = null)
    {
        if ($plantUuid === null) {
            $plantUuid = Auth::user()->department->plant_uuid;
        }

        return self::where('plant_uuid', $plantUuid)
            ->where('visible', true) // langsung pakai kolom
            ->with('department')     // relasi biasa
            ->get();
    }
}
