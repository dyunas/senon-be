<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReceivingTableAddCols extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('receivings', function (Blueprint $table) {
      $table->date('created_at')->after('received_date');
      $table->bigInteger('status_list_id')->unsigned()->after('attachment');
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
      $table->dropColumn('created_at');
      $table->dropColumn('status_list_id');
    });
  }
}
