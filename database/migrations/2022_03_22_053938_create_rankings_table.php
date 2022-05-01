<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code');
            $table->date('period');
            $table->integer('rank')->nullable();
            $table->unsignedBigInteger('total')->nullable();
            $table->integer('rank_platinum')->nullable();
            $table->unsignedBigInteger('total_platinum')->nullable();
            $table->string('rank_state');
            $table->string('position');
            //$table->string('category');
            $table->timestamps();

            $table->foreign('employee_code')->references('employee_code')->on('users');
            $table->foreign('position')->references('code')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rinkings');
    }
}
