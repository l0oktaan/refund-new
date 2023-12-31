<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('33_deposit_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_new_id')->unsigned()->index();
            $table->foreign('contract_new_id')->references('id')->on('32_contract_news')->onDelete('cascade');
            $table->string("deposit_no");
            $table->date("deposit_date");
            $table->integer("amount");
            $table->integer("amount_in_contract");
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
        Schema::dropIfExists('deposit_records');
    }
}
