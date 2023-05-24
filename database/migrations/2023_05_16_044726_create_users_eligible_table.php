<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersEligibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_eligible', function (Blueprint $table) {
            $table->id();
            //$table->increments('id');
            $table->string('employee_code')->unique()->nullable();  //=>'regi#',
            $table->tinyInteger('registered')->default(0);  //=>'registered',
            $table->tinyInteger('member')->default(0); //=>'elite_mbr',
            $table->tinyInteger('met_criteria')->default(0); // => 'criteria_met_eoy',
            $table->tinyInteger('excellence_eligible')->default(0); // => 'excellence_eligible'
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
        Schema::dropIfExists('users_eligible');
    }
}
