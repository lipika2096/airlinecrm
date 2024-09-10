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
        Schema::create('agent_provisions_plis', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->string('pli');
            $table->string('prov');
            $table->string('business');
            $table->string('pre_economy');
            $table->string('economy');
            $table->string('valid_from_to');
            $table->string('target');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_provisions_plis');
    }
};
