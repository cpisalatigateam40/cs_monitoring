<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory, HasUuid, FilterByPlant;

    protected $table = "expeditions";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'expedition'
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'expedition_uuid', 'uuid');
    }
}
