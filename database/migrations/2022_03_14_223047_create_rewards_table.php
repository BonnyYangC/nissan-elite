<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position');
            $table->string('commendation');
            $table->string('commendation_reward');
            $table->string('bronze');
            $table->string('bronze_reward');
            $table->string('silver');
            $table->string('silver_reward');
            $table->string('gold');
            $table->string('gold_reward');
            $table->string('max');

            // $table->foreign('position')->references('code')->on('positions');
        });

        DB::table('rewards')->insert(array([
            'position' => 'M', // Sales Manager
            'commendation' => '15000',
            'commendation_reward' => '100',
            'bronze' => '28000',
            'bronze_reward' => '750',
            'silver' => '38000',
            'silver_reward' => '1500',
            'gold' => '48000',
            'gold_reward' => '2000',
            'max' => '55000'
        ],[
            'position' => 'R', // Retail Sales Consultants
            'commendation' => '15000',
            'commendation_reward' => '100',
            'bronze' => '25000',
            'bronze_reward' => '750',
            'silver' => '35000',
            'silver_reward' => '1500',
            'gold' => '45000',
            'gold_reward' => '2000',
            'max' => '50000'
        ],[
            'position' => 'F', // Fleet Sales Executives
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '750',
            'silver' => '32000',
            'silver_reward' => '1500',
            'gold' => '40000',
            'gold_reward' => '2000',
            'max' => '50000'
        ],[
            'position' => 'SC', // Stock Controller
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '500',
            'silver' => '32000',
            'silver_reward' => '850',
            'gold' => '40000',
            'gold_reward' => '1000',
            'max' => '50000'
        ],[
            'position' => 'I', // F&I Manager
            'commendation' => '11000',
            'commendation_reward' => '100',
            'bronze' => '20000',
            'bronze_reward' => '500',
            'silver' => '27000',
            'silver_reward' => '850',
            'gold' => '36000',
            'gold_reward' => '1000',
            'max' => '50000'
        ],[
            'position' => 'PM', // Parts Manager
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '500',
            'silver' => '32000',
            'silver_reward' => '1000',
            'gold' => '40000',
            'gold_reward' => '1500',
            'max' => '50000'
        ],[
            'position' => 'PS', // Parts Sales Rep
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '500',
            'silver' => '32000',
            'silver_reward' => '1000',
            'gold' => '40000',
            'gold_reward' => '1500',
            'max' => '50000'
        ],[
            'position' => 'SM', // Service Manager
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '500',
            'silver' => '32000',
            'silver_reward' => '1000',
            'gold' => '40000',
            'gold_reward' => '1500',
            'max' => '50000'
        ],[
            'position' => 'SA', // Service Adviser
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '22000',
            'bronze_reward' => '500',
            'silver' => '32000',
            'silver_reward' => '1000',
            'gold' => '40000',
            'gold_reward' => '1500',
            'max' => '50000'
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
