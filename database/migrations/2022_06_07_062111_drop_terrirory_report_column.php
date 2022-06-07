<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTerriroryReportColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('territory_reports', function (Blueprint $table) {
            $table->dropColumn('points_ytd_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::table('territory_reports', function (Blueprint $table) {
        //    $table->addColumn('points_ytd_status');
        //});
    }
}
