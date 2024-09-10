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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_no')->nullable();
            $table->string('flight_name')->nullable();
            $table->string('airline_id')->nullable();
            $table->string('origin_id')->nullable();
            $table->string('destination_id')->nullable();
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('arrival_time')->nullable();
             $table->integer('available_seats')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
