<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportListsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('report_lists', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('report')->nullable();
      $table->integer('due_in_num_days')->nullable();
      $table->string('notification_msg')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('report_lists');
  }
}
