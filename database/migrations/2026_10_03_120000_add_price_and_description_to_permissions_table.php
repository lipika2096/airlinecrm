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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('description')->nullable()->after('status');
            $table->decimal('monthly_price', 10, 2)->nullable()->default(0)->after('description');
            $table->boolean('is_priced_module')->default(false)->after('monthly_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['description', 'monthly_price', 'is_priced_module']);
        });
    }
};
