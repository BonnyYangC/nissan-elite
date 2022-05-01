<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position', 50)->nullable();

            $table->string('identifier');
            $table->string('type');   // shared or custom
            $table->string('label');  // chart legend label
            $table->string('color');  // chart legend color
            $table->unsignedInteger('order');
            $table->string('title');
            $table->json('guides')->nullable();
            $table->string('ref')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('metrics');
    }
}
