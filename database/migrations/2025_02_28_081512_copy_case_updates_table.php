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
        $originalTable = 'case_updates';
        $newTable = 'customer_case_updates';
        DB::statement("CREATE TABLE $newTable LIKE $originalTable");

        DB::statement("INSERT INTO $newTable SELECT * FROM $originalTable");


        DB::table('customer_case_updates')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_case_updates');
    }
};
