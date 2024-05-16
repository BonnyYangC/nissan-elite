<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersEligibleTableAddYearColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_eligible', function (Blueprint $table) {
            $table->dropUnique('users_eligible_employee_code_unique');
            $table->year('year')->default(2023);
            $table->unique(['employee_code', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_eligible', function (Blueprint $table) {
            $table->dropUnique('users_eligible_employee_code_year_unique');
            $table->dropColumn('year');
            $table->unique(['year']);
        });
    }
}
