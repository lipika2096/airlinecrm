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
        Schema::create('pnrs', function (Blueprint $table) {
            $table->id();
            $table->string('pnr_number');
            $table->string('ticket_no');
            $table->string('title');
            $table->string('pax_first_name');
            $table->string('pax_last_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnrs');
    }
};
