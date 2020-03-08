<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReceivingTableAddConstraint extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('receivings', function (Blueprint $table) {
      $table->foreign('assignment_id')->references('id')->on('assignments');
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
      $table->dropForeign('assignment_id');
    });
  }
}
