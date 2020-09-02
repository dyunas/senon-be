<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Assignment;
use App\Mail\AssignmentDue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AssignmentDues;

class CheckAssignmentDueDates extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'due:check';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check assignments for due dates then send notification e-mail';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$date = now();
		$date = Carbon::parse($date);

		$count = Assignment::where('due_date', '<=', now())->where('due_date', '!=', null)->update([
			'due' => 1
		]);

		$emails = array('jonathan.quebral0627@gmail.com', 'liza@senonadjuster.com');

		if ($count > 0) {
			$dues = AssignmentDues::collection(Assignment::where('due', 1)->get());

			foreach ($dues as $due) {
				try {
					Mail::to($emails)->send(new AssignmentDue($due));
				} catch (\Throwable $th) {
					continue;
				}
			}
		}

		dd('checking done');
	}
}
