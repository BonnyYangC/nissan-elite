<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealerRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_regions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->notnull();
            $table->string('category', 50);  //              =>'dcat',//'d_cat',
            $table->string('category_code', 50);  //         =>'dcat#',//'d_cat_#',
            $table->string('region', 50);  //                =>'rname',//'r_name',
            $table->string('region_code', 50);  //           =>'rcode',//'r_code',
            $table->timestamps();

            //$table->foreign('region')->references('code')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealer_regions');
    }
}
