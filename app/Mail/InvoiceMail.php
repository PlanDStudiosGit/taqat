<?php

namespace App\Mail;

use App\Models\invoiceDetailsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoiceData;
    // public $hiring_sponsor_email;  
    public $myinvoice;
    public $pdfUrl;
    public $taqat_payment;
   


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoiceData,$myinvoice,$pdfUrl,$taqat_payment)
    {
        $this->invoiceData = $invoiceData;
        $this->myinvoice = $myinvoice;
        $this->pdfUrl = $pdfUrl;
        $this->taqat_payment=$taqat_payment;


    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return  $this->from('admin@taqat.com')->view('emails.invoicemail');
    }
}
