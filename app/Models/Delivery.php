<?php

namespace App\Models;

use App\Models\Traits\FilterByPlant;
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
        'duration',
        'temperature',
        'time',
    ];

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_uuid', 'uuid');
    }
}
