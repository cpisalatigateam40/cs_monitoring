<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait SyncsPivotRelations
{
    /**
     * Sync a one-way pivot table relation manually.
     *
     * @param  string  $modelUuid              The UUID of the main model (e.g. Plant).
     * @param  string  $pivotTable             The pivot table name (e.g. department_plants).
     * @param  string  $modelForeignKey        The foreign key to the main model in the pivot (e.g. plant_uuid).
     * @param  string  $relatedForeignKey      The foreign key to the related model in the pivot (e.g. department_uuid).
     * @param  array   $relatedUuids           Array of UUIDs to be inserted.
     * @param  bool    $includeUuid            Whether to auto-generate and include UUID in each row.
     * @return void
     */
    protected function syncPivotRelations(
        string $modelUuid,
        string $pivotTable,
        string $modelForeignKey,
        string $relatedForeignKey,
        array $relatedUuids,
        bool $includeUuid = false
    ): void {
        $existing = DB::table($pivotTable)
            ->where($modelForeignKey, $modelUuid)
            ->get()
            ->keyBy($relatedForeignKey);

        // Set all to invisible first
        DB::table($pivotTable)
            ->where($modelForeignKey, $modelUuid)
            ->update(['visible' => false]);
        foreach ($relatedUuids as $relatedUuid) {
            if (isset($existing[$relatedUuid])) {
                // Already exists — just mark visible
                DB::table($pivotTable)
                    ->where($modelForeignKey, $modelUuid)
                    ->where($relatedForeignKey, $relatedUuid)
                    ->update(['visible' => true, 'updated_at' => now()]);
            } else {
                // New insert
                $data = [
                    $modelForeignKey => $modelUuid,
                    $relatedForeignKey => $relatedUuid,
                    'visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($includeUuid) {
                    $data['uuid'] = (string) Str::uuid();
                }

                DB::table($pivotTable)->insert($data);
            }
        }
    }
}
