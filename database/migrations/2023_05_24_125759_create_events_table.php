<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();

            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('region', 50)->default('All'); //TBC: can be foreign key

            $table->unsignedInteger('incentive')->nullable();
            $table->timestamps();

            $table->foreign('incentive')->references('id')->on('incentives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
