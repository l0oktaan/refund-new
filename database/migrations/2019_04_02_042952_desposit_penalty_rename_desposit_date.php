<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DespositPenaltyRenameDespositDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('7_deposit_penalties', function (Blueprint $table) {
            $table->renameColumn('date','deposit_date');
            $table->renameColumn('no','deposit_no');

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
