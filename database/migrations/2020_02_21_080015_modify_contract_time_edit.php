<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyContractTimeEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('5_contract_time_edits', function (Blueprint $table) {
            $table->dropColumn('contract_end_date');
            $table->date('edit_start_date')->after('edit_days')->nullable();
            $table->date('edit_end_date')->after('edit_start_date')->nullable();
            $table->date('book_date')->nullable()->change();
            $table->date('problem_end_date')->nullable()->change();
            $table->integer('edit_days')->nullable()->change();
            $table->decimal('edit_budget')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('5_contract_time_edits', function (Blueprint $table) {
            //
        });
    }
}
