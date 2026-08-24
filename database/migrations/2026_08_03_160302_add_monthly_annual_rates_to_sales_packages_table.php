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
        Schema::table('sales_packages', function (Blueprint $table) {
            $table->decimal('monthly_rate', 10, 2)->nullable()->after('rate');
            $table->decimal('annual_rate', 10, 2)->nullable()->after('monthly_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_packages', function (Blueprint $table) {
            $table->dropColumn(['monthly_rate', 'annual_rate']);
        });
    }
};
