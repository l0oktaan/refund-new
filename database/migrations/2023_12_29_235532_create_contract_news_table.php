<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('32_contract_news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned()->index();
            $table->foreign('office_id')->references('id')->on('1_offices')->onDelete('cascade');
            $table->integer('contract_party_id')->unsigned()->index();
            $table->foreign('contract_party_id')->references('id')->on('31_contract_parties')->onDelete('cascade');
            $table->string("contract_no");
            $table->tinyInteger("status");
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
        Schema::dropIfExists('contract_news');
    }
}
