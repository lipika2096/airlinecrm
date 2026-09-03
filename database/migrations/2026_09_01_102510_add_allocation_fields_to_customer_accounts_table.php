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
            $table->string('allocated_to')->nullable()->after('allocated_to_customer_account_id');
            $table->string('expense_category')->nullable()->after('allocated_to');
            $table->string('supplier_name')->nullable()->after('expense_category');
            $table->string('invoice_number')->nullable()->after('supplier_name');
            $table->decimal('allocated_amount', 10, 2)->nullable()->after('invoice_number');
            $table->text('remarks')->nullable()->after('allocated_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_accounts', function (Blueprint $table) {
            $table->dropColumn(['allocated_to', 'expense_category', 'supplier_name', 'invoice_number', 'allocated_amount', 'remarks']);
        });
    }
};
