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
         // Replace 'table_name' with your actual table name
         $tableName = 'airline_details';

         // Fetch all columns of the table
         $columns = DB::select("SHOW COLUMNS FROM $tableName");
        // Filter out 'created_at' and 'updated_at' columns
        $columns = array_filter($columns, function ($column) {
            return $column->Field !== 'created_at' && $column->Field !== 'updated_at';
        });
         // Generate ALTER statements to make columns NOT NULL
         foreach ($columns as $column) {
             $columnName = $column->Field;
             $columnType = $column->Type;

             if ($column->Null === 'NO') {
                DB::statement("ALTER TABLE $tableName MODIFY `$columnName` $columnType NULL");
            }
         }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Replace 'table_name' with your actual table name
         $tableName = 'airline_details';

         // Fetch all columns of the table
         $columns = DB::select("SHOW COLUMNS FROM $tableName");

         // Generate ALTER statements to make columns NOT NULL
         foreach ($columns as $column) {
             $columnName = $column->Field;
             $columnType = $column->Type;

             if ($column->Null === 'YES') {
                 DB::statement("ALTER TABLE $tableName MODIFY `$columnName` $columnType NOT NULL");
             }
         }
    }
};
