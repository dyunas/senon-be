<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAssignmentsAddForeignKey extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('assignments', function (Blueprint $table) {
      $table->foreign('status_list_id')->references('id')->on('status_lists');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('assignments', function (Blueprint $table) {
      $table->dropForeign('status_list_id');
    });
  }
}
