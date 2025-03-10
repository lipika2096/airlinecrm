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
        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Get the database name
        $databaseName = env('DB_DATABASE');

        // Iterate all tables
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};

            // Check if columns already exist
            if (
                !Schema::hasColumn($tableName, 'created_by') &&
                !Schema::hasColumn($tableName, 'updated_by')
            ) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('created_by')->nullable();
                    $table->unsignedBigInteger('updated_by')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Get the database name
        $databaseName = env('DB_DATABASE');

        // Iterate all tables
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};

            // Check if columns exist, then drop them
            if (Schema::hasColumn($tableName, 'created_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('created_by');
                });
            }

            if (Schema::hasColumn($tableName, 'updated_by')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('updated_by');
                });
            }
        }
    }
};
