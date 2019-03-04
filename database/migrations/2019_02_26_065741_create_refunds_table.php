<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('2_refunds', function (Blueprint $table) {
            $table->increments('id')->unsigned()->unique();
            $table->string('office_code');
            $table->foreign('office_code')->references('code')->on('1_offices')->onDelete('cascade');
            $table->string('approve_code');
            $table->date('create_date');
            $table->date('sent_date');
            $table->date('complate_date');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('refunds');
    }
}
