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
        // Update b2c_passengers table
        Schema::table('b2c_passengers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->enum('created_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('created_by');
            $table->enum('updated_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('updated_by');
        });

        // Update b2c_customer_notes table
        Schema::table('b2c_customer_notes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->enum('created_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('created_by');
        });

        // Update b2c_customer_documents table
        Schema::table('b2c_customer_documents', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->enum('created_by_type', ['superadmin', 'customer', 'staff'])->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse b2c_passengers table
        Schema::table('b2c_passengers', function (Blueprint $table) {
            $table->dropColumn('created_by_type');
            $table->dropColumn('updated_by_type');
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreign('updated_by')->nullable()->constrained('admins')->onDelete('set null');
        });

        // Reverse b2c_customer_notes table
        Schema::table('b2c_customer_notes', function (Blueprint $table) {
            $table->dropColumn('created_by_type');
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
        });

        // Reverse b2c_customer_documents table
        Schema::table('b2c_customer_documents', function (Blueprint $table) {
            $table->dropColumn('created_by_type');
            $table->foreign('created_by')->nullable()->constrained('admins')->onDelete('set null');
        });
    }
};
