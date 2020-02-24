<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDepositAddColumnAmountContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('7_deposit_penalties', function (Blueprint $table) {
            $table->double('amount_in_contract')->after('amount')->nullable();
            $table->string('description')->after('amount_in_contract')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('7_deposit_penalties', function (Blueprint $table) {
            //
        });
    }
}
