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
        $originalTable = 'cases'; // Change to your actual table name
        $newTable = 'customer_case_histories'; // Change to the desired new table name

        // Create new table with the same structure
        DB::statement("CREATE TABLE $newTable LIKE $originalTable");

        // Copy all data from the original table
        DB::statement("INSERT INTO $newTable SELECT * FROM $originalTable");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_case_histories');
    }
};
