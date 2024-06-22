<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_positions', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 50);
            $table->string('position_code', 50)->nullable();
            $table->year('year')->default(2023);
            $table->timestamps();

            $table->foreign('employee_code')->references('employee_code')->on('users');
            $table->foreign('position_code')->references('code')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_positions');
    }
}
