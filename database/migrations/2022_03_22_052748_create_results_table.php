<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code');
            $table->date('period');
            $table->json('metrics');
            $table->unsignedBigInteger('training')->default(0);
            $table->unsignedBigInteger('training_competency')->default(0);
            $table->unsignedBigInteger('train_mastery')->default(0);
            $table->unsignedBigInteger('training_bonus')->default(0);
            $table->unsignedBigInteger('training_pathway')->default(0);
            $table->unsignedBigInteger('registration')->default(0);
            $table->unsignedBigInteger('excellence')->default(0);
            $table->unsignedBigInteger('incentive')->default(0);
            $table->unsignedBigInteger('adjustment')->default(0);
            $table->unsignedBigInteger('lifetime')->default(0);
            $table->unsignedBigInteger('credit_mtd')->default(0);
            $table->unsignedBigInteger('credit_ytd')->default(0);
            $table->timestamps();

            $table->foreign('employee_code')->references('employee_code')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
