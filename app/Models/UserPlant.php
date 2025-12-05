<?php

namespace App\Models;

use App\Models\Traits\FilterByPlant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlant extends Model
{
    use HasFactory;
    protected $table = "user_plants";
    protected $primaryKey = "id";
    protected $fillable = [
        'plant_uuid',
        'user_uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }
}
