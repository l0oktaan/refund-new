<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDeliversAddColStartEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('6_delivers', function (Blueprint $table) {
            $table->date('overdue_start_date')->after('delivery_date')->nullable();
            $table->date('overdue_end_date')->after('overdue_start_date')->nullable();
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
