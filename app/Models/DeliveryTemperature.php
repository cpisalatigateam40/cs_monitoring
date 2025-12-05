<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTemperature extends Model
{
    use HasFactory, FilterByPlant;

    protected $table = "delivery_temperatures";
    protected $primaryKey = "id";
    protected $fillable = [
        'delivery_uuid',
        'temperature',
        'time',
    ];


    public function temperature()
    {
        return $this->belongsTo(Delivery::class, 'delivery_uuid', 'uuid');
    }
}
