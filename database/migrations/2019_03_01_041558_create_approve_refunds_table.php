<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproveRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('8_approve_refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_id')->unsigned()->index()->unique();
            $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
            //$table->date('receive_date');
            $table->integer('refund_days');
            $table->double('refund_money',15,2);
            $table->double('refund_amount',15,2);
            $table->double('approve_amount',15,2);
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
        Schema::dropIfExists('approve_refunds');
    }
}
