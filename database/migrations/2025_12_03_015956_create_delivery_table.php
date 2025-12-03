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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('expedition_uuid');
            $table->string('license_plate');
            $table->string('destination');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('duration', 8, 2);
            $table->decimal('temperature', 8, 2);
            $table->dateTime('time');
            $table->timestamps();

            $table->foreign('expedition_uuid')->references('uuid')->on('expeditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
