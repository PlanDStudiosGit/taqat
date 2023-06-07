<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaborHiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $hiring_sponsor_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData,$hiring_sponsor_email)
    {
        $this->mailData = $mailData;
        $this->hiring_sponsor_email = $hiring_sponsor_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->hiring_sponsor_email)->subject('Labor Hiring Mail')->view('emails.laborhiringmail');
    }
}
