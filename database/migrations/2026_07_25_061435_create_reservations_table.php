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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('account_type');
            $table->string('sale_type');
            $table->string('sale_status');
            $table->string('booking_ref');
            $table->string('adult');
            $table->string('child');
            $table->string('infant');
            $table->string('date');
            $table->unsignedBigInteger('airline_id');            
            $table->unsignedBigInteger('customer_type');
            $table->string('purchased');
            $table->string('service_charges');            
            $table->string('sold');
            $table->unsignedBigInteger('pnr_id'); 
            $table->unsignedBigInteger('flight_detail_id'); 
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
