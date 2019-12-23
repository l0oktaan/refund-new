<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('14_refund_files', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('refund_id')->unsigned()->index();
            $table->foreign('refund_id')->references('id')->on('2_refunds')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->string('upload_by')->nullable();
            $table->tinyInteger("status")->nullable();
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
        Schema::dropIfExists('refund_files');
    }
}
