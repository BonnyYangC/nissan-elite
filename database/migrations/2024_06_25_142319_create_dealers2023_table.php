<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealers2023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers2023', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->notnull();

            $table->string('code', 50)->notnull()->unique();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('suburb', 50)->nullable();
            $table->string('postcode', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('category', 50);
            $table->string('category_code', 50);
            $table->string('region', 50);
            $table->string('region_code', 50);

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
        Schema::dropIfExists('dealers2023');
    }
}
