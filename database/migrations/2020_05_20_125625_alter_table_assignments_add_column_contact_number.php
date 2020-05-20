<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAssignmentsAddColumnContactNumber extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('assignments', function (Blueprint $table) {
      $table->string('contact_number')->nullable()->after('contact_person');
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
      $table->dropColumn('contact_number');
    });
  }
}
