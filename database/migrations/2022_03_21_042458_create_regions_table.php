<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->notnull()->unique();
            $table->string('title');
        });

        DB::table('regions')->insert(array([
            'code' => 'E',
            'title' => 'Eastern'
        ], [
            'code' => 'N',
            'title' => 'Northern'
        ], [
            'code' => 'S',
            'title' => 'Southern'
        ], [
            'code' => 'W',
            'title' => 'Western & Central'
        ], [
            'code' => 'H',
            'title' => 'HEAD OFFICE'
        ], [
            'code' => 'NFSA',
            'title' => 'NFSA'
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
