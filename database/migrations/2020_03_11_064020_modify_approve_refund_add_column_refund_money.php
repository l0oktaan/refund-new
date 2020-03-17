<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyApproveRefundAddColumnRefundMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('8_approve_refunds', function (Blueprint $table) {
            $table->double('refund_money',15,2)->after('refund_days')->nullable();
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
