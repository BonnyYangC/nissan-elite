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
            ['position' => 'T', 'page' => 'dashboard'],
            ['position' => 'T', 'page' => 'metrics'],
            ['position' => 'T', 'page' => 'ranking'],
            ['position' => 'T', 'page' => 'incentives'],
            ['position' => 'T', 'page' => 'member_guide'],
            ['position' => 'T', 'page' => 'future_sales'],
            ['position' => 'T', 'page' => 'program'],
            ['position' => 'T', 'page' => 'calendar'],
            ['position' => 'T', 'page' => 'product_challenge'],
            ['position' => 'T', 'page' => 'awards'],
            ['position' => 'T', 'page' => 'loyalty'],
            ['position' => 'T', 'page' => 'guild'],
            ['position' => 'T', 'page' => 'account'],
            ['position' => 'T', 'page' => 'faq'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
