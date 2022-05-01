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
            //$table->string('alt_email');
            $table->string('password');
            $table->string('mobile', 50)->nullable();  //=>'ph_mobile',
            $table->date('date_birth')->nullable(); //=>'date_birth',//'date_of_birth',

            $table->string('dealer_code', 50)->nullable();  //=>'dcode',
            $table->string('position_code', 50)->nullable();  //=>'sp',
            $table->string('dept', 50)->nullable();  //=>'dept_code',
            $table->string('region_code', 50)->nullable();  //'region',  this field is for region staff

            $table->tinyInteger('admin')->default(0);
            $table->tinyInteger('active')->default(0); //=>'status',
            $table->tinyInteger('registered')->default(0);  //=>'registered',
            $table->tinyInteger('member')->default(0); //=>'elite_mbr',
            $table->tinyInteger('met_criteria')->default(0); // => 'criteria_met_eoy',
            $table->tinyInteger('excellence_eligible')->default(0); // => 'excellence_eligible'
            $table->date('date_created')->nullable(); // =>'date_created',
            $table->timestamps();

            $table->string('remember_token', 100)->nullable();
            $table->softDeletes();


            /*
            $table->string('parent_id');
            $table->string('company_code');
            $table->string('company_altcode');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('alt_position');
            $table->string('phone');
            $table->boolean('private');
            $table->string('address');
            $table->string('suburb');
            $table->string('postcode');
            $table->string('state');
            $table->string('country');
            $table->string('sex');
            $table->string('costcentre');
            $table->string('avatar');
            $table->string('emergency_person');
            $table->string('emergency_phone');
            $table->string('medical');
            $table->string('diet');
            $table->string('ff_supplier');
            $table->string('ff_number');
            $table->date('ff_expire');
            $table->string('passport_country');
            $table->string('passport_number');
            $table->string('passport_expire');
            $table->string('shopping');
            $table->string('updateflag');
            $table->string('contact');
            $table->rememberToken(); */

            $table->foreign('position_code')->references('code')->on('positions');
            $table->foreign('dealer_code')->references('code')->on('dealers');
            $table->foreign('region')->references('code')->on('regions');
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
