<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDelivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('6_delivers', function (Blueprint $table) {
            //$table->dropColumn('order');
            //$table->string('delivery')->after('refund_id');
            $table->text('detail')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('6_delivers', function (Blueprint $table) {
            //
        });
    }
}
