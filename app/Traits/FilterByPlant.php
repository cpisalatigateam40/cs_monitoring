<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByPlant
{
    protected static function bootFilterByPlant()
    {
        static::addGlobalScope('plant', function (Builder $builder) {
            $plantId = session('selected_plant', 'all');

            if ($plantId && $plantId !== 'all') {
                $builder->where('plant_id', $plantId);
            }
        });
    }
}
