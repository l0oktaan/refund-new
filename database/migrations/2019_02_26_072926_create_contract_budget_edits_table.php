<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractBudgetEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('4_contract_budget_edits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_id')->unsigned()->index();
            $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
            //$table->integer('order');
            $table->bigInteger('budget_new');
            $table->float('penalty_new',10,2);
            $table->date('contract_edit_date');
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
        Schema::dropIfExists('contract_budget_edits');
    }
}
