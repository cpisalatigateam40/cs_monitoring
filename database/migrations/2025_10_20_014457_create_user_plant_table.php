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
        Schema::create('user_plants', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->uuid('plant_uuid');
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('plant_uuid')->references('uuid')->on('plants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plants');
    }
};
