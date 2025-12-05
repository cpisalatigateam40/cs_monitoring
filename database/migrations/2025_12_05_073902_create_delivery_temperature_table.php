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
        Schema::create('delivery_temperatures', function (Blueprint $table) {
            $table->id();
            $table->uuid('delivery_uuid');
            $table->decimal('temperature', 8, 2);
            $table->dateTime('time');
            $table->timestamps();

            $table->foreign('delivery_uuid')->references('uuid')->on('deliveries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_temperatures');
    }
};
