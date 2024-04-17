<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproveRefundRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('34_approve_refund_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_new_id')->unsigned()->index();
            $table->foreign('contract_new_id')->references('id')->on('32_contract_news')->onDelete('cascade');
            $table->tinyInteger("refund_order");
            $table->integer("refund_amount");
            $table->integer("balance");
            $table->string("refund_case");
            $table->string("approve_book_no");
            $table->string("approve_book_date");
            $table->string("modified_by");
            $table->string("description");
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
        Schema::dropIfExists('34_approve_refund_records');
    }
}
