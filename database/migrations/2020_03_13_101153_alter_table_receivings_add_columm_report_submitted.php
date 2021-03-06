<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableReceivingsAddColummReportSubmitted extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('receivings', function (Blueprint $table) {
      $table->bigInteger('report_submitted_id')->unsigned()->after('attachment');
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
      $table->dropColumn('report_submitted');
    });
  }
}
