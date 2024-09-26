<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('username', 255);
            $table->string('image', 255)->nullable();
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('employee_id', 255);
            $table->string('joining_date', 255);
            $table->string('phone', 255);
            $table->string('company', 255);
            $table->string('department', 255);
            $table->string('designation', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
