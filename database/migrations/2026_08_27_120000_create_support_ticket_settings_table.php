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
        Schema::create('support_ticket_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('auto_close_hours')->default(24)->comment('Number of hours after which tickets should be auto-closed');
            $table->boolean('auto_close_enabled')->default(false)->comment('Whether auto-close feature is enabled');
            $table->text('auto_close_statuses')->nullable()->comment('Comma-separated list of statuses that should trigger auto-close');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_settings');
    }
};
