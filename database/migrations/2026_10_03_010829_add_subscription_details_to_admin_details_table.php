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
        Schema::table('admin_details', function (Blueprint $table) {
            $table->json('subscription_modules')->nullable()->after('package_activation_date');
            $table->decimal('monthly_charge', 10, 2)->nullable()->after('subscription_modules');
            $table->decimal('annual_charge', 10, 2)->nullable()->after('monthly_charge');
            $table->decimal('setup_fee', 10, 2)->nullable()->after('annual_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn(['subscription_modules', 'monthly_charge', 'annual_charge', 'setup_fee']);
        });
    }
};
