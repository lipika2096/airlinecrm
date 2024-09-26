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
        Schema::create('agent_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->string('tr_type');
            $table->string('credit');
            $table->string('debit');
            $table->date('tr_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_accounts');
    }
};
