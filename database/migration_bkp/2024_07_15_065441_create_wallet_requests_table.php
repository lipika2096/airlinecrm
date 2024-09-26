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
        Schema::create('wallet_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('payment_mode', 191);
            $table->string('amount', 191);
            $table->string('bank_tran_id', 191);
            $table->date('date');
            $table->string('bank_name', 191);
            $table->string('bank_branch', 191);
            $table->string('admin_bank_id', 191);
            $table->string('remark', 191)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_requests');
    }
};
