<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncentivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->date('start')->nullable();
            $table->date('finish')->nullable();
            $table->text('caption')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('pdf', 255)->nullable();
            $table->string('region', 50)->default('All');  //TBC: can be foreign key

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
        Schema::dropIfExists('incentives');
    }
}
