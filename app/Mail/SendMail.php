<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
	
	public $mailData;
	public $viewMail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData,$viewMail)
    {
        $this->mailData = $mailData;
        $this->viewMail = $viewMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->viewMail);
    }
}
