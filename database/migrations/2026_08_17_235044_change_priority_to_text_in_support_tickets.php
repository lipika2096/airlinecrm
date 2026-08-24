<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN priority VARCHAR(255) NULL DEFAULT 'medium'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN priority ENUM('low', 'medium', 'high', 'urgent') NULL DEFAULT 'medium'");
    }
};
