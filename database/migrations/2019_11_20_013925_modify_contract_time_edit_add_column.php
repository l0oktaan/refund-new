<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyContractTimeEditAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('5_contract_time_edits', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->decimal('edit_budget',15,2)->after('edit_days');
            $table->date('contract_end_dates')->after('edit_budget');
            $table->string('approve_type')->after('contract_end_date');
            $table->string('approve_case')->after('approve_type');
            $table->date('problem_end_date')->after('appprove_case');
            $table->date('book_date')->after('problem_end_date');
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
            $table->dropColumn('edit_budgets');
            $table->dropColumn('contract_end_date');
            $table->dropColumn('approve_type');
            $table->dropColumn('appprove_case');
            $table->dropColumn('problem_end_date');
            $table->dropColumn('book_date');
        });
    }
}
