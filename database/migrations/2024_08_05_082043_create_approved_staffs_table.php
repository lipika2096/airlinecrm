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
        Schema::create('approved_staffs', function (Blueprint $table) {
            $table->id();
            $table->integer('airline_id');
            $table->integer('staff_id');
            $table->integer('ticketing');
            $table->integer('marketing');
            $table->integer('sales');
            $table->integer('airport_operations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_staffs');
    }
};
