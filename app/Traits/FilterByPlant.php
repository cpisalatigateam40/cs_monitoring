<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait FilterByPlant
{
    protected static function bootFilterByPlant()
    {
        static::addGlobalScope('plant', function (Builder $builder) {
            $plantId = session('selected_plant', 'all');

            if (!Auth::check()) {
                return;
            }

            $userPlantUuids = Auth::user()->plants()->pluck('plant_uuid')->toArray();

            // Check if the model has plant_uuid column
            if (in_array('plant_uuid', $builder->getModel()->getFillable()) || in_array('plant_uuid', $builder->getModel()->getConnection()->getSchemaBuilder()->getColumnListing($builder->getModel()->getTable()))) {
                // direct plant_uuid column
                if ($plantId === 'all') {
                    $builder->whereIn('plant_uuid', $userPlantUuids);
                } else {
                    $builder->where('plant_uuid', $plantId);
                }
            }
            // Check for relation 'warehouse' with plant_uuid
            elseif (method_exists($builder->getModel(), 'warehouse')) {
                $builder->whereHas('warehouse', function ($q) use ($plantId, $userPlantUuids) {
                    if ($plantId === 'all') {
                        $q->whereIn('plant_uuid', $userPlantUuids);
                    } else {
                        $q->where('plant_uuid', $plantId);
                    }
                });
            }
        });
    }
}
