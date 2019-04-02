<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAprroveRefundDayToDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('8_approve_refunds', function (Blueprint $table) {
            $table->renameColumn('approve_refund_day','approve_refund_days');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('8_approve_refunds', function (Blueprint $table) {
            //
        });
    }
}
