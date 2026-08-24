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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('subject');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            
            // Who created the ticket (can be any role - admins or users table)
            $table->unsignedBigInteger('created_by');
            
            // Who the ticket is assigned to/created for (can be admins or users table)
            $table->unsignedBigInteger('assigned_to')->nullable();
            
            // For tracking who the ticket is about (optional - could be a customer, staff, etc.)
            $table->unsignedBigInteger('related_user_id')->nullable();
            
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
