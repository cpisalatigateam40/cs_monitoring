<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Plant extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $table = "plants";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'plant',
        'abbrivation'
    ];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'plant_uuid', 'uuid');
    }

    public function users()
    {
        return $this->hasMany(UserPlant::class, 'plant_uuid', 'uuid');
    }

    public function realDepartments()
    {
        return $this->hasManyThrough(
            Department::class,
            DepartmentPlant::class,
            'plant_uuid',        // FK on department_plants
            'uuid',              // FK on departments
            'uuid',              // Local on plants
            'department_uuid'    // Local on department_plants
        )->where('department_plants.visible', true);
    }
}
