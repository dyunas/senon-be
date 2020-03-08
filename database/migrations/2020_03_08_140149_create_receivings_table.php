<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('receivings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('assignment_id')->unsigned();
      $table->string('attachment');
      $table->string('received_by', 20);
      $table->date('received_date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('receivings');
  }
}
