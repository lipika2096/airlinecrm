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
        Schema::create('payment_pool_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('account_name')->nullable();
            $table->text('remarks')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->enum('status', ['unallocated', 'allocated'])->default('unallocated');
            $table->unsignedBigInteger('allocated_to_customer_account_id')->nullable();
            $table->timestamp('allocated_at')->nullable();
            $table->timestamps();
            
            $table->foreign('allocated_to_customer_account_id', 'pp_trans_cust_acc_fk')->references('id')->on('customer_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_pool_transactions');
    }
};
