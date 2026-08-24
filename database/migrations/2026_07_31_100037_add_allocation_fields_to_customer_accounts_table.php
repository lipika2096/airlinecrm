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
        Schema::table('customer_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('allocated_to_customer_account_id')->nullable()->after('payment_pool');
            $table->timestamp('allocated_at')->nullable()->after('allocated_to_customer_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_accounts', function (Blueprint $table) {
            $table->dropColumn(['allocated_to_customer_account_id', 'allocated_at']);
        });
    }
};
