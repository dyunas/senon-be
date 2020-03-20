<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableReceivingAddForeignKey extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('receivings', function (Blueprint $table) {
      $table->foreign('report_submitted_id')->references('id')->on('report_lists');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('receivings', function (Blueprint $table) {
      $table->dropForeign('report_submitted_id');
    });
  }
}
