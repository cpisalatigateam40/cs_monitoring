<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory, HasUuid, FilterByPlant;

    protected $table = "deliveries";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'expedition_uuid',
        'license_plate',
        'destination',
        'start_time',
        'end_time',
    ];


    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_uuid', 'uuid');
    }

    public function temperatures()
    {
        return $this->hasMany(DeliveryTemperature::class, 'delivery_uuid', 'uuid');
    }
}
