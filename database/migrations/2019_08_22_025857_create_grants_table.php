<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_name');
            $table->string('program');
            $table->string('course');
            $table->date('date_of_acceptance');
            $table->date('date_of_application');
            $table->date('date_of_form_submission');
            $table->date('date_of_submission');
            $table->string('loajd');
            $table->date('payment_due_date');
            $table->date('payment_date');
            $table->string('cheque_no');
            $table->date('start_date');
            $table->string('no_of_class');
            $table->string('status');
            $table->string('ojt_submit');
            $table->unsignedBigInteger('employee_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grants');
    }
}
