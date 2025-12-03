<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $table = "departments";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'department',
        'abbrivation'
    ];

    public function departments()
    {
        return $this->hasMany(DepartmentPlant::class, 'department_uuid', 'uuid');
    }
}
