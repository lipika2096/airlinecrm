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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->double('wallet', 10, 2);
            $table->double('available_balance', 10, 2)->nullable();
            $table->string('razorpay_id')->default('');
            $table->string('status')->nullable();
            $table->string('parent_id')->default('');
            $table->longText('description')->nullable();
            $table->dateTime('date');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
