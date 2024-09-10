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
        Schema::create('special_fares', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->string('ticket_authorization');
            $table->string('vfr_fares', 10, 2);
            $table->string('to_fares', 10, 2);
            $table->string('sme_fares', 10, 2);
            $table->integer('airline_id');
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_fares');
    }
};
