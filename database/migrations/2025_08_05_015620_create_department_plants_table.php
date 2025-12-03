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
        Schema::create('department_plants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('department_uuid');
            $table->uuid('plant_uuid');
            $table->boolean('visible')->default(true);
            $table->timestamps();

            $table->foreign('department_uuid')->on('departments')->references('uuid');
            $table->foreign('plant_uuid')->on('plants')->references('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deparment_plants');
    }
};
