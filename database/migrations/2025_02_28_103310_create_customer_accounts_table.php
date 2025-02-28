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
        $originalTable = 'agent_accounts';
        $newTable = 'customer_accounts';
        DB::statement("CREATE TABLE $newTable LIKE $originalTable");

        DB::statement("INSERT INTO $newTable SELECT * FROM $originalTable");


        DB::table('customer_accounts')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_accounts');
    }
};
