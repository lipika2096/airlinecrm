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
        Schema::create('delay_codes', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->date('date');
            $table->integer('category_id');
            $table->integer('delay_duration');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_codes');
    }
};
