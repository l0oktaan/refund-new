<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('112_considers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_rule_id')->unsigned()->index();
            $table->foreign('form_rule_id')->references('id')->on('10_form_rules')->onDelete('cascade');
            $table->integer('order');
            $table->string('name',250);
            $table->string('description',500)->nullable();
            $table->integer('type');
            $table->string('oper')->nullable();
            $table->string('var1')->nullable();
            $table->string('var2')->nullable();
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
        Schema::dropIfExists('112_considers');
    }
}
