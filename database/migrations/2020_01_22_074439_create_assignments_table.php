<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('assignments', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->date('date_assigned')->nullable();
      $table->string('insurer', 20)->nullable();
      $table->string('broker', 20)->nullable();
      $table->string('ref_no', 32)->nullable();
      $table->string('name_insured')->nullable();
      $table->string('adjuster', 50)->nullable();
      $table->string('third_party', 50)->nullable();
      $table->string('pol_no', 32)->nullable();
      $table->string('pol_type', 50)->nullable();
      $table->string('risk_location')->nullable();
      $table->string('nature_loss', 50)->nullable();
      $table->date('date_loss')->nullable();
      $table->string('contact_person')->nullable();
      $table->decimal('loss_reserve', 10, 2)->nullable();
      $table->bigInteger('status_list_id')->unsigned();
      $table->text('remarks')->nullable()->nullable();
      $table->string('created_by', 100);
      $table->string('updated_by', 100)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('assignments');
  }
}
