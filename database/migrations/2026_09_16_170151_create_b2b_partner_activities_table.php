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
        Schema::create('b2b_partner_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b2b_partner_id')->constrained('b2_b_partners')->onDelete('cascade');
            $table->string('activity_type'); // created, updated, deleted, status_changed, etc.
            $table->text('description')->nullable();
            $table->text('old_values')->nullable(); // JSON string of old values
            $table->text('new_values')->nullable(); // JSON string of new values
            $table->foreignId('performed_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2b_partner_activities');
    }
};
