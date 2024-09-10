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
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->id();
            $table->string('flight_no')->unique();
            $table->string('origin_station');
            $table->string('arrival_station');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('aircraft_type');
            $table->date('valid_till');
            $table->string('frequency');
            $table->integer('airline_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircrafts');
    }
};
