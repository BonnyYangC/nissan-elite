<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFakeDealer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('positions')->insert([
            [
                "code"=> "FAKE DEALER",
                "title"=> "Fake Dealer",
                "platinum_ranking" => 0
            ]
        ]);
        DB::table('users')->insert([
            [
                "firstname"=> "fake_dealer_name",
                "lastname"=> "fake_dealer_name",
                "email" => "fakedealer@dealer.com",
                "position_code" => "FAKE DEALER",
                "password" => Hash::make(strtoupper("fake_dealer_name").'1')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('positions')->where('code', "FAKE DEALER")->delete();
        DB::table('users')->where('position_code', "FAKE DEALER")->delete();
    }
}
