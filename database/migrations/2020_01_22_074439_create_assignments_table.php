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
			$table->date('date_inspected')->nullable();
			$table->string('insurer')->nullable();
			$table->string('broker')->nullable();
			$table->string('claim_no')->nullable();
			$table->string('ref_no')->nullable();
			$table->string('name_insured')->nullable();
			$table->string('adjuster')->nullable();
			$table->string('third_party')->nullable();
			$table->string('pol_no')->nullable();
			$table->string('pol_type')->nullable();
			$table->string('risk_location')->nullable();
			$table->string('nature_loss')->nullable();
			$table->date('date_loss')->nullable();
			$table->string('contact_person')->nullable();
			$table->string('loss_reserve')->nullable();
			$table->bigInteger('status_list_id')->unsigned();
			$table->string('status_of_adjusment')->nullable();
			$table->string('risk')->nullable();
			$table->decimal('value_of_risk', 12, 2)->nullable();
			$table->decimal('amount_of_insurance', 12, 2)->nullable();
			$table->decimal('recommended_payable', 12, 2)->nullable();
			$table->date('date_of_adjustment')->nullable();
			$table->text('remarks')->nullable()->nullable();
			$table->string('created_by');
			$table->string('updated_by')->nullable();
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