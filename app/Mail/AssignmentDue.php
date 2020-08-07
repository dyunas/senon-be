<?php

namespace App\Mail;

use App\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignmentDue extends Mailable
{
	use Queueable, SerializesModels;

	public $assignment;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($assignment)
	{
		$this->assignment = $assignment;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mailable.assignments_due')->with([
			'count' => $this->assignment
		]);
	}
}
