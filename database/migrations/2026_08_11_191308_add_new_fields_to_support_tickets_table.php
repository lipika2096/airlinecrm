<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->enum('department', ['technical_support', 'billing', 'booking', 'account', 'other'])->after('ticket_number');
            $table->text('attachments')->nullable()->after('related_user_id');
            $table->string('booking_reference')->nullable()->after('attachments');
        });
        
        // Update priority enum separately
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropColumn(['department', 'attachments', 'booking_reference']);
        });
        
        // Revert priority enum back to original values
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium'");
    }
};
