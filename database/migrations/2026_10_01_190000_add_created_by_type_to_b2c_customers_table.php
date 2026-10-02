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
        Schema::table('b2c_customers', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            // Add created_by_type and updated_by_type fields
            $table->enum('created_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('created_by');
            $table->enum('updated_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2c_customers', function (Blueprint $table) {
            // Drop the type fields
            $table->dropColumn('created_by_type');
            $table->dropColumn('updated_by_type');

            // Re-add the foreign key constraints (only for admins)
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreign('updated_by')->nullable()->constrained('admins')->onDelete('set null');
        });
    }
};
