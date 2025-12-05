<?php

namespace App\Models;

use App\Models\Traits\FilterByPlant;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Plant extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FilterByPlant;

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
}
