<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAssignmentAddClaimNum extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('assignments', function (Blueprint $table) {
      $table->string('claim_num')->nullable()->after('ref_no');
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
      $table->dropColumn('claim_num');
    });
  }
}
