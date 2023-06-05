<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_code')->unique()->nullable();  //=>'regi#',

            $table->string('salutation', 50)->nullable();  //=>'n_title',
            $table->string('firstname');  //=>'n_fname_trim',
            $table->string('lastname');  //=>'n_sname_trim',
            $table->string('email');  //=>'addr_email',
            $table->string('password');
            $table->string('mobile', 50)->nullable();  //=>'ph_mobile',
            $table->date('date_birth')->nullable(); //=>'date_birth',//'date_of_birth',

            $table->string('dealer_code', 50)->nullable();  //=>'dcode',
            $table->string('position_code', 50)->nullable();  //=>'sp',
            $table->string('dept', 50)->nullable();  //=>'dept_code',
            $table->string('region_code', 50)->nullable();  //'region',  this field is for region staff

            $table->tinyInteger('admin')->default(0);
            $table->tinyInteger('active')->default(0); //=>'status',
            $table->date('date_created')->nullable(); // =>'date_created',
            $table->timestamps();

            $table->string('remember_token', 100)->nullable();
            $table->softDeletes();

            $table->foreign('position_code')->references('code')->on('positions');
            $table->foreign('dealer_code')->references('code')->on('dealers');
            $table->foreign('region_code')->references('code')->on('regions');
        });

        /*DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => '$2y$10$yom45pyfRBBcQwd/durPReiOYGDuednowx2/w0RlQlDmsjekdqIru', //'Pamjo1',
            'position' => 'SUPADM'
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
