<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HiringRequestAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    public $oldsponsor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData,$oldsponsor)
    {
        $this->mailData = $mailData;
        $this->oldsponsor = $oldsponsor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->oldsponsor)->view('emails.hiringrequestaccepted');
    }
}
