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

	public $due;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($due)
	{
		$this->due = $due;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('liza@senonadjuster.com')
			->subject('DUE FOR FOLLOW UP: ' . $this->due->adjuster . '/REF. NO.: ' . $this->due->ref_no)
			->view('mailable.assignments_due')->with([
				'due'  => $this->due
			]);
	}
}