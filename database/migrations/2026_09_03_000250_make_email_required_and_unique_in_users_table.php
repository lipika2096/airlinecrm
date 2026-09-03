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
        // First, update any NULL email values to a placeholder to allow making the field NOT NULL
        DB::statement("UPDATE users SET email = CONCAT('temp_', id, '@noemail.com') WHERE email IS NULL OR email = ''");
        
        // Handle duplicate email addresses by adding a suffix to duplicates
        $duplicates = DB::select("
            SELECT email, GROUP_CONCAT(id ORDER BY id) as ids
            FROM users
            WHERE email IS NOT NULL AND email != ''
            GROUP BY email
            HAVING COUNT(*) > 1
        ");
        
        foreach ($duplicates as $duplicate) {
            $ids = explode(',', $duplicate->ids);
            // Keep the first ID as is, update the rest with a suffix
            array_shift($ids); // Remove the first ID
            foreach ($ids as $index => $id) {
                $suffix = $index + 1;
                DB::statement("UPDATE users SET email = CONCAT(email, '_duplicate{$suffix}') WHERE id = ? AND email = ?", [$id, $duplicate->email]);
            }
        }
        
        Schema::table('users', function (Blueprint $table) {
            // Make email field NOT NULL
            $table->string('email')->nullable(false)->change();
            
            // Ensure unique constraint exists (it should already exist based on the schema)
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove unique constraint
            $table->dropUnique(['email']);
            
            // Make email field nullable again
            $table->string('email')->nullable()->change();
        });
        
        // Optionally, you could also clean up the temporary email addresses if needed
        // DB::statement("UPDATE users SET email = NULL WHERE email LIKE 'temp_%@noemail.com'");
    }
};
