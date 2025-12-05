<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTemperature extends Model
{
    use HasFactory, FilterByPlant;

    protected $table = "warehouse_temperatures";
    protected $primaryKey = "id";
    protected $fillable = [
        'warehouse_uuid',
        'temperature',
        'time'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_uuid', 'uuid');
    }
}
