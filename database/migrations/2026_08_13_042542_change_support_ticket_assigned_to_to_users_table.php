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
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Drop existing foreign keys
        try {
            DB::statement('ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_assigned_to_foreign');
        } catch (\Exception $e) {}
        
        try {
            DB::statement('ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_related_user_id_foreign');
        } catch (\Exception $e) {}
        
        // Change column types to match users table (int)
        DB::statement('ALTER TABLE support_tickets MODIFY assigned_to INT UNSIGNED NULL');
        DB::statement('ALTER TABLE support_tickets MODIFY related_user_id INT UNSIGNED NULL');
        
        // Add new foreign keys to users table
        DB::statement('ALTER TABLE support_tickets ADD CONSTRAINT support_tickets_assigned_to_foreign FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE support_tickets ADD CONSTRAINT support_tickets_related_user_id_foreign FOREIGN KEY (related_user_id) REFERENCES users(id) ON DELETE SET NULL');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Drop the new foreign keys
        DB::statement('ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_assigned_to_foreign');
        DB::statement('ALTER TABLE support_tickets DROP FOREIGN KEY support_tickets_related_user_id_foreign');
        
        // Change column types back to bigint unsigned for admins table
        DB::statement('ALTER TABLE support_tickets MODIFY assigned_to BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE support_tickets MODIFY related_user_id BIGINT UNSIGNED NULL');
        
        // Add back foreign keys to admins table
        DB::statement('ALTER TABLE support_tickets ADD CONSTRAINT support_tickets_assigned_to_foreign FOREIGN KEY (assigned_to) REFERENCES admins(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE support_tickets ADD CONSTRAINT support_tickets_related_user_id_foreign FOREIGN KEY (related_user_id) REFERENCES admins(id) ON DELETE SET NULL');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
