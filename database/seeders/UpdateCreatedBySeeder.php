<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedBySeeder extends Seeder
{
    public function run()
    {
        $databaseName = env('DB_DATABASE');
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$databaseName"};

            // Check if the table has a 'created_by' column
            if (Schema::hasColumn($tableName, 'created_by')) {
                // Update all rows where 'created_by' is NULL
                DB::table($tableName)->whereNull('created_by')->update(['created_by' => 6]);
            }
        }
    }
}
