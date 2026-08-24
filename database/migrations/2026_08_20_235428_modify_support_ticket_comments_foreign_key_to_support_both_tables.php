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
        // Drop foreign key using raw SQL to handle any naming convention
        DB::statement("ALTER TABLE support_ticket_comments DROP FOREIGN KEY IF EXISTS support_ticket_comments_user_id_foreign");
        
        Schema::table('support_ticket_comments', function (Blueprint $table) {
            // Change column to unsignedBigInteger without foreign key constraint
            // This allows referencing both admins and users tables
            $table->unsignedBigInteger('user_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_ticket_comments', function (Blueprint $table) {
            // Re-add foreign key constraint for admins table
            $table->foreign('user_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }
};
