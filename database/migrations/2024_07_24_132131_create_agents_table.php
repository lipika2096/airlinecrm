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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('agency_name');
            $table->string('phone');
            $table->text('emergency_phone');
            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('country');
            $table->text('pincode');
            $table->text('owner_name');
            $table->text('gst');
            $table->text('pancard');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
