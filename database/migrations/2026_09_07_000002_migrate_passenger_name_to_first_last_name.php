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
        // Check if the old 'name' column exists and copy data to 'first_name'
        if (Schema::hasColumn('booking_passengers', 'name')) {
            // Copy name to first_name (simple split by space, first part goes to first_name)
            DB::statement('UPDATE booking_passengers SET first_name = SUBSTRING_INDEX(name, " ", 1), last_name = SUBSTRING_INDEX(name, " ", -1) WHERE first_name IS NULL OR first_name = ""');

            // After data migration, remove the old name column
            Schema::table('booking_passengers', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the name column
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->string('name')->after('gender');
        });

        // Copy first_name and last_name back to name
        DB::statement('UPDATE booking_passengers SET name = CONCAT(COALESCE(first_name, ""), " ", COALESCE(last_name, "")) WHERE name IS NULL OR name = ""');

        // Remove first_name and last_name columns
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
