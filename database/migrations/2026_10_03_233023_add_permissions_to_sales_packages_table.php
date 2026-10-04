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
            if (!Schema::hasColumn('sales_packages', 'permissions')) {
                $table->json('permissions')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_packages', function (Blueprint $table) {
            if (Schema::hasColumn('sales_packages', 'permissions')) {
                $table->dropColumn('permissions');
            }
        });
    }
};
