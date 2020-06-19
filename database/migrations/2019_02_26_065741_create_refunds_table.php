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
            $table->integer('office_id')->unsigned()->index();
            $table->foreign('office_id')->references('id')->on('1_offices')->onDelete('cascade');
            $table->string('approve_code');
            $table->date('create_date');
            $table->date('sent_date')->nullable();
            $table->date('consider_date')->nullable();
            $table->string('consider_by',50)->nullable();
            $table->date('return_date')->nullable();
            $table->string('return_by',50)->nullable();
            $table->text('return_description')->nullable();
            $table->date('draft_date')->nullable();
            $table->string('draft_by',50)->nullable();
            $table->text('draft_description')->nullable();
            $table->date('director_date')->nullable();
            $table->string('director_by',50)->nullable();
            $table->text('director_description')->nullable();
            $table->date('discuss_date')->nullable();
            $table->string('discuss_by',50)->nullable();
            $table->text('discuss_description')->nullable();
            $table->date('complete_date')->nullable();
            $table->string('complete_by',50)->nullable();
            $table->text('complete_description')->nullable();
            $table->tinyInteger('status')->nullable();
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
