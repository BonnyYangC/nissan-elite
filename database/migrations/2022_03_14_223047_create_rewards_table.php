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
            'position' => 'F', // Fleet Sales Executives
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '18000',
            'bronze_reward' => '750',
            'silver' => '27000',
            'silver_reward' => '1500',
            'gold' => '36000',
            'gold_reward' => '2000',
            'max' => '50000'
        ],[
            'position' => 'M', // Sales Manager
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '18000',
            'bronze_reward' => '750',
            'silver' => '27000',
            'silver_reward' => '1500',
            'gold' => '36000',
            'gold_reward' => '2000',
            'max' => '50000'
        ],[
            'position' => 'R', // Retail Sales Consultants
            'commendation' => '12000',
            'commendation_reward' => '100',
            'bronze' => '18000',
            'bronze_reward' => '750',
            'silver' => '27000',
            'silver_reward' => '1500',
            'gold' => '36000',
            'gold_reward' => '2000',
            'max' => '43000'
        ],[
            'position' => 'SC', // Stock Controller
            'commendation' => '10000',
            'commendation_reward' => '100',
            'bronze' => '14000',
            'bronze_reward' => '500',
            'silver' => '18000',
            'silver_reward' => '850',
            'gold' => '24000',
            'gold_reward' => '1000',
            'max' => '30000'
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
            'commendation' => '9000',
            'commendation_reward' => '100',
            'bronze' => '14000',
            'bronze_reward' => '500',
            'silver' => '23000',
            'silver_reward' => '1000',
            'gold' => '33000',
            'gold_reward' => '1500',
            'max' => '34500'
        ],[
            'position' => 'PS', // Parts Sales Rep
            'commendation' => '9000',
            'commendation_reward' => '100',
            'bronze' => '14000',
            'bronze_reward' => '500',
            'silver' => '23000',
            'silver_reward' => '1000',
            'gold' => '33000',
            'gold_reward' => '1500',
            'max' => '34500'
        ],[
            'position' => 'SM', // Service Manager
            'commendation' => '9000',
            'commendation_reward' => '100',
            'bronze' => '14000',
            'bronze_reward' => '500',
            'silver' => '23000',
            'silver_reward' => '1000',
            'gold' => '33000',
            'gold_reward' => '1500',
            'max' => '34500'
        ],[
            'position' => 'SA', // Service Adviser
            'commendation' => '9000',
            'commendation_reward' => '100',
            'bronze' => '14000',
            'bronze_reward' => '500',
            'silver' => '23000',
            'silver_reward' => '1000',
            'gold' => '33000',
            'gold_reward' => '1500',
            'max' => '34500'
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
