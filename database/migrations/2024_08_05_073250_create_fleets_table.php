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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->integer('airline_id');
            $table->string('name');
            $table->string('iata', 10);
            $table->string('icao', 10);
            $table->integer('number_of_aircraft');
            $table->string('airline');
            $table->string('fleet_type');
            $table->string('configuration_f', 10)->nullable();
            $table->string('configuration_c', 10)->nullable();
            $table->string('configuration_w', 10)->nullable();
            $table->string('configuration_y', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
