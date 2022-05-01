<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->notnull();

            $table->string('code', 50)->notnull()->unique();  //          =>'dcode',//'d_code',
            $table->string('name');  //          =>'dname',//'d_name',
            $table->string('address')->nullable();  //       =>'addr_street',
            $table->string('suburb', 50)->nullable();  //        =>'addr_city',
            $table->string('postcode', 50)->nullable();  //      =>'addr_pcode',
            $table->string('state', 50)->nullable();  //         =>'addr_state',
            $table->string('country', 50)->nullable();
            $table->string('phone', 50)->nullable();  //         =>'ph_tel',
            $table->string('fax', 50)->nullable();  //           =>'ph_fax',
            $table->string('category', 50);  //              =>'dcat',//'d_cat',
            $table->string('category_code', 50);  //         =>'dcat#',//'d_cat_#',
            $table->string('region', 50);  //                =>'rname',//'r_name',
            $table->string('region_code', 50);  //           =>'rcode',//'r_code',

            $table->tinyInteger('active');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealers');
    }
}
