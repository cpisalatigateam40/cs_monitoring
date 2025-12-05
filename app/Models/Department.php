<?php

namespace App\Models;

use App\Models\Traits\FilterByPlant;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FilterByPlant;

    protected $table = "departments";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'department',
        'abbrivation'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_uuid', 'uuid');
    }
}
