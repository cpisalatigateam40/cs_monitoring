<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory, HasUuid, FilterByPlant;

    protected $table = "warehouses";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'warehouse',
        'plant_uuid'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }

    public function temps()
    {
        return $this->hasMany(WarehouseTemperature::class, 'warehouse_uuid', 'uuid');
    }
}
