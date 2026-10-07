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
        Schema::table('b2_b_partner_documents', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            // Add created_by_type and updated_by_type columns
            $table->string('created_by_type')->nullable()->after('created_by');
            $table->string('updated_by_type')->nullable()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2_b_partner_documents', function (Blueprint $table) {
            $table->dropColumn(['created_by_type', 'updated_by_type']);

            // Re-add foreign key constraints
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreign('updated_by')->nullable()->constrained('admins')->onDelete('set null');
        });
    }
};
