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
        Schema::table('b2b_partner_activities', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['performed_by']);

            // Add performed_by_type column
            $table->string('performed_by_type')->nullable()->after('performed_by');

            // No foreign key constraint since IDs can come from admins or users table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2b_partner_activities', function (Blueprint $table) {
            // Remove the type column
            $table->dropColumn(['performed_by_type']);

            // Re-add foreign key constraint
            $table->foreign('performed_by')->nullable()->constrained('admins')->onDelete('set null');
        });
    }
};
