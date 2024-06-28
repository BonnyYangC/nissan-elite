<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('acls')->insert([
            ['position' => 'TA', 'page' => 'dashboard'],
            ['position' => 'TA', 'page' => 'metrics'],
            ['position' => 'TA', 'page' => 'ranking'],
            ['position' => 'TA', 'page' => 'incentives'],
            ['position' => 'TA', 'page' => 'member_guide'],
            ['position' => 'TA', 'page' => 'future_sales'],
            ['position' => 'TA', 'page' => 'program'],
            ['position' => 'TA', 'page' => 'calendar'],
            ['position' => 'TA', 'page' => 'product_challenge'],
            ['position' => 'TA', 'page' => 'awards'],
            ['position' => 'TA', 'page' => 'loyalty'],
            ['position' => 'TA', 'page' => 'guild'],
            ['position' => 'TA', 'page' => 'account'],
            ['position' => 'TA', 'page' => 'help'],
            ['position' => 'TM', 'page' => 'dashboard'],
            ['position' => 'TM', 'page' => 'metrics'],
            ['position' => 'TM', 'page' => 'ranking'],
            ['position' => 'TM', 'page' => 'incentives'],
            ['position' => 'TM', 'page' => 'member_guide'],
            ['position' => 'TM', 'page' => 'future_sales'],
            ['position' => 'TM', 'page' => 'program'],
            ['position' => 'TM', 'page' => 'calendar'],
            ['position' => 'TM', 'page' => 'product_challenge'],
            ['position' => 'TM', 'page' => 'awards'],
            ['position' => 'TM', 'page' => 'loyalty'],
            ['position' => 'TM', 'page' => 'guild'],
            ['position' => 'TM', 'page' => 'account'],
            ['position' => 'TM', 'page' => 'help'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('acls')->whereIn('position', ['TM', 'TA'])->delete();
    }
}
