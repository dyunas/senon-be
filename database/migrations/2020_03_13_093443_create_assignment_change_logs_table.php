<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentChangeLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('assignment_change_logs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('assignment_id')->unsigned();
      $table->foreign('assignment_id')->references('id')->on('assignments');
      $table->text('log_message');
      $table->timestamp('log_date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('assignment_change_logs');
  }
}
