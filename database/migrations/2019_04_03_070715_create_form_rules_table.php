<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('10_form_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned()->index();
            $table->foreign('form_id')->references('id')->on('9_forms')->onDelete('cascade');
            $table->integer('order');
            $table->string('name');
            $table->integer('sub_of');
            $table->integer('rule_type');
            $table->integer('result_type')->nullable();
            $table->string('condition')->nullable();
            $table->string('description')->nullable();
            $table->integer('condition_type')->nullable();
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
        Schema::dropIfExists('form_rules');
    }
}
