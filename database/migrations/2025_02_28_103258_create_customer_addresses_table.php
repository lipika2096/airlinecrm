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
        $originalTable = 'agent_addresses';
        $newTable = 'customer_addresses';
        DB::statement("CREATE TABLE $newTable LIKE $originalTable");

        DB::statement("INSERT INTO $newTable SELECT * FROM $originalTable");


        DB::table('customer_addresses')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
