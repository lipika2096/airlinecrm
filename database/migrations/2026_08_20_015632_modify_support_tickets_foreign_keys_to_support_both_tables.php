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
        // Drop foreign keys using raw SQL
        // Note: MySQL doesn't support IF EXISTS with DROP FOREIGN KEY, so we suppress errors
        try {
            DB::statement("ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_created_by_foreign");
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }
        try {
            DB::statement("ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_assigned_to_foreign");
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }
        try {
            DB::statement("ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_related_user_id_foreign");
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        Schema::table('support_tickets', function (Blueprint $table) {
            // Change columns to unsignedBigInteger without foreign key constraints
            // This allows referencing both admins and users tables
            $table->unsignedBigInteger('created_by')->change();
            $table->unsignedBigInteger('assigned_to')->nullable()->change();
            $table->unsignedBigInteger('related_user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            // Re-add foreign key constraints for admins table
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('related_user_id')->references('id')->on('admins')->onDelete('set null');
        });
    }
};
