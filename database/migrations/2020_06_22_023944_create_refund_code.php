<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('15_refund_code', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('refund_id')->unsigned()->index();
        //     $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
        //     $table->date('create_date');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('15_refund_code');
    }
}
