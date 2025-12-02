<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory, HasUuid;

    protected $table = "expeditions";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'expedition'
    ];
}
