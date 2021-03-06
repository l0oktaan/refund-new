<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('16_refund_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_id')->unsigned()->index();
            $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
            $table->integer('status_code');
            $table->dateTime('status_date');
            $table->string('status_by');
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
        Schema::dropIfExists('16_refund_status');
    }
}
