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
        Schema::create('airline_details', function (Blueprint $table) {
            $table->id();
            $table->string('airline_id');
            $table->string('airline_ticketing_code');
            $table->string('airline_contact_details');
            $table->string('rules_do');
            $table->string('rules_dont');
            $table->string('standard_cancellation_charges');
            $table->string('date_change_charges');
            $table->string('routes_flown_from');
            $table->string('routes_flown_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_details');
    }
};
