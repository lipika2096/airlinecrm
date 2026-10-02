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
        Schema::table('b2_b_partners', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            // Remove the foreign key constraints and keep as regular integer fields
            // This allows both admin and staff users to create/update records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2_b_partners', function (Blueprint $table) {
            // Re-add the foreign key constraints (only for admins)
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreign('updated_by')->nullable()->constrained('admins')->onDelete('set null');
        });
    }
};
