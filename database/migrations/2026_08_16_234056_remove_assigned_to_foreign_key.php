<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['related_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('related_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
