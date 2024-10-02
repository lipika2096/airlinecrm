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
        Schema::table('categories', function (Blueprint $table) {
            //
            $table->integer('category_id')->comment('[do not truncate] - only delete where category_system_default = no')->nullable();
            $table->timestamp('category_created')->nullable();
            $table->timestamp('category_updated')->nullable();
            $table->unsignedBigInteger('category_creatorid')->nullable();
            $table->string('category_name', 150)->nullable();
            $table->string('category_description', 150)->nullable()->comment('optional (mainly used by knowledge base)');
            $table->string('category_system_default', 20)->default('no')->comment('yes | no (system default cannot be deleted)');
            $table->string('category_visibility', 20)->default('everyone')->comment('everyone | team | client (mainly used by knowledge base)');
            $table->string('category_icon', 100)->default('sl-icon-docs')->comment('optional (mainly used by knowledge base)')->nullable();
            $table->string('category_type', 50)->comment('project | client | contract | expense | invoice | lead | ticket | item| estimate | knowledgebase')->nullable();
            $table->string('category_slug', 250)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};
