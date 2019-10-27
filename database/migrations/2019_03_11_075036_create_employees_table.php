<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nric');
            $table->date('dob');
            $table->string('gender');
            $table->text('address');
            $table->string('marital_status');
            $table->string('race');
            $table->string('religion');
            $table->string('nationality');
            $table->string('passport_no');
            $table->date('passport_exp_date');
            $table->string('pr_status');
            $table->string('type_of_emp');
            $table->string('work_pass');
            $table->string('fin_no');
            $table->date('wp_app_date');
            $table->date('wp_exp_date');
            $table->string('bank_name');
            $table->string('bank_acc_no');
            $table->string('int_job_title');
            $table->string('ext_job_title');
            $table->integer('salary');

            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');

            $table->date('joint_date');
            $table->date('confirmed_date');
            $table->string('confirmed_status');
            $table->date('leave_date');
            $table->softDeletes();
            $table->timestamps();

/*            $table->integer('department_id');
            $table->string('department');
            $table->string('hod');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
