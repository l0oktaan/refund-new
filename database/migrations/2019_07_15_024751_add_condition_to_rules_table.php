<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConditionToRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('10_form_rules', function (Blueprint $table) {
            // $table->string('condition')->after('result_type')->nullable();
            // $table->integer('condition_type')->after('condition')->nullable();
            // $table->string('description')->after('condition_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('10_form_rules', function (Blueprint $table) {
            //
        });
    }
}
