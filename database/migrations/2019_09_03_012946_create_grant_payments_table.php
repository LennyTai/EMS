<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grant_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('payment_due_date');
            $table->date('payment_date');
            $table->string('cheque_no');
            $table->string('ojt_submit');
            $table->string('payment_status');
            $table->integer('payment_amt');
            $table->unsignedBigInteger('grant_id');
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
        Schema::dropIfExists('grant_payments');
    }
}
