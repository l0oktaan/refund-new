<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTimeEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('5_contract_time_edits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_id')->unsigned()->index();
            $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
            $table->date('approve_date');
            $table->string('edit_type');
            $table->string('edit_detail')->nullable();
            $table->integer('edit_days');
            $table->decimal('edit_budget',15,2);
            $table->date('contract_end_date');
            $table->string('approve_type');
            $table->string('approve_other_desc')->nullable();
            $table->tinyInteger('approve_other_type')->nullable();
            $table->string('approve_case')->nullable();
            $table->date('problem_end_date');
            $table->date('book_date');
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
        Schema::dropIfExists('contract_time_edits');
    }
}
