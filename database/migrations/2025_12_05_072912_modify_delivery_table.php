<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->dropColumn('temperature');
            $table->dropColumn('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->decimal('duration', 8, 2)->after('end_time');
            $table->decimal('temperature', 8, 2)->after('duration');
            $table->dateTime('time')->after('temperature');
        });
    }
};
