<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerritoryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('territory_reports', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');       //     =>'regi#',

            $table->string('award_status', 50);
            $table->unsignedBigInteger('points_ytd_status');
            $table->unsignedBigInteger('credits_monthly_04');       //=>'elit~engi_regi#04mthyrg::points_mthly',//'amba_stat_04_apr::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_05');       //=>'elit~engi_regi#05mthyrg::points_mthly',//'amba_stat_05_may::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_06');       //=>'elit~engi_regi#06mthyrg::points_mthly',//'amba_stat_06_jun::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_07');       //=>'elit~engi_regi#07mthyrg::points_mthly',//'amba_stat_07_jul::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_08');       //=>'elit~engi_regi#08mthyrg::points_mthly',//'amba_stat_08_aug::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_09');       //=>'elit~engi_regi#09mthyrg::points_mthly',//'amba_stat_09_sep::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_10');       //=>'elit~engi_regi#10mthyrg::points_mthly',//'amba_stat_10_oct::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_11');       //=>'elit~engi_regi#11mthyrg::points_mthly',//'amba_stat_11_nov::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_12');       //=>'elit~engi_regi#12mthyrg::points_mthly',//'amba_stat_12_dec::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_01');       //=>'elit~engi_regi#01mthyrg::points_mthly',//'amba_stat_01_jan::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_02');       //=>'elit~engi_regi#02mthyrg::points_mthly',//'amba_stat_02_feb::credits_monthly',
            $table->unsignedBigInteger('credits_monthly_03');       //=>'elit~engi_regi#03mthyrg::points_mthly',//'amba_stat_03_mar::credits_monthly',
            $table->unsignedBigInteger('cr_ytd');       //            =>'points_ytd_status',//'amba_stat_ambid_gmthyr::credits_ytd',
            $table->unsignedBigInteger('cr_ytd_platinum');       //   =>'points_ytd_platinum',
            $table->unsignedBigInteger('cr_ytd_lifetime');       //   =>'points_ytd_lifetime',

            $table->timestamps();

            $table->foreign('employee_code')->references('employee_code')->on('users');
/*
            $table->string('dsm_full_name');       //     =>'elit~dreg_dcode::n_fullname',//'amba_deal~regi_rcode::n_fullname',
            $table->string('region_name');       //       =>'rname',//'amba_deal~regi_rcode::r_name',
            $table->string('region_code');       //       =>'rcode',//'amba_deal~regi_rcode::r_code',
            $table->string('dealer_code');       //       =>'dcode',//'d_code',
            $table->string('dealer_name');       //       =>'dname',//'d_name',
            $table->string('dealer_cat');       //        =>'dcat',//'d_cat',  // dealer's category, metro or district ...
            $table->string('sp_code');       //           =>'sp_code',
            $table->string('n_fullname');       //        =>'n_fullname',
            $table->string('position');       //          =>'position',
            $table->string('registered');       //        =>'registered',
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('territory_reports');
    }
}
