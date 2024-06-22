<?php

use Illuminate\Database\Migrations\Migration;

class AddNewPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {DB::table('positions')->insert([
            
        [
            "code"=> "T",
            "title"=> "Technician",
            "platinum_ranking"=> 0,
            "department"=> "Service Tech"
        ],
        [
            "code"=> "TM",
            "title"=> "Master Technician",
            "platinum_ranking"=> 0,
            "department"=> "Service Tech"
        ],
        [
            "code"=> "TA",
            "title"=> "Advanced Technician",
            "platinum_ranking"=> 0,
            "department"=> "Service Tech"
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
        DB::table('positions')->whereIn('position', ['TT', 'TM', 'TA'])->delete();
    }
}
