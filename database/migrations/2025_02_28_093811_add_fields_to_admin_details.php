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
            $table->string('group')->nullable();
            $table->string('pincode')->nullable();
            $table->string('company_registration_no')->nullable();
            $table->string('no_modules')->nullable();
            $table->string('subscription_type')->nullable();
            $table->string('subscription_charge')->nullable();
            $table->string('subscription_expiring')->nullable();
            $table->string('business_focus')->nullable();
            $table->string('remarks')->nullable();
            $table->string('business_mode')->nullable();
            $table->string('key_people')->nullable();
            $table->string('parent_company')->nullable();
            $table->string('headquarters')->nullable();
            $table->string('no_employees')->nullable();
            $table->string('websites')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn([
                'group',
                'pincode',
                'company_registration_no',
                'no_modules',
                'subscription_type',
                'subscription_charge',
                'subscription_expiring',
                'business_focus',
                'remarks',
                'business_mode',
                'key_people',
                'parent_company',
                'headquarters',
                'no_employees',
                'websites'
            ]);
        });
    }
};
